<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Auth;
use Hash;
use Config;
use Redirect;
use App\User;
use App\Salon;
use App\Category;
use App\Service;
use App\Coupon;
use App\Gallery;
use App\Address;
use App\Review;
use App\Booking;
use App\AppNotification;
use App\Employee;
use App\AdminSetting;
use App\Mail\BookingStatus;
use App\Mail\PaymentStatus;
use App\Mail\CreateAppointment;
use App\Mail\AppCreateAppointment;
use App\Mail\EmpAppCreateAppointment;
use OneSignal;
use App\Mail\ForgetPassword;
use App\Template;
use App\Notification;
use Twilio\Rest\Client;

class AdminApiController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
            'device_token' => 'bail|required',
        ]);
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'role' => 2,
        );
        if (Auth::attempt($userdata))
        {
            $user = Auth::user();
            $salon = Salon::where('owner_id', Auth()->user()->id)->first();
            if(!$salon)
            {
                return response()->json(['success' => true, 'data' => $user, 'message' => 'no']);
            }
            else
            {
                if(isset($request->device_token)){
                    $user->device_token = $request->device_token;
                    $user->save();
                }
                $data['token'] =  $user->createToken('thebarber')->accessToken;
                $data['user'] =  $user;

                return response()->json(['success' => true, 'data' => $data, 'message' => 'Login']);
            }
        }
        else
        {      
            return response()->json(['success' => false, 'message' => 'Invalid email or password']);
        }
    }

    // Register
    public function register(Request $request) 
    {   
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
            'code' => ['required'],
            'phone' => ['required', 'numeric'],
        ]);

        $language = AdminSetting::first()->language;
        
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'code' => $request->code,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 2,
                'language' => $language
            ]
        );
        if($user) 
        {
            return response()->json(['success' => true, 'data' => $user, 'message' => 'Owner created successfully!']);
        }else {
            return response()->json(['error' => 'Owner not Created'], 401);
        }
    } 
    
    public function forgetpassword(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = User::where([['role',2],['email',$request->email]])->first();
        if($user)
        {
            if($user->status == 1)
            {
                $password = rand(11111111,99999999);
                $user->password = Hash::make($password);
                $content = Template::where('title','Forgot Password')->first()->mail_content;
                $subject = Template::where('title','Forgot Password')->first()->subject;
                $msg_content = Template::where('title','Forgot Password')->first()->msg_content;
                $detail['UserName'] = $user->name;
                $detail['NewPassword'] = $password;
                $detail['AppName'] = AdminSetting::first()->app_name;
                $user->save();
                if($user->mail == 1)
                {
                    try{                    
                        Mail::to($user->email)->send(new ForgetPassword($content,$detail,$subject));
                    }
                    catch(\Throwable $th){}
                }
                $sms_enable = AdminSetting::first()->sms;
                if($sms_enable == 1) 
                {
                    $sid = AdminSetting::first()->twilio_acc_id;
                    $token = AdminSetting::first()->twilio_auth_token;
                    $data = ["{{UserName}}", "{{NewPassword}}","{{AppName}}"];
                    $message1 = str_replace($data, $detail, $msg_content);
                    try{
                        $client = new Client($sid, $token);
                        
                        $client->messages->create(
                        $user->code.$user->phone,
                        array(
                        'from' => AdminSetting::first()->twilio_phone_no,
                        'body' => $message1
                        )
                        );
                    }
                    catch(\Throwable $th){}
                }
                return response()->json(['msg' => 'Password Changed', 'data' => $user, 'success' => true], 200);   
            }
            else
            {
                return Redirect::back()->withErrors(['You are blocked by Admin']);
            }
        }
        else{
            return Redirect::back()->withErrors(['Invalid email address']);
        }
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8','same:new_password'],
        ]);
        if (Hash::check($request->old_password, Auth::user()->password))
        {
            $password = Hash::make($request->new_password);
            User::find(Auth::user()->id)->update(['password'=>$password]);
            return response()->json(['msg' => 'changed', 'data' => null, 'success' => true], 200);
        }
        else{
            return response()->json(['msg' => 'not changed', 'data' => null, 'success' => false], 200);
        }
    }

    //Edit profile
    public function editProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
            'code' => ['required'],
            'image' => [],
        ]);

        $owner = User::find(Auth()->user()->id);
        if(isset($request->image))
        {
            if($owner->image != "noimage.jpg")
            {
                \File::delete(public_path('/storage/images/users/'. $owner->image));
            }
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "owner_". time() . ".png";
            $file = public_path('storage/images/users/') . $name;
            $success = file_put_contents($file, $data1);
            $owner->image = $name;
        }
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->code = $request->code;
        $owner->phone = $request->phone;
        $owner->save();

        return response()->json(['success' => true, 'data' => $owner, 'message' => 'Edit successfull!']);
    }

    // Show Profile
    public function showProfile()
    {
        $owner = User::find(Auth()->user()->id);
        return response()->json(['success' => true, 'data' => $owner, 'message' => 'Show Owner']);

    }

    
    // ********************************  Dashboard Start ********************************************

    // Dashboard
    public function dashboard()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $s_id = $salon->salon_id;
        
        //Total Income
        $data['income'] = Booking::where([['salon_id', $s_id],['payment_status',1],['booking_status','!=','Cancel']])->sum('salon_income');
        // Currency
        $data['setting'] = AdminSetting::find(1,['currency','currency_symbol']);

        // Total Services
        $data['service'] = Service::where([['status',1],['salon_id',$s_id],['isdelete',0]])->count();
        
        // Total users
        $booking = Booking::where('salon_id',$s_id)->get();
        $ar = array();
        foreach($booking as $user)
        {
            array_push($ar,$user->user_id);
        }
        $data['users'] = User::whereIn('id',$ar)->count();

        // Total Employee
        $data['employee'] = Employee::where([['status',1],['salon_id',$s_id]])->count();

        // Total Appointments
        $data['appointment'] = Booking::where('salon_id',$s_id)->count();

        // Pending Appointment
        $data['pending_appointment'] = Booking::where([['booking_status','Pending'],['salon_id',$s_id]])->count();
        
        // Approved Appointment
        $data['approved_appointment'] = Booking::where([['booking_status','Approved'],['salon_id',$s_id]])->count();

        // Cancel Appointment
        $data['cancel_appointment'] = Booking::where([['booking_status','Cancel'],['salon_id',$s_id]])->count();

        return response()->json(['success' => true, 'data' => $data, 'message' => 'Dashboard Data']);

    }

 
    // ********************************  Client / User Start ********************************************

    // All salon Clients
    public function clients()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $bookings = Booking::where('salon_id',$salon->salon_id)->get();
        $ar = array();
        foreach ($bookings as $user)
        {
            array_push($ar,$user->user_id);
        }
        $user_added = User::where('added_by',$salon->salon_id)->get();
        foreach($user_added as $user1)
        {
            array_push($ar,$user1->id);
        }
        $clients = User::whereIn('id',$ar)->get();

        return response()->json(['success' => true, 'data' => $clients, 'message' => 'All Clients']);
    }

    // All 
    public function allClients()
    {
        $allClients = User::where([['status',1],['role',3]])->get();
        return response()->json(['success' => true, 'data' => $allClients, 'message' => 'All Clients']);
    }

    // Add client/user
    public function addClient(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'phone' => 'bail|required|numeric',
            'code' => 'bail|required',
            'password' => 'bail|required|min:8'
        ]);

        $salon = Salon::where('owner_id',Auth::user()->id)->first();
        $salon_id = $salon->salon_id;
        $setting = AdminSetting::find(1);
        $user = new User();
        $user->name = $request->name;
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($permitted_chars), 0, 6);
        $user->referral_code = $code;
        if(config('point.active') == 1){
            if(isset($request->friend_code)){
                $find_user = User::where('referral_code',$request->friend_code)->first();
                if(isset($find_user)){
                    $user->referred_by = $find_user->id;
                    if($setting->is_point == 1){
                        $find_user->total_points = $find_user->total_points + $setting->referral_point;
                        $find_user->remain_points = $find_user->remain_points + $setting->referral_point;
                        $find_user->save();
                    }
                }
            }
        }
        $user->email = $request->email;
        $user->code = '+'.$request->code;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->added_by = $salon_id;
        $user->otp = rand(1111,9999);
        $user->verify = 1;
        $user->language = $setting->language;
        $user->save();

        if($user) 
        {
            return response()->json(['success' => true, 'data' => $user, 'message' => 'User created successfully!']);
        }else {
            return response()->json(['error' => 'User not Created'], 401);
        }
    }

    // Show Client
    public function showClient($id)
    {
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        $data['user'] = User::find($id);
        $data['all_booking'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id]])->get();
        $data['pending'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['booking_status','Pending']])->count();
        $data['completed'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['booking_status','Completed']])->count();
        $data['cancel'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['booking_status','Cancel']])->count();
        $data['approved'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['booking_status','Approved']])->count();
        $data['total_sales'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',1],['booking_status','Completed']])
        ->orWhere([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',1],['booking_status','Pending']])
        ->orWhere([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',1],['booking_status','Approved']])
        ->count();
        $data['outstanding'] = Booking::where([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',0],['booking_status','Completed']])
        ->orWhere([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',0],['booking_status','Pending']])
        ->orWhere([['salon_id',$salon->salon_id],['user_id',$data['user']->id],['payment_status',0],['booking_status','Approved']])
        ->count();
        
        return $data;
    }

    // Client Address
    public function clientAddress($id)
    {
        $addr = Address::where('user_id',$id)->get();
        return response()->json(['success' => true, 'data' => $addr, 'message' => 'User Addresses']);
    }

    // Add Address
    public function addAddress(Request $request){
        $request->validate([
            'user_id' => 'bail|required',
            'street' => 'bail|required',
            'city' => 'bail|required|regex:/^([^0-9]*)$/',
            'state' => 'bail|required|regex:/^([^0-9]*)$/',
            'country' => 'bail|required|regex:/^([^0-9]*)$/',
            'let' => 'bail|required',
            'long' => 'bail|required',
        ]);
        
        $address = new Address();
        $address->user_id = $request->user_id;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->let = $request->let;
        $address->long = $request->long;
        $address->save();
        return response()->json(['msg' => 'user address added', 'data' => $address, 'success' => true], 200);
    }

    // ********************************  Salon Start ******************************************** 
    
    // Show salon
    public function showSalon()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        
        if ($salon->sunday['open'] == null && $salon->sunday['close'] == null){
            $salon->sunCheck = true;
        } else {
            $salon->sunCheck = false;
        }

        if ($salon->monday['open'] == null && $salon->monday['close'] == null){
            $salon->monCheck = true;
        } else {
            $salon->monCheck = false;
        }

        if ($salon->tuesday['open'] == null && $salon->tuesday['close'] == null){
            $salon->tueCheck = true;
        } else {
            $salon->tueCheck = false;
        }

        if ($salon->wednesday['open'] == null && $salon->wednesday['close'] == null){
            $salon->wedCheck = true;
        } else {
            $salon->wedCheck = false;
        }

        if ($salon->thursday['open'] == null && $salon->thursday['close'] == null){
            $salon->thuCheck = true;
        } else {
            $salon->thuCheck = false;
        }

        if ($salon->friday['open'] == null && $salon->friday['close'] == null){
            $salon->friCheck = true;
        } else {
            $salon->friCheck = false;
        }

        if ($salon->saturday['open'] == null && $salon->saturday['close'] == null){
            $salon->satCheck = true;
        } else {
            $salon->satCheck = false;
        }


        return response()->json(['success' => true, 'data' => $salon, 'message' => 'Show Salon']);
    }

    // Add salon
    public function addSalon(Request $request)
    {
        $request->validate([
            'owner_id' => 'bail|required',
            'logo' => 'bail|required',
            'image' => 'bail|required',
            'name' => 'bail|required',
            'desc' => 'bail|required',
            'gender' => 'bail|required',
            'give_service' => 'bail|required',
            'website' => '',
            'phone' => 'bail|required|numeric',
            'home_charges' => 'required_if:give_service,Home,Both',

            'sunopen' => 'required_if:sunCheck,false',
            'sunclose' => 'required_if:sunCheck,false',

            'monopen' => 'required_if:monCheck,false',
            'monclose' => 'required_if:monCheck,false',

            'tueopen' => 'required_if:tueCheck,false',
            'tueclose' => 'required_if:tueCheck,false',
            
            'wedopen' => 'required_if:wedCheck,false',
            'wedclose' => 'required_if:wedCheck,false',
            
            'thuopen' => 'required_if:thuCheck,false',
            'thuclose' => 'required_if:thuCheck,false',
            
            'friopen' => 'required_if:friCheck,false',
            'friclose' => 'required_if:friCheck,false',

            'satopen' => 'required_if:satCheck,false',
            'satclose' => 'required_if:satCheck,false',


            'address' => 'bail|required',
            'city' => 'bail|required',
            'state' => 'bail|required',
            'country' => 'bail|required',
            'zipcode' => 'bail|required|numeric',
            'latitude' => 'bail|required',
            'longitude' => 'bail|required',

        ]);

        $salon = new Salon();
        $salon->owner_id = $request->owner_id;
        $salon->name = $request->name;
        $salon->desc = $request->desc;
        $salon->gender = $request->gender;
        $salon->give_service = $request->give_service;
        $salon->home_charges = $request->home_charges;
        if($request->give_service == "Salon") {
            $salon->home_charges = '0';
        }

        $salon->address = $request->address;
        $salon->zipcode = $request->zipcode;
        $salon->city = ucfirst($request->city);
        $salon->state = ucfirst($request->state);
        $salon->country = ucfirst($request->country);
        $salon->website = $request->website;
        $salon->phone = $request->phone;

        if ($request->sunday == true) {
            $salon->sun = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        }

        if ($request->monday == true) {
            $salon->mon = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        }

        if ($request->tuesday == true){
            $salon->tue = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        }

        if ($request->wednesday == true){
            $salon->wed = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        }

        if ($request->thursday == true){
            $salon->thu = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        }

        if ($request->friday == true){
            $salon->fri = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        }

        if ($request->saturday == true){
            $salon->sat = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));
        }

        $salon->longitude = $request->longitude;
        $salon->latitude = $request->latitude;

        if(isset($request->image))
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "salon_". time() . ".png";
            $file = public_path('storage/images/salon logos/') . $name;
            $success = file_put_contents($file, $data1);
            $salon->image = $name;
        }

        if(isset($request->logo))
        {
            $img = $request->logo;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "salonLogo_". time() . ".png";
            $file = public_path('storage/images/salon logos/') . $name;
            $success = file_put_contents($file, $data1);
            $salon->logo = $name;
        }
        $owner = User::find($request->owner_id);
        $salon->save();
        $salon['token'] =  $owner->createToken('thebarber')->accessToken;
        
        // $cat = Category::where('name','Default Category')->first();
        // $cat_id = $cat->cat_id;
        // $service = new Service();
        // $service->salon_id = $salon->salon_id;
        // $service->cat_id = $cat_id;
        // $service->image = 'noimage.jpg';
        // $service->name = 'Demo Service';
        // $service->time = 30;
        // $service->gender = "Both";
        // $service->price = 100;
        // $service->save();


        // $emp = new Employee();
        // $emp->salon_id = $salon->salon_id;
        // $emp->name = $owner->name;
        // $emp->email = $owner->email;
        // $ser = array();
        // array_push($ser,$service->service_id);

        // $emp->service_id = json_encode($ser);
        
        // $emp->phone = $owner->phone;
        
        // $emp->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        // $emp->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        // $emp->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        // $emp->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        // $emp->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        // $emp->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        // $emp->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));
        
        // $emp->save();

        return response()->json(['success' => true, 'data' => $salon, 'message' => 'Salon created successfully!']);
    }

    // Edit salon
    public function editSalon(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'desc' => 'bail|required',
            'gender' => 'bail|required',
            'website' => '',
            'phone' => 'bail|required|numeric',
            'home_charges' => 'required_if:give_service,Home,Both',

            'sunopen' => 'required_if:sunday,false',
            'sunclose' => 'required_if:sunday,false',

            'monopen' => 'required_if:monday,false',
            'monclose' => 'required_if:monday,false',

            'tueopen' => 'required_if:tuesday,false',
            'tueclose' => 'required_if:tuesday,false',
            
            'wedopen' => 'required_if:wednesday,false',
            'wedclose' => 'required_if:wednesday,false',
            
            'thuopen' => 'required_if:thursday,false',
            'thuclose' => 'required_if:thursday,false',
            
            'friopen' => 'required_if:friday,false',
            'friclose' => 'required_if:friday,false',

            'satopen' => 'required_if:saturday,false',
            'satclose' => 'required_if:saturday,false',

            'address' => 'bail|required',
            'city' => 'bail|required',
            'state' => 'bail|required',
            'country' => 'bail|required',
            'zipcode' => 'bail|required|numeric',
            'latitude' => 'bail|required',
            'longitude' => 'bail|required',

        ]);

        // $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon = Salon::find(11);
        $salon->name = $request->name;
        $salon->desc = $request->desc;
        $salon->gender = $request->gender;
        $salon->give_service = $request->give_service;
        $salon->home_charges = $request->home_charges;
        if($request->give_service == "Salon") {
            $salon->home_charges = '0';
        }

        $salon->address = $request->address;
        $salon->zipcode = $request->zipcode;
        $salon->city = ucfirst($request->city);
        $salon->state = ucfirst($request->state);
        $salon->country = ucfirst($request->country);
        $salon->website = $request->website;
        $salon->phone = $request->phone;


        if ($request->sunday == true) {
            $salon->sun = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        }

        if ($request->monday == true) {
            $salon->mon = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        }

        if ($request->tuesday == true){
            $salon->tue = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        }

        if ($request->wednesday == true){
            $salon->wed = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        }

        if ($request->thursday == true){
            $salon->thu = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        }

        if ($request->friday == true){
            $salon->fri = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        }

        if ($request->saturday == true){
            $salon->sat = json_encode(array('open' => null,'close' => null));
        } else {
            $salon->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));
        }

        $salon->longitude = $request->longitude;
        $salon->latitude = $request->latitude;

        if(isset($request->logo))
        {
            \File::delete(public_path('/storage/images/salon logos/'. $salon->logo));
            $img = $request->logo;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "salonLogo_". time() . ".png";
            $file = public_path('storage/images/salon logos/') . $name;
            $success = file_put_contents($file, $data1);
            $salon->logo = $name;
        }
        if(isset($request->image))
        {
            \File::delete(public_path('/storage/images/salon logos/'. $salon->image));
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "salon_". time() . ".png";
            $file = public_path('storage/images/salon logos/') . $name;
            $success = file_put_contents($file, $data1);
            $salon->image = $name;
        }
        $salon->save();

        return response()->json(['success' => true, 'data' => $salon, 'message' => 'Salon Edited successfully!']);
    }
   
    // ********************************  Employee Start ********************************************

    // All employees
    public function employees()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $emps = Employee::where([['salon_id',$salon->salon_id],['isdelete',0]])
        ->orderBy('emp_id', 'DESC')
        ->get();
        
        $canAdd = 1;
        return response()->json(['success' => true, 'canAdd' => $canAdd, 'data' => $emps, 'message' => 'All Clients']);
    }

    // Show employee
    public function showEmployee($id)
    {
        $emp = Employee::find($id);
        return response()->json(['success' => true, 'data' => $emp, 'message' => 'Single Emp']);
    }

    public function empAppointment($id)
    {
        $appointments = Booking::where('emp_id',$id)->get();
        return response()->json(['success' => true, 'data' => $appointments, 'message' => 'Emp Appointments']);
    }

    // Add employee
    public function addEmp(Request $request)
    {
        $request->validate([
            // 'image' => 'bail|required',
            'name' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'email' => 'required|string|email|max:255|unique:employee',
            'password' => 'required',
            'service_id' => 'bail|required',
        ]);

        $emp = new Employee();

        if(isset($request->image))
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "emp_". time() . ".png";
            $file = public_path('storage/images/employee/') . $name;
            $success = file_put_contents($file, $data1);
            $emp->image = $name;
        }

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $emp->salon_id = $salon->salon_id;
        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->password = Hash::make($request->password);
        $emp->phone = $request->phone;
        $emp->service_id = json_encode($request->service_id);

        $salon_service = Salon::where('owner_id', Auth()->user()->id)->first()->give_service;
        if($salon_service == 'Both') {
            $emp->give_service = $request->give_service;
        }
        else {
            $emp->give_service = $salon_service;
        }

        $emp->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        $emp->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        $emp->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        $emp->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        $emp->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        $emp->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        $emp->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));

        $emp->save();

        return response()->json(['success' => true, 'data' => $emp, 'message' => 'Employee created successfully!']);
    }
    
    // Edit employee
    public function editEmployee(Request $request)
    {
        $request->validate([
            'emp_id' => 'bail|required',
            'name' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'email' => 'required|string|email',
            'service_id' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $emp = Employee::where('emp_id',$request->emp_id)->first();

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

        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        $emp->service_id = json_encode($request->service_id);
        
        $salon_service = Salon::where('owner_id', Auth()->user()->id)->first()->give_service;
        if($salon_service == 'Both') {
            $emp->give_service = $request->give_service;
        }
        else {
            $emp->give_service = $salon_service;
        }

        $emp->status = $request->status;

        $emp->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        $emp->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        $emp->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        $emp->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        $emp->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        $emp->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        $emp->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));

        $emp->save();

        return response()->json(['success' => true, 'data' => $emp, 'message' => 'Employee Edited successfully!']);
    }

    public function deleteEmployee($id)
    {
        $emp = Employee::find($id);
        $emp->isdelete = 1;
        $emp->status = 0;
        $emp->save();
        return response()->json(['success' => true, 'data' => $emp, 'message' => 'Employee Deleted successfully!']);
    }

    // ******************************** Services start  ********************************************

    // All Services Cat vise
    public function services()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();

        $data['category'] = Category::where([['status',1],['name','!=','Default Category']])->get();
        foreach ($data['category'] as $value)
        {
            $value->service = Service::where([['salon_id',$salon->salon_id],['cat_id',$value->cat_id],['isdelete',0]])->orderBy('cat_id', 'DESC')->get();
        }

        return response()->json(['success' => true, 'data' => $data, 'message' => 'All Services']);

    }
    
    // All Services
    public function allServices()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $service = Service::where([['status',1],['salon_id',$salon->salon_id],['isdelete',0]])->get();
        return response()->json(['success' => true, 'data' => $service, 'message' => 'All Services']);
    }

    // All Categories
    public function categories()
    {
        $categories = Category::where([['status',1],['name','!=','Default Category']])->get();
        return response()->json(['success' => true, 'data' => $categories, 'message' => 'All Categories']);
    }

    // Show service
    public function showService($id)
    {
        $service = Service::with('category')->find($id);
        return response()->json(['success' => true, 'data' => $service, 'message' => 'Single Service']);
    }

    // Add Service
    public function addService(Request $request)
    {
        $request->validate([
            'cat_id' => 'bail|required',
            'image' => 'bail|required',
            'name' => 'bail|required',
            'time' => 'bail|required|numeric',
            'gender' => 'bail|required',
            'price' => 'bail|required|numeric',
        ]);

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $service = new Service();
        if(isset($request->image))
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "Service_". time() . ".png";
            $file = public_path('storage/images/services/') . $name;
            $success = file_put_contents($file, $data1);
            $service->image = $name;
        }
        $service->name = $request->name;
        $service->gender = $request->gender;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->cat_id = $request->cat_id;
        $service->salon_id = $salon->salon_id;
        $service->save();

        return response()->json(['success' => true, 'data' => $service, 'message' => 'Service created successfully!']);
    }

    // Edit Service
    public function editService(Request $request)
    {
        $request->validate([
            'service_id' => 'bail|required',
            'cat_id' => 'bail|required',
            'image' => '',
            'name' => 'bail|required',
            'time' => 'bail|required|numeric',
            'gender' => 'bail|required',
            'price' => 'bail|required|numeric',
            'status' => 'bail|required'
        ]);

        $service = Service::find($request->service_id);
        if(isset($request->image))
        {
            if($service->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/storage/images/services/'. $service->image))){
                    \File::delete(public_path('/storage/images/services/'. $service->image));
                }
            }
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "Service_". time() . ".png";
            $file = public_path('storage/images/services/') . $name;
            $success = file_put_contents($file, $data1);
            $service->image = $name;
        }
        $service->name = $request->name;
        $service->gender = $request->gender;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->cat_id = $request->cat_id;
        $service->status = $request->status;
        $service->save();

        return response()->json(['success' => true, 'data' => $service, 'message' => 'Service Edited successfully!']);
    }
    
    public function deleteService($id)
    {
        $service = Service::find($id);
        $service->isdelete = 1;
        $service->status = 0;
        $service->save();
        return response()->json(['success' => true, 'data' => $service, 'message' => 'Service Deleted successfully!']);
    }

    // ******************************** Gallery start  ********************************************

    // All gallery
    public function gallery()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $gallery = Gallery::where('salon_id',$salon->salon_id)
        ->orderBy('gallery_id', 'DESC')
        ->get();

        return response()->json(['success' => true, 'data' => $gallery, 'message' => 'All Images']);
    }

    // Add gallery
    public function addGallery(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
        ]);

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $gallery = new Gallery();
        if(isset($request->image))
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "Gallery_". time() . ".png";
            $file = public_path('storage/images/gallery/') . $name;
            $success = file_put_contents($file, $data1);
            $gallery->image = $name;
        }
        
        $gallery->salon_id = $salon->salon_id;
        $gallery->save();

        return response()->json(['success' => true, 'data' => $gallery, 'message' => 'Gallery created successfully!']);
    }

    // Delete gallery
    public function deleteGallery($id)
    {
        $gallery = Gallery::find($id);
        \File::delete(public_path('/storage/images/gallery/'. $gallery->image));
        $gallery->delete();

        return response()->json(['success' => true, 'data' => $gallery, 'message' => 'Gallery deleted successfully!']);
    }

    // ******************************** Review start  ********************************************

    // All reviews
    public function review()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $review = Review::where('salon_id',$salon->salon_id)
        ->with('user')
        ->orderBy('review_id', 'DESC')
        ->get();

        return response()->json(['success' => true, 'data' => $review, 'message' => 'All Reviews']);
    }

    public function review_report(Request $request)
    {
        $request->validate([
            'review_id' => 'bail|required',
        ]);
        $review = Review::find($request->review_id);
        if ($review->report == 0) 
        {   
            $review->report = 1;
            $review->save();
        }
        else if($review->report == 1)
        {
            $review->report = 0;
            $review->save();
        }
        return response()->json(['success' => true, 'data' => $review, 'message' => 'All Reviews']);
    }

    // ******************************** Appointments start  ********************************************
    
    // All Appointment Status vise
    public function allAppointments()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();

       // Pending Appointment
       $data['pending_appointment'] = Booking::where([['booking_status','Pending'],['salon_id',$salon->salon_id]])
       ->orderBy('id','DESC')
       ->get();
       
       // Approved Appointment
       $data['approved_appointment'] = Booking::where([['booking_status','Approved'],['salon_id',$salon->salon_id]])
       ->orderBy('id','DESC')
       ->get();

       // Cancel Appointment
       $data['cancel_appointment'] = Booking::where([['booking_status','Cancel'],['salon_id',$salon->salon_id]])
       ->orderBy('id','DESC')
       ->get();

        $data['currency'] = AdminSetting::find(1,['currency','currency_symbol']);

        return response()->json(['success' => true, 'data' => $data, 'message' => 'All Appointments Status Vise']);
    }

    // All Appointment for Calendar
    public function calAppointments()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $appointments = Booking::where([['salon_id', $salon->salon_id],['booking_status','!=','Cancel']])
        ->orderBy('id','DESC')
        ->get();

        return response()->json(['success' => true, 'data' => $appointments, 'message' => 'All Appointments for Cal']);
    }

    // All Appointments
    public function appointments()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $appointments = Booking::where('salon_id', $salon->salon_id)
        ->orderBy('id','DESC')
        ->get();

        return response()->json(['success' => true, 'data' => $appointments, 'message' => 'All Appointments']);
    }

    // Time slot
    public function timeslot(Request $request)
    {
        $request->validate([
            'date' => 'bail|required',
        ]);

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

    // select emp
    public function selectEmp(Request $request)
    {
        $request->validate([
            'start_time' => 'bail|required',
            'service' => 'bail|required',
            'date' => 'bail|required|',
            'booking_at' => 'bail|required',
        ]);

        $emp_array = array();
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();

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
    
    // Add Appointment
    public function addAppointment(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
            'service_id' => 'bail|required',
            'date' => 'bail|required',
            'start_time' => 'bail|required',
            'payment' => 'bail|required|numeric',
            'emp_id' => 'bail|required',
            'booking_at' => 'bail|required',
            'address_id' => 'required_if:booking_at,Home',
            'extra_charges' => 'required_if:booking_at,Home',
        ]);

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $booking = new Booking();
        $bid = time() . mt_rand(10,99);
        $booking->booking_id = '#'.$bid;
        $book_service = json_encode($request->service_id);
        
        $duration = Service::whereIn('service_id', $request->service_id)->sum('time');
        $start_time = new Carbon($request['date'].' '.$request['start_time']);
        $booking->end_time = $start_time->addMinutes($duration)->format('h:i A');
        $booking->salon_id = $salon->salon_id;
        $booking->emp_id = $request->emp_id;
        $booking->payment = $request->payment;
        $booking->service_id = $book_service;
        $booking->start_time = $request->start_time;
        $booking->date = $request->date;
        $booking->payment_type = "LOCAL";
        $booking->booking_status = "Approved";
        $booking->user_id = $request->user_id;
        
        $booking->booking_at = $request->booking_at;
        if($request->booking_at == "Home"){
            $booking->extra_charges = $request->extra_charges;
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

        $emp_app_create_appointment = Template::where('title','Employee Appointment')->first();

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
            Config::set('onesignal.app_id', env('APP_ID'));
            Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
            Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));

            try{
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
                Config::set('onesignal.app_id', env('OWNER_APP_ID'));
                Config::set('onesignal.rest_api_key', env('OWNER_REST_API_KEY'));
                Config::set('onesignal.user_auth_key', env('OWNER_USER_AUTH_KEY'));
                try{
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
                Config::set('onesignal.app_id', env('EMPLOYEE_APP_ID'));
                Config::set('onesignal.rest_api_key', env('EMPLOYEE_REST_API_KEY'));
                Config::set('onesignal.user_auth_key', env('EMPLOYEE_USER_AUTH_KEY'));
                try{
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

    // Show Appointment
    public function showAppointment($id)
    {
        $appointment = Booking::find($id);
        return response()->json(['success' => true, 'data' => $appointment, 'message' => 'Single Appointment']);
    }

    // Change appointment status
    public function changeStatus(Request $request)
    {
        $request->validate([
            'bookingId' => 'bail|required',
            'status' => 'bail|required',
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
        if($notification_enable && $booking->user->device_token != null)
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

        return response()->json(['success' => true, 'data' => $booking, 'message' => 'Booking Status changed']);
    }

    // ******************************** Notification start  ********************************************
    
    public function notification()
    {
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        $not = AppNotification::where('salon_id',$salon->salon_id)->get();
        return $not;
    } 
    
    public function clearNotification()
    {
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        $not = AppNotification::where('salon_id',$salon->salon_id)->get()->each->delete();
        return response()->json(['msg' => 'Delete Notifications', 'success' => true], 200);
    }

    public function setting_mail(Request $request)
    {
        $request->validate([
            'mail' => 'bail|required|numeric',
        ]);
        $user = User::find(Auth::user()->id);
        $user->mail = $request->mail;
        $user->save();
        return response()->json(['success' => true, 'data' => $user, 'message' => 'User settings changed']);
    }

    public function setting_notification(Request $request)
    {
        $request->validate([
            'notification' => 'bail|required|numeric',
        ]);

        $user = User::find(Auth::user()->id);
        $user->notification = $request->notification;
        $user->save();
        return response()->json(['success' => true, 'data' => $user, 'message' => 'User settings changed']);
    }

    public function appSetting()
    {
        $settings = AdminSetting::find(1,['app_name','mapkey','owner_project_no','owner_app_id','project_no','app_id','currency','currency_symbol']);
        $settings->project_no = $settings->owner_project_no;
        $settings->app_id = $settings->owner_app_id;
        if(config('point.active')) {
            $settings->is_point_package = 1;
            $settings->referral_point = AdminSetting::find(1)->referral_point;
        } else {
            $settings->is_point_package = 0;
            $settings->referral_point = 0;
        }
        return response()->json(['msg' => 'settings', 'data' => $settings, 'success' => true], 200);
    }
}