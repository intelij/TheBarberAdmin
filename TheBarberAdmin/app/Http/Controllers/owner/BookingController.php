<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Salon;
use App\Booking;
use App\Coupon;
use App\Service;
use App\User;
use App\Employee;
use App\Address;
use DateTime;
use Config;
use Carbon\Carbon;
use App\AdminSetting;
use OneSignal;
use App\Notification;
use App\Template;
use App\AppNotification;
use App\Mail\BookingStatus;
use App\Mail\PaymentStatus;
use App\Mail\CreateAppointment;
use App\Mail\AppCreateAppointment;
use App\Mail\EmpAppCreateAppointment;
use App\Mail\EmpBookingStatus;

class BookingController extends Controller
{
    public function index()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $bookings = Booking::where('salon_id', $salon->salon_id)
        ->orderBy('id','DESC')
        ->paginate(8);
        $symbol = AdminSetting::find(1)->currency_symbol;
        $users = User::where([['status',1],['role',3]])->get();
        $services = Service::where([['salon_id',$salon->salon_id],['status',1]])->get();
        $emps = Employee::where([['status',1],['salon_id',$salon->salon_id]])->get();
        $give_service = Salon::where('owner_id',Auth()->user()->id)->first()->give_service;

        return view('owner.pages.booking', compact('give_service','bookings','symbol','users','services','emps','give_service'));
    }

    public function invoice($id)
    {
        $booking = Booking::find($id);
        $symbol = AdminSetting::find(1)->currency_symbol;
        return view('owner.booking.invoice', compact('booking','symbol'));
    }

    public function invoice_print($id)
    {
        $booking = Booking::find($id);
        $symbol = AdminSetting::find(1)->currency_symbol;
        return view('owner.booking.invoicePrint', compact('booking','symbol'));
    }

    public function create()
    {
        $salon_id = Salon::where('owner_id',Auth()->user()->id)->first()->salon_id;
        $services = Service::where('salon_id',$salon_id)->get();
        $users = User::where([['status',1],['role',3]])->get();
        $emps = Employee::where([['status',1],['salon_id',$salon_id]])->get();

        return view('owner.booking.create', compact('services','users','emps'));
    }

    public function paymentcount(Request $request)
    {
        $data['price'] = Service::whereIn('service_id',$request->ser_id)->sum('price');
        $data['time'] = Service::whereIn('service_id',$request->ser_id)->sum('time');
        if($request->booking_at == "Home"){
            $data['price'] = $data['price'] + Salon::where('owner_id',Auth()->user()->id)->first()->home_charges;
        }
       
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Single Service'], 200);
    }

    public function addressSelect(Request $request){
        $address = Address::where('user_id',$request->user_id)->get();
        return response()->json(['success' => true,'data' => $address, 'msg' => 'Adresses of user'], 200);
    }

    public function timeslot(Request $request)
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();

        $master = array();
        $day = strtolower(Carbon::parse($request->date)->format('l'));
        $salon = Salon::find($salon->salon_id)->$day;
        $start_time = new Carbon($request['date'].' '.$salon['open']);

        $end_time = new Carbon($request['date'].' '.$salon['close']);
        $diff_in_minutes = $start_time->diffInMinutes($end_time);
        for ($i=0; $i <= $diff_in_minutes; $i+=30) {  
            if($start_time >= $end_time ){
                break;
            }else{
                $temp['start_time']=$start_time->format('h:i A');
                $temp['end_time']=$start_time->addMinutes('30')->format('h:i A');
                if(Carbon::parse($request->date)->format('Y-m-d') == date('Y-m-d')){
                    if(strtotime(date("h:i A")) < strtotime($temp['start_time'])){
                        array_push($master,$temp);
                    }
                } else {
                    array_push($master,$temp);
                }
            }
        }
        
        if(count($master) == 0)
        {
            return response()->json(['msg' => 'Day off', 'success' => false], 200);
        }
        else
        {
            return response()->json(['msg' => 'Time slots', 'data' => $master, 'success' => true], 200);
        }
    }

    public function selectemployee(Request $request)
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();

        $emp_array = array();
        
        $emps_all = Employee::where([['salon_id',$salon->salon_id],['status',1],['give_service',$request->booking_at]])
        ->orWhere([['salon_id',$salon->salon_id],['status',1],['give_service','Both']])
        ->get();

        $book_service = $request->service;
        
        $duration = Service::whereIn('service_id', $book_service)->sum('time') - 1;
        foreach ($emps_all as $emp)
        {
            $emp_service = json_decode($emp->service_id);
            foreach($book_service as $ser)
            {
                if (in_array($ser, $emp_service))
                {
                    array_push($emp_array,$emp->emp_id);
                }
            }
        }
        $master =  array();
        $emps = Employee::whereIn('emp_id',$emp_array)->get();
        
        $time = new Carbon($request['date'].' '.$request['start_time']);
        $day = strtolower(Carbon::parse($request->date)->format('l'));
        $date = $request->date;
        
        foreach($emps as $emp)
        {
            $employee = $emp->$day;
            $start_time = new Carbon($request['date'].' '.$employee['open']);
            $end_time = new Carbon($request['date'].' '.$employee['close']);
            $end_time = $end_time->subMinutes(1);
            
            if($time->between($start_time, $end_time))
            {
                array_push($master,$emp);
            }
        }
        $emps_final = array();
        foreach($master as $emp)
        {
            $booking = Booking::where([['emp_id',$emp->emp_id],['date',$date],['booking_status','Approved']])
            ->orWhere([['emp_id',$emp->emp_id],['date',$date],['booking_status','Pending']])
            ->get();
            $emp->push = 1;
            foreach($booking as $book) {
                $start = \DateTime::createFromFormat('H:i a', $book->start_time);
                $end = \DateTime::createFromFormat('H:i a', $book->end_time);
                $now = \DateTime::createFromFormat('H:i a', $request['start_time']);
                if ($now >= $start && $now <= $end) {
                    $emp->push = 0;
                    break;
                }
            }
            if($emp->push == 1)
                array_push($emps_final,$emp);
        }
        $new = array();
        foreach($emps_final as $emp)
        {
            array_push($new,$emp->emp_id);
        }
        $emps_final_1 = Employee::whereIn('emp_id',$new)->get();
        if(count($emps_final_1) > 0) {
            return response()->json(['msg' => 'Employees', 'data' => $emps_final_1, 'success' => true], 200);
        } 
        else {
            return response()->json(['msg' => 'No employee available at this time', 'success' => false], 200);
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'bail|required',
            'user_id' => 'bail|required',
            'service_id' => 'bail|required',
            'date' => 'bail|required',
            'start_time' => 'bail|required',
            'payment' => 'bail|required|numeric',
            'emp_id' => 'bail|required',
            'booking_at' => 'bail|required',
            'address_id' => 'required_if:booking_at,Home',
        ]);

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $booking = new Booking();
        
        $services =  str_replace('"', '',json_encode($request->service_id));
        $booking->service_id = $services;
        $duration = Service::whereIn('service_id', $request->service_id)->sum('time');
        
        $start_time = new Carbon($request['date'].' '.$request['start_time']);
        $booking->end_time = $start_time->addMinutes($duration)->format('h:i A');
        $booking->salon_id = $salon->salon_id;
        $booking->emp_id = $request->emp_id;
        $booking->start_time = $request->start_time;
        $booking->date = $request->date;
        $booking->payment_type = "LOCAL";
        $booking->booking_status = "Approved";
        $booking->user_id = $request->user_id;
        $booking->payment = $request->payment;
        $booking->booking_id = $request->booking_id;
        $booking->booking_at = $request->booking_at;
        
        if($request->booking_at == "Home"){

            $booking->extra_charges = $salon->home_charges;
            $booking->address_id = $request->address_id;
        }
        else {
            $booking->extra_charges = 0;
            $booking->address_id = null;
        }

        $setting = AdminSetting::find(1);

        if ($setting->commission_type == "Percentage")
        {
            $commission = ($booking->payment * $setting->commission_amount)/100;
            $salon_income = $booking->payment - $commission;
        }
        elseif($setting->commission_type == "Amount")
        {
            $commission = $setting->commission_amount;
            $salon_income = $booking->payment - $commission;
        }
        
        $booking->commission = $commission;
        $booking->salon_income = $salon_income;

        if(config('point.active') == 1){
            $user = User::find($request->user_id);
            if($setting->is_point == 1){
                $add = 0;
                if($booking->booking_at == "Home"){
                    $tot = $booking->payment - $booking->extra_charges;
                    if($tot >= $setting->min_amount)
                        $add = ($tot * $setting->point) / $setting->min_amount;
                } else {
                    if($booking->payment >= $setting->min_amount)
                        $add = ($booking->payment * $setting->point) / $setting->min_amount;
                }
                $user->total_points = $user->total_points + $add;
                $user->remain_points = $user->remain_points + $add;
                $user->save();
                $booking->points = $add;
            }
        }

        $booking->save();

        $create_appointment = Template::where('title','Create Appointment')->first();
        $app_create_appointment = Template::where('title','App Create Appointment')->first();
        $emp_app_create_appointment = Template::where('title','Employee Appointment')->first();

        $not = new Notification();
        $not->booking_id = $booking->id;
        $not->user_id = $booking->user_id;
        $not->title = $create_appointment->subject;

        $detail['UserName'] = $booking->user->name;
        $detail['Date'] = $booking->date;
        $detail['Time'] = $booking->start_time;
        $detail['BookingId'] = $booking->booking_id;
        $detail['SalonName'] = $booking->salon->name;
        $detail['BookingAt'] = $booking->booking_at;
        $detail['EmployeeName'] = $booking->employee->name;
        $detail['AppName'] = AdminSetting::first()->app_name;

        $data = ["{{UserName}}", "{{Date}}","{{Time}}","{{BookingId}}","{{SalonName}}","{{BookingAt}}","{{EmployeeName}}","{{AppName}}"];
        $message = str_replace($data, $detail, $create_appointment->msg_content);
        $not->msg = $message;
        $not->save();

        $app_not = new AppNotification();
        $app_not->booking_id = $booking->id;
        $app_not->user_id = $booking->user_id;
        $app_not->salon_id = $booking->salon->salon_id;
        $app_not->title = $app_create_appointment->subject;

        $detail_app['SalonOwner'] = Auth()->user()->name;
        $detail_app['UserName'] = $booking->user->name;
        $detail_app['Date'] = $booking->date;
        $detail_app['Time'] = $booking->start_time;
        $detail_app['SalonName'] = $booking->salon->name;
        $detail_app['BookingAt'] = $booking->booking_at;
        $detail_app['EmployeeName'] = $booking->employee->name;
        $detail_app['BookingId'] = $booking->booking_id;
        $detail_app['AppName'] = AdminSetting::first()->app_name;
       
        $app_data = ["{{SalonOwner}}", "{{UserName}}","{{Date}}","{{Time}}","{{SalonName}}","{{BookingAt}}","{{EmployeeName}}","{{BookingId}}","{{AppName}}"];
        $app_message = str_replace($app_data, $detail_app, $app_create_appointment->msg_content);
        $app_not->msg = $app_message;
        $app_not->save();

        $emp_app_not = new AppNotification();
        $emp_app_not->booking_id = $booking->id;
        $emp_app_not->user_id = $booking->user_id;
        $emp_app_not->salon_id = $booking->salon->salon_id;
        $emp_app_not->emp_id = $booking->employee->emp_id;
        $emp_app_not->title = $emp_app_create_appointment->subject;

        $emp_detail_app['EmployeeName'] = $booking->employee->name;
        $emp_detail_app['UserName'] = $booking->user->name;
        $emp_detail_app['Date'] = $booking->date;
        $emp_detail_app['Time'] = $booking->start_time;
        $emp_detail_app['SalonName'] = $booking->salon->name;
        $emp_detail_app['BookingAt'] = $booking->booking_at;
        $emp_detail_app['BookingId'] = $booking->booking_id;
        $emp_detail_app['AppName'] = AdminSetting::first()->app_name;
         
        $emp_app_data = ["{{EmployeeName}}", "{{UserName}}","{{Date}}","{{Time}}","{{SalonName}}","{{BookingAt}}","{{BookingId}}","{{AppName}}"];
        $emp_app_message = str_replace($emp_app_data, $emp_detail_app, $emp_app_create_appointment->msg_content);
        $emp_app_not->msg = $emp_app_message;
        $emp_app_not->save();


        $mail_enable = AdminSetting::first()->mail;
        $notification_enable = AdminSetting::first()->notification;

        if($mail_enable == 1)
        {
            try{
                Mail::to($booking->user->email)->send(new CreateAppointment($create_appointment->mail_content,$detail,$create_appointment->subject));
            }
            catch (\Throwable $th) {}
        }
        if($notification_enable == 1 && $booking->user->device_token != null)
        {
            try{
                Config::set('onesignal.app_id', env('APP_ID'));
                Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
                Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));
                OneSignal::sendNotificationToUser(
                    $message,
                    $booking->user->device_token,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null,
                    $create_appointment->subject
                );
            }
            catch (\Throwable $th) {}
        }
        if(Auth()->user()->mail == 1)
        {
            try{
                Mail::to(Auth()->user()->email)->send(new AppCreateAppointment($app_create_appointment->mail_content,$detail_app,$app_create_appointment->subject));
                Mail::to($booking->employee->email)->send(new EmpAppCreateAppointment($emp_app_create_appointment->mail_content,$emp_detail_app,$emp_app_create_appointment->subject));
            }
            catch (\Throwable $th) {}
        }
        if(Auth()->user()->notification == 1)
        {
            if(Auth()->user()->device_token != null)
            {
                try{
                    Config::set('onesignal.app_id', env('OWNER_APP_ID'));
                    Config::set('onesignal.rest_api_key', env('OWNER_REST_API_KEY'));
                    Config::set('onesignal.user_auth_key', env('OWNER_USER_AUTH_KEY'));
                    OneSignal::sendNotificationToUser(
                        $app_message,
                        Auth()->user()->device_token,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null,
                        $app_create_appointment->subject
                    );
                }
                catch (\Throwable $th) {}
            }
            if($booking->employee->device_token != null)
            {
                try{
                    Config::set('onesignal.app_id', env('EMPLOYEE_APP_ID'));
                    Config::set('onesignal.rest_api_key', env('EMPLOYEE_REST_API_KEY'));
                    Config::set('onesignal.user_auth_key', env('EMPLOYEE_USER_AUTH_KEY'));
                    OneSignal::sendNotificationToUser(
                        $emp_app_message,
                        $booking->employee->device_token,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null,
                        $emp_app_create_appointment->subject
                    );
                }
                catch (\Throwable $th) {}
            }
        }

        return response()->json(['msg' => 'Booking successfully', 'data' => $booking, 'success' => true], 200);
    }
    
    public function show($id)
    {
        $data['booking'] = Booking::with('user')->find($id);
        $data['symbol'] = AdminSetting::find(1)->currency_symbol;     
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Appointment show'], 200);
    }

    public function changeStatus(Request $request)
    {
        $booking = Booking::find($request->bookingId);   
        $booking->booking_status = $request->status;
        if($request->status == "Completed")
        {
            $booking->payment_status = 1;
        }
        $booking->save();

        $user = User::find($booking->user_id);

        $booking_status = Template::where('title','Booking status')->first();

        $not = new Notification();
        $not->booking_id = $request->bookingId;
        $not->user_id = $booking->user_id;
        $not->title = $booking_status->subject;

        $detail['UserName'] = $booking->user->name;
        $detail['Date'] = $booking->date;
        $detail['Time'] = $booking->start_time;
        $detail['BookingId'] = $booking->booking_id;
        $detail['SalonName'] = $booking->salon->name;
        $detail['BookingStatus'] = $booking->booking_status;
        $detail['AppName'] = AdminSetting::first()->app_name;
        
        $data = ["{{UserName}}", "{{Date}}","{{Time}}","{{BookingId}}","{{SalonName}}","{{BookingStatus}}"];
        $message = str_replace($data, $detail, $booking_status->msg_content);

        $not->msg = $message;
        $title = "Appointment ".$booking->booking_status;
        
        $not->save();
        $mail_enable = AdminSetting::first()->mail;
        $notification_enable = AdminSetting::first()->notification;

        if($mail_enable)
        {
            try{
                Mail::to($booking->user->email)->send(new BookingStatus($booking_status->mail_content,$detail,$booking_status->subject));
            }
            catch (\Throwable $th) {}
        }
        if($notification_enable && $user->device_token != null)
        {
            try{
                Config::set('onesignal.app_id', env('APP_ID'));
                Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
                Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));
                OneSignal::sendNotificationToUser(
                    $message,
                    $user->device_token,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null,
                    $title
                );
            }
            catch (\Throwable $th) {}
        }
        // For emp
        if($request->status == "Completed" || $request->status == "Cancel")
        {
            $emp_booking_status = Template::where('title','Employee booking status')->first();

            $emp_not = new AppNotification();
            $emp_not->booking_id = $request->bookingId;
            $emp_not->user_id = $booking->user_id;
            $emp_not->salon_id = $booking->salon_id;
            $emp_not->emp_id = $booking->emp_id;
            $emp_not->title = "Appointment ".$booking->booking_status;

            $emp_detail['EmployeeName'] = $booking->employee->name;
            $emp_detail['UserName'] = $booking->user->name;
            $emp_detail['Date'] = $booking->date;
            $emp_detail['Time'] = $booking->start_time;
            $emp_detail['SalonName'] = $booking->salon->name;
            $emp_detail['BookingAt'] = $booking->booking_at;
            $emp_detail['BookingStatus'] = $booking->booking_status;
            $emp_detail['BookingId'] = $booking->booking_id;
            $emp_detail['AppName'] = AdminSetting::first()->app_name;
            
            $data = ["{{EmployeeName}}", "{{UserName}}","{{Date}}","{{Time}}","{{SalonName}}","{{BookingAt}}","{{BookingStatus}}","{{BookingId}}","{{AppName}}"];
            $emp_message = str_replace($data, $emp_detail, $emp_booking_status->msg_content);

            $emp_not->msg = $emp_message;
            $title = "Appointment ".$booking->booking_status;
            
            $emp_not->save();

            $mail_enable = Auth()->user()->mail;
            $notification_enable = Auth()->user()->notification;

            if($mail_enable)
            {
                try{
                    Mail::to($booking->employee->email)->send(new EmpBookingStatus($emp_booking_status->mail_content,$emp_detail,$emp_booking_status->subject));
                }
                catch (\Throwable $th) {}
            }
            if($notification_enable && $booking->employee->device_token != null)
            {
                try{
                    Config::set('onesignal.app_id', env('EMPLOYEE_APP_ID'));
                    Config::set('onesignal.rest_api_key', env('EMPLOYEE_REST_API_KEY'));
                    Config::set('onesignal.user_auth_key', env('EMPLOYEE_USER_AUTH_KEY'));
                    OneSignal::sendNotificationToUser(
                        $emp_message,
                        $booking->employee->device_token,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null,
                        $title
                    );
                }
                catch (\Throwable $th) {}
            }
        }
        return response()->json(['success' => true, 'msg' => 'Status Changed'], 200);
    }
   
}
