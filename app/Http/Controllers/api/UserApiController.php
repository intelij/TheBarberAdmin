<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Auth;
use Config;
use Hash;
use App\User;
use App\Salon;
use App\Category;
use App\Service;
use App\Gallery;
use App\Review;
use App\Banner;
use App\Coupon;
use App\Booking;
use App\Address;
use App\Offer;
use App\PaymentSetting;
use App\AppNotification;
use App\Employee;
use App\AdminSetting;
use App\Mail\BookingStatus;
use App\Mail\PaymentStatus;
use App\Mail\CreateAppointment;
use App\Mail\AppCreateAppointment;
use App\Mail\EmpAppCreateAppointment;
use App\Mail\EmpBookingStatus;
use App\Mail\Welcome;
use OneSignal;
use Twilio\Rest\Client;
use Stripe;
use App\Mail\OTP;
use App\Mail\ForgetPassword;
use DB;
use App\Template;
use App\Notification;

class UserApiController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required_if:provider,local',
            'password' => 'bail|required_if:provider,local',
            'provider' => 'bail|required',
            'provider_token' => 'bail|required_if:provider,facebook,apple',
            'name' => 'bail|required_if:provider,facebook,apple',
            'image' => 'bail|required_if:provider,facebook,apple',
        ]);

        if($request->provider == 'local') {
            $user = User::where('email',$request->email)->first();
            if($user) {
                $userdata = array(
                    'email' => $user->email,
                    'password' => $request->password,
                    'role' => 3
                );
            }
            else {
                    return response()->json(['error' => 'Invalid email or password'], 401);
            }
            if (Auth::attempt($userdata))
            {
                $user = User::find(Auth::user()->id);
                if($user->status == 1)
                {
                    if($user->verify == 1)
                    {
                        if(isset($request->device_token)){
                            $user->device_token = $request->device_token;
                        }
                        $user->provider = $request->provider;
                        $user->save();
                        $user->token =  $user->createToken('thebarber')->accessToken;
                        return response()->json(['msg' => "Login successfully", 'data' => $user, 'success' => true], 200);
                    }
                    else{
                        return response()->json(['msg' => "Verify your account", 'data' => $user->id, 'success' => false], 200);
                    }
                }
                else{
                    Auth::logout();
                    return response()->json(['msg' => "You are blocked", 'success' => false], 200);
                }
            } else {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }
        }
        else
        {
            $data = $request->all();
            $data['verify'] = 1;
            $filtered = Arr::except($data, ['provider_token']);
            $filtered['email'] = $data['email'];
            
            $user = User::where('email',$data['email'])->first();
            if($user)
            {
                $user->provider_token = $request->provider_token;
                $user->provider = $request->provider;
                $user->save();
                $user['token'] = $user->createToken('thebarber')->accessToken;
                return response()->json(['msg' => 'login successfully', 'data' => $user, 'success' => true], 200);
            }
            else
            {
                $setting = AdminSetting::find(1);
                if(config('point.active') == 1){
                    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $filtered['referral_code'] = $code;
                }

                $data = User::firstOrCreate(
                    ['provider_token' => $request->provider_token],$filtered
                );
                if($request->image != null)
                {
                    $url = $request->image;
                    $contents = file_get_contents($url);
                    $name = 'user_'.uniqid().'.png';
                    $destinationPath = public_path('/storage/images/users/'). $name;
                    file_put_contents($destinationPath, $contents);
                    $data['image'] = $name;
                }
                if(isset($data['device_token']))
                {
                    $data['device_token'] = $data->device_token;
                }
                $data['provider'] = $request->provider;
                $data->save();
                $token = $data->createToken('thebarber')->accessToken;
                $data['token'] = $token;
                return response()->json(['msg' => 'login successfully', 'data' => $data, 'success' => true], 200);
            }
        }
    }
    
    // Register
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'code' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'password' => 'bail|required|min:8',
            'referral_code'=> ['nullable','unique:users']
        ]);
       
        $user_verify = AdminSetting::first()->user_verify;
        $user_verify_sms = AdminSetting::first()->user_verify_sms;
        $user_verify_email = AdminSetting::first()->user_verify_email;
        $language = AdminSetting::first()->language;
        if($user_verify == 0)
            $verify = 1;
        else
            $verify = 0;
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'code' => $request->code,
                'phone' => $request->phone,
                'verify' => $verify,
                'password' => Hash::make($request->password),
                'language' => $language
            ]
        );
       
        if($user) 
        {
            $setting = AdminSetting::find(1);
            if(config('point.active') == 1){
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $code = substr(str_shuffle($permitted_chars), 0, 6);

                $user->referral_code = $code;
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
                $user->save();
            }
            if($user->verify == 1)
            {
                $content = Template::where('title','Welcome')->first()->mail_content;
                $subject = Template::where('title','Welcome')->first()->subject;
                $detail['UserName'] = $user->name;
                $detail['AppName'] = AdminSetting::first()->app_name;
                $mail_enable = AdminSetting::first()->mail;
    
                if($mail_enable){
                    try{
                        Mail::to($user->email)->send(new Welcome($content,$detail,$subject));
                    }
                    catch(\Throwable $th){}
                }
                $user['token'] = $user->createToken('thebarber')->accessToken;
            }
            else{
                $otp = rand(1111,9999);
                $user->otp = $otp;
                $user->save();

                $content = Template::where('title','User Verification')->first()->mail_content;
                $subject = Template::where('title','User Verification')->first()->subject;
                $msg_content = Template::where('title','User Verification')->first()->msg_content;
                $detail['UserName'] = $user->name;
                $detail['OTP'] = $otp;
                $detail['AppName'] = AdminSetting::first()->app_name;

                if($user_verify_sms ==1){                    
                    $sid = AdminSetting::first()->twilio_acc_id;
                    $token = AdminSetting::first()->twilio_auth_token;
                    $data = ["{{UserName}}", "{{OTP}}","{{AppName}}"];
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
                if($user_verify_email== 1){
                    try{
                        Mail::to($user->email)->send(new OTP($content,$detail,$subject));
                    }
                    catch(\Throwable $th){}
                }
            }
            return response()->json(['success' => true, 'data' => $user, 'message' => 'User created successfully!']);
        }else {
            return response()->json(['error' => 'User not Created'], 401);
        }
    }

    // send OTP
    public function sendotp(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = User::where([['role',3],['email',$request->email]])->first();
        if($user)
        {
            if($user->status == 1)
            {
                $otp = rand(1111,9999);
                $user->otp = $otp;
                $user->save();

                $content = Template::where('title','User Verification')->first()->mail_content;
                $subject = Template::where('title','User Verification')->first()->subject;
                $msg_content = Template::where('title','User Verification')->first()->msg_content;
                $detail['UserName'] = $user->name;
                $detail['OTP'] = $otp;
                $detail['AppName'] = AdminSetting::first()->app_name;
                $detail['AppLogo'] = asset('storage/images/app/'.AdminSetting::first()->black_logo);
                $user_verify_email = AdminSetting::first()->user_verify_email;
                $mail_enable = AdminSetting::first()->mail;
                $user_verify_sms = AdminSetting::first()->user_verify_sms;
                $sms_enable = AdminSetting::first()->sms;
                if($user_verify_email){
                    if($mail_enable)
                    {
                        try{
                            Mail::to($user->email)->send(new OTP($content,$detail,$subject));
                        }
                        catch(\Throwable $th){}
                    }
                }
                if($user_verify_sms){
                    if($sms_enable == 1)
                    {
                        $sid = AdminSetting::first()->twilio_acc_id;
                        $token = AdminSetting::first()->twilio_auth_token;
                        $data = ["{{UserName}}", "{{OTP}}","{{AppName}}"];
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
                }
                return response()->json(['msg' => 'OTP sended', 'data' => $user, 'success' => true], 200);
            }
            else
            {
                return response()->json(['msg' => 'You are blocked by admin', 'data' => null, 'success' => false], 200);
            }
        }
        else{
            return response()->json(['msg' => 'User not found', 'data' => null, 'success' => false], 200);
        }
    }
    
    // Resend OTP
    public function resendotp(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
        ]);
        $user = User::where([['role',3],['id',$request->user_id]])->first();
        if($user)
        {
            if($user->status == 1)
            {
                $otp = rand(1111,9999);
                $user->otp = $otp;
                $user->save();
                $content = Template::where('title','User Verification')->first()->mail_content;
                $subject = Template::where('title','User Verification')->first()->subject;

                $msg_content = Template::where('title','User Verification')->first()->msg_content;
                $detail['UserName'] = $user->name;
                $detail['OTP'] = $otp;
                $detail['AppName'] = AdminSetting::first()->app_name;
                $user_verify_email = AdminSetting::first()->user_verify_email;
                $mail_enable = AdminSetting::first()->mail;
                $user_verify_sms = AdminSetting::first()->user_verify_sms;
                $sms_enable = AdminSetting::first()->sms;
                if($user_verify_email){
                    if($mail_enable)
                    {
                        try{
                            Mail::to($user->email)->send(new OTP($content,$detail,$subject));
                        }
                        catch(\Throwable $th){
                        }
                    }
                }
                if($user_verify_sms){
                    if($sms_enable == 1)
                    {
                        $sid = AdminSetting::first()->twilio_acc_id;
                        $token = AdminSetting::first()->twilio_auth_token;
                        $data = ["{{UserName}}", "{{OTP}}","{{AppName}}"];
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
                }
                return response()->json(['msg' => 'OTP sended', 'data' => $user, 'success' => true], 200);
            }
            else
            {
                return response()->json(['msg' => 'You are blocked by admin', 'data' => null, 'success' => false], 200);
            }
        }
        else{
            return response()->json(['msg' => 'Invalid OTP', 'data' => null, 'success' => false], 200);
        }
    }

    // Check OTP
    public function checkotp(Request $request)
    {
        $request->validate([
            'otp' => 'bail|required|digits:4',
            'user_id' => 'bail|required',
        ]);

        $user = User::find($request->user_id);
        if($user->otp == $request->otp)
        {
            $user->verify = 1;
            $user->save();

            
            $content = Template::where('title','Welcome')->first()->mail_content;
            $subject = Template::where('title','Welcome')->first()->subject;
            $detail['UserName'] = $user->name;
            $detail['AppName'] = AdminSetting::first()->app_name;
            $mail_enable = AdminSetting::first()->mail;

            if($mail_enable){
                try{
                    Mail::to($user->email)->send(new Welcome($content,$detail,$subject));
                }
                catch(\Throwable $th){}
            }
            $user['token'] =  $user->createToken('thebarber')->accessToken;

            return response()->json(['msg' => 'OTP match', 'data' => $user, 'success' => true], 200);
        }
        else{
            return response()->json(['msg' => 'Wrong OTP', 'data' => null, 'success' => false], 200);
        }
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'bail|required',
            'new_Password' => 'bail|required|min:8',
            'confirm' => 'bail|required|same:new_Password',
        ]);

        if (Hash::check($request->oldPassword, Auth::user()->password))
        {
            $password = Hash::make($request->new_Password);
            User::find(Auth::user()->id)->update(['password'=>$password]);
            return response()->json(['msg' => 'changed', 'data' => null, 'success' => true], 200);
        }
        else{
            return response()->json(['msg' => 'Old password is not correct', 'data' => null, 'success' => false], 200);
        }
    }

    // Forget password
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = User::where([['role',3],['email',$request->email]])->first();
        if($user)
        {
            if($user->status == 1)
            {
                $password = rand(11111111,99999999);
                $user->password = Hash::make($password);
                $user->save();

                $content = Template::where('title','Forgot Password')->first()->mail_content;
                $subject = Template::where('title','Forgot Password')->first()->subject;
                $msg_content = Template::where('title','Forgot Password')->first()->msg_content;
                $detail['UserName'] = $user->name;
                $detail['NewPassword'] = $password;
                $detail['AppName'] = AdminSetting::first()->app_name;
                $mail_enable = AdminSetting::first()->mail;
                $sms_enable = AdminSetting::first()->sms;
                if($mail_enable)
                {
                    try{                    
                        Mail::to($user->email)->send(new ForgetPassword($content,$detail,$subject));
                    }
                    catch(\Throwable $th){}
                }
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
                return response()->json(['msg' => 'Password sended', 'data' => $user, 'success' => true], 200);
            }
            else
            {
                return response()->json(['msg' => 'You are blocked by admin', 'data' => null, 'success' => false], 200);
            }
        }
        else{
            return response()->json(['msg' => 'Invalid email address', 'data' => null, 'success' => false], 200);
        }
    }

    // All Salons 1234
    public function salons()
    {
        $salons = Salon::where('status', 1)->get();
        return response()->json(['msg' => 'Salons', 'data' => $salons, 'success' => true], 200);
    }

    // All Category
    public function categories()
    {
        $categories = Category::where([['status',1],['name','!=','Default Category']])->get();
        return response()->json(['msg' => 'Categories', 'data' => $categories, 'success' => true], 200);
    }
    
    // Single Salon
    public function singleSalon($id)
    {
        $data['salon'] = Salon::where('status',1)->find($id);
        $data['gallery'] = Gallery::where([['salon_id',$id],['status',1]])->get();
        $data['category'] = Category::where([['status',1],['name','!=','Default Category']])->get();

        foreach ($data['category'] as $value)
        {
            $value->service = Service::where([['salon_id',$id],['status',1],['cat_id',$value->cat_id]])->orderBy('cat_id', 'DESC')->get();
        }

        $data['review'] = Review::where([['salon_id',$id],['report',1]])
        ->with(['user'])
        ->orderBy('review_id','DESC')
        ->get();
        return response()->json(['msg' => 'Single Salon', 'data' => $data, 'success' => true], 200);
    }

    // Show user profile
    public function showUser()
    {
        $user = User::where([['status',1],['role',3]])->with(['address'])->find(Auth::user()->id);
        return response()->json(['msg' => 'Get single user profile', 'data' => $user, 'success' => true], 200);

    }

    //Edit User profile
    public function editUser(Request $request)
    {
        $user = User::where('role',3)->find(Auth::user()->id);

        $request->validate([
            'name' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'code' => 'bail|required',
        ]);
        $user->name = $request->name;
        $user->code = $request->code;
        $user->phone = $request->phone;
        $user->code = $request->code;
        if(isset($request->image))
        {
            if($user->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/storage/images/users/'. $user->image))){
                    \File::delete(public_path('/storage/images/users/'. $user->image));
                }
            }
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "user_". time() . ".png";
            $file = public_path('/storage/images/users/') . $name;

            $success = file_put_contents($file, $data1);
            $user->image = $name;
        }
        $user->save();
        return response()->json(['msg' => 'Edit User successfully', 'data' => $user, 'success' => true], 200);
    }
    
    // add  address
    public function addUserAddress(Request $request)
    {
        $address = new Address();

        $request->validate([
            'street' => 'bail|required',
            'city' => 'bail|required|regex:/^([^0-9]*)$/',
            'state' => 'bail|required|regex:/^([^0-9]*)$/',
            'country' => 'bail|required|regex:/^([^0-9]*)$/',
            'let' => 'bail|required',
            'long' => 'bail|required',
        ]);
        
        $address->user_id = Auth()->user()->id;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->let = $request->let;
        $address->long = $request->long;
        $address->save();
        return response()->json(['msg' => 'user address added', 'data' => $address, 'success' => true], 200);
    }

    // remove address
    public function removeUserAddress($id)
    {
        $booking = Booking::where('address_id',$id)->first();
        // return $booking;
        if(isset($booking)){
            return response()->json(['msg' => 'address is in use', 'success' => false], 200);
        }
        $address = Address::find($id);
        $address->delete();
        return response()->json(['msg' => 'address remove', 'success' => true], 200);
    }
    
    // all coupons
    public function allCoupon()
    {
        $coupon = Coupon::where('status',1)->get();
        return response()->json(['msg' => 'all coupons', 'data' => $coupon, 'success' => true], 200);
    }

    // check coupon
    public function checkCoupon(Request $request)
    {
        $request->validate([
        'code' => 'bail|required',
        ]);

        $coupon = Coupon::where('code',$request->code)->first();
        if(!$coupon)
        {
            return response()->json(['msg' => 'coupon code is incorrect', 'data' => $coupon, 'success' => true], 200);
        }
        else
        {
            $end_date = Carbon::parse($coupon->end_date)->addDays(1);
            $check = Carbon::now()->between($coupon->start_date,$end_date);
            $setting = AdminSetting::first();
            if ($coupon->max_use > $coupon->use_count && $check == 1) {
                if(config('point.active') == 1 && $setting->is_point == 1){
                    if($coupon->for_point == 1){
                        $user = User::find(Auth::user()->id);
                        if($user->remain_points < $coupon->min_point){
                            return response()->json(['msg' => "You don't have sufficient points to use this coupon", 'data' => null, 'success' => false], 200);
                        }
                    }
                }
                return response()->json(['msg' => 'Coupon applied', 'data' => $coupon, 'success' => true], 200);
            }
            else{
                return response()->json(['msg' => 'Coupon not applied', 'data' => null, 'success' => false], 200);
            }
        }
    }

    // time slot
    public function timeSlot(Request $request)
    {
        $request->validate([
            'salon_id' => 'bail|required',
            'date' => 'bail|required',
        ]);

        $master = array();
        $day = strtolower(Carbon::parse($request->date)->format('l'));
        $salon = Salon::find($request->salon_id)->$day;
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
            'salon_id' => 'bail|required',
            'date' => 'bail|required',
            'booking_at' => 'bail|required',
        ]);
    
        $emp_array = array();
        $emps_all = Employee::where([['salon_id',$request->salon_id],['status',1],['give_service',$request->booking_at]])
        ->orWhere([['salon_id',$request->salon_id],['status',1],['give_service','Both']])
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
                $now = \DateTime::createFromFormat('H:i a', $request->start_time);
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

    // booking / notification
    public function booking(Request $request)
    {
        $request->validate([
            'salon_id' => 'bail|required',
            'emp_id' => 'bail|required',
            'service_id' => 'bail|required',
            'payment' => 'bail|required',
            'date' => 'bail|required',
            'start_time' => 'bail|required',
            'payment_type' => 'bail|required',
            'payment_token' => 'required_if:payment_type,STRIPE,ROZAR,PAYPAL',
            'booking_at' => 'bail|required',
            'address_id' => 'required_if:booking_at,Home',
            // 'extra_charges' => 'required_if:booking_at,Home',
        ]);

        $booking = new Booking();
        $salon = Salon::find($request->salon_id);
        $book_service = json_encode($request->service_id);
        $duration = Service::whereIn('service_id', $request->service_id)->sum('time');
        
        $start_time = new Carbon($request['date'].' '.$request['start_time']);
        $booking->end_time = $start_time->addMinutes($duration)->format('h:i A');
        $booking->salon_id = $request->salon_id;
        $booking->emp_id = $request->emp_id;
        $booking->service_id = $book_service;
        $booking->payment = $request->payment;
        $booking->start_time = $request->start_time;
        $booking->date = $request->date;
        $booking->payment_type = $request->payment_type;
        
        $booking->booking_at = $request->booking_at;
        if($request->booking_at == "Home"){
            $booking->extra_charges = $salon->home_charges;
            $booking->address_id = $request->address_id;
        }
        else {
            $booking->extra_charges = 0;
            $booking->address_id = null;
        }
        
        if($request->payment_type == "STRIPE" || $request->payment_type == "ROZAR" || $request->payment_type == "PAYPAL")
        {
            $booking->payment_status = 1;
        }
        if($request->payment_type == "STRIPE") {
            $paymentSetting = PaymentSetting::find(1);
            $stripe_sk = $paymentSetting->stripe_secret_key;
    
            $adminSetting = AdminSetting::find(1);
            $currency =  $adminSetting->currency;

            if ($currency == "USD" || $currency == "EUR") {
                $amount = $request->payment * 100;
            }
            else {
                $amount = $request->payment;
            }

            Stripe\Stripe::setApiKey($stripe_sk);
            $stripeDetail = Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => $currency,
                "source" => $request->payment_token,
            ]);
            $booking->payment_token = $stripeDetail->id;
        }

        $booking->user_id = Auth()->user()->id;
        $bid = time() . mt_rand(10,99);
        $booking->booking_id = '#'.$bid;
        if(isset($request->coupon_id))
        {
            $booking->coupon_id = $request->coupon_id;
            $booking->discount = $request->discount;
            $coupon = Coupon::find($request->coupon_id);
            $count = $coupon->use_count;
            $count = $count +1;
            $coupon->use_count = $count;
            $coupon->save();
        }
        else{
            $booking->discount = 0;
        }
        $booking->booking_status = 'Pending';
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
            $user = User::find(Auth::user()->id);
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

        $not = new Notification();
        $not->booking_id = $booking->id;
        $not->user_id = Auth()->user()->id;
        $not->title = $create_appointment->subject;

        $detail['UserName'] = $booking->user->name;
        $detail['Date'] = $booking->date;
        $detail['Time'] = $booking->start_time;
        $detail['BookingId'] = $booking->booking_id;
        $detail['SalonName'] = $booking->salon->name;
        $detail['BookingAt'] = $booking->booking_at;
        $detail['AppName'] = AdminSetting::first()->app_name;

        $data = ["{{UserName}}", "{{Date}}","{{Time}}","{{BookingId}}","{{SalonName}}","{{BookingAt}}","{{AppName}}"];
        $message = str_replace($data, $detail, $create_appointment->msg_content);
        $mail_enable = AdminSetting::first()->mail;
        $notification_enable = AdminSetting::first()->notification;
        $not->msg = $message;
        $not->save();

        if($mail_enable)
        {
            try{
                Mail::to(Auth()->user()->email)->send(new CreateAppointment($create_appointment->mail_content,$detail,$create_appointment->subject));
            }
            catch (\Throwable $th) {}
        }
        if($notification_enable && Auth()->user()->device_token != null)
        {
            try{
                Config::set('onesignal.app_id', env('APP_ID'));
                Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
                Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));

                OneSignal::sendNotificationToUser(
                    $message,
                    Auth()->user()->device_token,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null,
                    $create_appointment->subject
                );
                
            }
            catch (\Throwable $th) {}
        }

        $app_create_appointment = Template::where('title','App Create Appointment')->first();
        
        $app_not = new AppNotification();
        $app_not->booking_id = $booking->id;
        $app_not->user_id = $booking->user_id;
        $app_not->salon_id = $booking->salon->salon_id;
        $app_not->title = $app_create_appointment->subject;

        $detail_app['SalonOwner'] = $booking->salon->ownerName;
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

        if($booking->salon->ownerDetails->mail == 1)
        {
            try{
                Mail::to($booking->salon->ownerDetails->email)->send(new AppCreateAppointment($app_create_appointment->mail_content,$detail_app,$app_create_appointment->subject));
                Mail::to($booking->employee->email)->send(new EmpAppCreateAppointment($emp_app_create_appointment->mail_content,$emp_detail_app,$emp_app_create_appointment->subject));
            }
            catch (\Throwable $th) {}
        }
        if($booking->salon->ownerDetails->notification == 1)
        {
            if($booking->salon->ownerDetails->device_token != null)
            {
                try{
                    Config::set('onesignal.app_id', env('OWNER_APP_ID'));
                    Config::set('onesignal.rest_api_key', env('OWNER_REST_API_KEY'));
                    Config::set('onesignal.user_auth_key', env('OWNER_USER_AUTH_KEY'));
                    OneSignal::sendNotificationToUser(
                        $app_message,
                        $booking->salon->ownerDetails->device_token,
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

    // All  Appointment
    public function showAppointment()
    {
        $master = array();
        $master['completed'] = Booking::where([['user_id',Auth::user()->id],['booking_status','Completed']])
        ->with(['salon','review'])
        ->orderBy('id', 'DESC')->get();

        $master['cancel'] = Booking::where([['user_id',Auth::user()->id],['booking_status','Cancel']])
        ->with(['salon','review'])
        ->orderBy('id', 'DESC')->get();

        $master['upcoming_order'] = Booking::where([['user_id',Auth::user()->id],['booking_status','Pending']])
        ->orWhere([['user_id',Auth::user()->id],['booking_status','Approved']])
        ->with(['salon'])
        ->orderBy('id', 'DESC')->get();

        return response()->json(['msg' => 'User Appointments', 'data' => $master, 'success' => true], 200);
    }

    // Single Appointment
    public function singleAppointment($id)
    {
        $booking = Booking::with('salon')->find($id);
        return response()->json(['msg' => 'Single Appointments', 'data' => $booking, 'success' => true], 200);
    }

    // Cancel Appointment
    public function cancelAppointment($id)
    {
        $booking = Booking::find($id);
        $booking->booking_status = "Cancel";
        $booking->save();
        
        $booking_status = Template::where('title','Booking status')->first();

        $not = new Notification();
        $not->booking_id = $booking->id;
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
            catch(\Throwable $th){}
        }
        if($notification_enable && $booking->user->device_token != null)
        {
            try
            {
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
            catch(\Throwable $th){}
        }

        // For emp
        $emp_booking_status = Template::where('title','Employee booking status')->first();

        $emp_not = new AppNotification();
        $emp_not->booking_id = $id;
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
        $owner_id = Salon::find($booking->salon_id)->owner_id;
        $owner = User::find($owner_id);
        $mail_enable = $owner->mail;
        $notification_enable = $owner->notification;

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
        return response()->json(['msg' => 'Appointment Cancel', 'data' => $booking, 'success' => true], 200);
    }

    // Add review
    public function addReview(Request $request)
    {
        $request->validate([
            'salon_id' => 'bail|required',
            'message' => 'bail|required', 
            'rate' => 'bail|required',
            'booking_id' => 'bail|required',
        ]);
        
        $review = new Review();
        $review->user_id = Auth()->user()->id;
        $review->salon_id = $request->salon_id;
        $review->rate = $request->rate;
        $review->message = $request->message;
        $review->booking_id = $request->booking_id;
        $review->save();

        return response()->json(['msg' => 'Review Added', 'data' => $review, 'success' => true], 200);
    }

    public function sharedSettings()
    {
        $settings = AdminSetting::find(1,['shared_name','shared_image','shared_url']);
        return response()->json(['msg' => 'seetings', 'data' => $settings, 'success' => true], 200);
    }

    // All banners
    public function banners()
    {
        $banner = Banner::where('status',1)->get();
        return response()->json(['msg' => 'Banners', 'data' => $banner, 'success' => true], 200);
    }

    // All Offers
    public function offers()
    {
        $offer = Offer::where('status',1)->get();
        return response()->json(['msg' => 'Offers', 'data' => $offer, 'success' => true], 200);
    }

    //Notifications
    public function notification()
    {
        $notification = Notification::where('user_id',Auth::user()->id)
        ->orderBy('id', 'desc')
        ->get();
        
        return response()->json(['msg' => 'Notifications', 'data' => $notification, 'success' => true], 200);
    }

    // top service
    public function topservices()
    {
        $ar = array();
        $master = array();
        $ser = array();
        $book_service = Booking::get();
        foreach($book_service as $item)
        {
            $ab = json_decode($item->service_id);
            foreach($ab as $value)
            {
                array_push($ar,$value);
            }
        }
        $reduce = array_count_values($ar);
        arsort($reduce);
        foreach ($reduce as $k => $v)
        {
            array_push($master,$k);
        }
        foreach ($master as $key) {
            array_push($ser,Service::find($key));
        }
        return response()->json(['msg' => 'Top services', 'data' => $ser, 'success' => true], 200);
    }

    //Category vise Salon 1234
    public function catSalon($id)
    {
        $ar = array();
        $service = Service::where([['status',1],['cat_id',$id]])->get();
        foreach ($service as $key)
        {
            array_push($ar,$key->salon_id);
        }

        $salon = Salon::whereIn('salon_id',$ar)->where('status', 1)->get();
        return response()->json(['msg' => 'Category vise Salon', 'data' => $salon, 'success' => true], 200);
    }

    // near by salon
    public function nearbySalon(Request $request)
    { 
        $request->validate([
            'lat' => 'bail|required',
            'long' => 'bail|required',
        ]);

        $arr = array();
        $lat= $request->lat;
        $long= $request->long;
        $radius = AdminSetting::find(1)->radius;
      
        $results = DB::table('salon')
        ->select('salon_id','name', 'latitude', 'longitude', DB::raw(sprintf(
            '(6371 * acos(cos(radians(%1$.7f)) * cos(radians(latitude)) * cos(radians(longitude) - radians(%2$.7f)) + sin(radians(%1$.7f)) * sin(radians(latitude)))) AS distance',
            $request->input('lat'),
            $request->input('long')
        )))
        ->having('distance', '<', $radius)
        ->orderBy('distance', 'asc')
        ->get();

        if(count($results)>0){
            foreach ($results as $q) {
                array_push($arr, $q->salon_id);
            }
        }
        
        $salon = Salon::whereIn('salon_id',$arr)->where('status', 1)->get();
        return response()->json(['msg' => 'Near by salon', 'data' => $salon, 'success' => true], 200);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'bail|required',
        ]);

        $search = $request->search;

        $salon = Salon::where([['status',1],['name','like', '%' . $search . '%']])->get();
        $cat = Category::where([['status',1],['name','like', '%' . $search . '%'],['name','!=','Default Category']])->first();
        if(isset($cat))
        {
            $ar = array();
            $service = Service::where([['status',1],['cat_id',$cat->cat_id]])->get();
            foreach ($service as $key)
            {
                array_push($ar,$key->salon_id);
            }

            $salon = Salon::where('status',1)->whereIn('salon_id',$ar)->get();
        }
    
        $service = Service::where([['status',1],['name','like', '%' . $search . '%']])->first();
        if(isset($service))
        {
            $ar = array();
            $service = Service::where([['status',1],['service_id',$service->service_id]])->get();
            foreach ($service as $key)
            {
                array_push($ar,$key->salon_id);
            }

            $salon = Salon::where('status',1)->whereIn('salon_id',$ar)->get();
        }
        return response()->json(['msg' => 'Search', 'data' => $salon, 'success' => true], 200);
    }

    public function payment_gateway()
    {
        $payment_gateway = PaymentSetting::first();
        $data['cod'] = $payment_gateway->cod;
        $data['stripe'] = $payment_gateway->stripe;
        return response()->json(['msg' => 'Payment Gateways', 'data' => $data, 'success' => true], 200);
    }

    // seetings, privacy, Terms
    public function settings()
    {
        $settings = AdminSetting::find(1,['mapkey','project_no','app_id','currency','currency_symbol','privacy_policy','terms_conditions','black_logo','white_logo','app_version','footer1','footer2']);
        $settings->stripe_public_key = PaymentSetting::first()->stripe_public_key;
        $settings->is_point_package = config('point.active');
        if(config('point.active')) {
            $settings->is_point_package = 1;
            $settings->referral_point = AdminSetting::find(1)->referral_point;
        } else {
            $settings->is_point_package = 0;
            $settings->referral_point = 0;
        }
        return response()->json(['msg' => 'seetings', 'data' => $settings, 'success' => true], 200);
    }
}