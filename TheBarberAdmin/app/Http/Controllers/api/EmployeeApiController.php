<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Template;
use App\Notification;
use App\AdminSetting;
use App\Employee;
use App\AppNotification;
use Auth;
use Hash;
use Config;
use App\Mail\BookingStatus;
use App\Mail\EmpBookingStatus;

class EmployeeApiController extends Controller
{
    // Login
    public function login(Request $request) {
        
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        
        $empdata = array(
            'email' => $request->email,
            'password' => $request->password,
        );
      
        if (Auth::guard('emp')->attempt($empdata)) 
        {
            $emp = Auth::guard('emp')->user();

            if($emp->isdelete == 1){
                return response()->json(['msg' => "You are deleted", 'success' => false], 200);
            }
            
            if($emp->status == 0){
                return response()->json(['msg' => "You are blocked by owner", 'success' => false], 200);
            }

            if(isset($request->device_token)) {
                $emp->device_token = $request->device_token;
                $emp->save();
            }
            $emp['token'] =  $emp->createToken('thebarber')->accessToken;
            return response()->json(['data' => $emp, 'success' => true], 200);
        }
        else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }

    // All Appointment 
    public function allAppointment() {
        $emp_id = Auth::guard('empApi')->user()->emp_id;

        $master['completed'] = Booking::where([['emp_id',$emp_id],['booking_status','Completed']])
        ->orderBy('id', 'DESC')->get();

        $master['cancel'] = Booking::where([['emp_id',$emp_id],['booking_status','Cancel']])
        ->orderBy('id', 'DESC')->get();

        $master['approved'] = Booking::where([['emp_id',$emp_id],['booking_status','Approved']])
        ->orderBy('id', 'DESC')->get();

        $master['pending'] = Booking::where([['emp_id',$emp_id],['booking_status','Pending']])
        ->orderBy('id', 'DESC')->get();

        return response()->json(['msg' => 'User Appointments', 'data' => $master, 'success' => true], 200);
    }
    
    // All Appointment for dashboard count
    public function dashboard() {
        $emp_id = Auth::guard('empApi')->user()->emp_id;

        $master['completed'] = Booking::where([['emp_id',$emp_id],['booking_status','Completed']])
        ->orderBy('id', 'DESC')->count();

        $master['cancel'] = Booking::where([['emp_id',$emp_id],['booking_status','Cancel']])
        ->orderBy('id', 'DESC')->count();

        $master['approved'] = Booking::where([['emp_id',$emp_id],['booking_status','Approved']])
        ->orderBy('id', 'DESC')->count();

        $master['pending'] = Booking::where([['emp_id',$emp_id],['booking_status','Pending']])
        ->orderBy('id', 'DESC')->count();

        return response()->json(['msg' => 'User Appointments', 'data' => $master, 'success' => true], 200);
    }
     
    // All Appointment for dashboard filter
    public function dashboard_filter(Request $request) {
        $request->validate([
            'start_date' => 'bail|required',
            'end_date' => 'bail|required|after:start_date',
        ]);
        
        $from = $request->start_date;
        $to = $request->end_date;

        $emp_id = Auth::guard('empApi')->user()->emp_id;

        $master['completed'] = Booking::where([['emp_id',$emp_id],['booking_status','Completed']])
        ->whereBetween('date', [$from, $to])
        ->orderBy('id', 'DESC')->count();

        $master['cancel'] = Booking::where([['emp_id',$emp_id],['booking_status','Cancel']])
        ->whereBetween('date', [$from, $to])
        ->orderBy('id', 'DESC')->count();

        $master['approved'] = Booking::where([['emp_id',$emp_id],['booking_status','Approved']])
        ->whereBetween('date', [$from, $to])
        ->orderBy('id', 'DESC')->count();

        $master['pending'] = Booking::where([['emp_id',$emp_id],['booking_status','Pending']])
        ->whereBetween('date', [$from, $to])
        ->orderBy('id', 'DESC')->count();

        return response()->json(['msg' => 'User Appointments', 'data' => $master, 'success' => true], 200);
    }

    // Profile
    public function profile() {

        $emp = Employee::find(Auth::guard('empApi')->user()->emp_id);
        $emp->fullImagePath = url('storage/images/employee/'.$emp->image);
        return response()->json(['msg' => 'Show Profile', 'data' => $emp, 'success' => true], 200);
    }

    // Edit Profile
    public function editProfile(Request $request) {
        $request->validate([
            'name' => 'bail|required',
            'image' => '',
            'phone' => 'bail|required|numeric',
        ]);

        $emp = Employee::find(Auth::guard('empApi')->user()->emp_id);
        $emp->name = $request->name;
        $emp->phone = $request->phone;
        
        if(isset($request->image))
        {
            if($emp->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/storage/images/employee/'. $emp->image))){
                    \File::delete(public_path('/storage/images/employee/'. $emp->image));
                }
            }
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "emp_". time() . ".png";
            $file = public_path('/storage/images/employee/') . $name;

            $success = file_put_contents($file, $data1);
            $emp->image = $name;
        }

        $emp->save();
        return response()->json(['msg' => 'Emp updated', 'data' => $emp, 'success' => true], 200);
    }

    // changePassword
    public function changePassword(Request $request) {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8','same:new_password'],
        ]);

        if (Hash::check($request->old_password, Auth::guard('empApi')->user()->password))
        {
            $password = Hash::make($request->new_password);
            Employee::find(Auth::guard('empApi')->user()->emp_id)->update(['password'=>$password]);
            return response()->json(['msg' => 'changed', 'data' => null, 'success' => true], 200);
        }
        else{
            return response()->json(['msg' => 'not changed', 'data' => null, 'success' => false], 200);
        }
    }

    public function singleAppointment($id) {
        $booking = Booking::find($id);
        return response()->json(['msg' => 'Single Appointment', 'data' => $booking, 'success' => true], 200);
    }

    public function statusChange(Request $request) {

        $request->validate([
            'bookingId' => ['required'],
            'status' => ['required'],
        ]);
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
            $message = str_replace($data, $emp_detail, $emp_booking_status->msg_content);

            $emp_not->msg = $message;
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
                        $message,
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

    public function notification() {
        $not = AppNotification::where([['emp_id', Auth::guard('empApi')->user()->emp_id]])
        ->orderBy('id','desc')
        ->get();
        return response()->json(['msg' => 'Notifications', 'data' => $not, 'success' => true], 200);
    }

    public function ClearNotification(){
        $not = AppNotification::where([['emp_id', Auth::guard('empApi')->user()->emp_id]])
        ->get()->each->delete();
        return response()->json(['msg' => 'Delete Notifications', 'success' => true], 200);
    }
    
    public function appSetting()
    {
        $settings = AdminSetting::find(1,['mapkey','employee_project_no','employee_app_id','project_no','app_id','currency','currency_symbol']);
        $settings->project_no = $settings->employee_project_no;
        $settings->app_id = $settings->employee_app_id;
        return response()->json(['msg' => 'settings', 'data' => $settings, 'success' => true], 200);
    }
}