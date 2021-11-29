<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Currency;
use App\AdminSetting;
use App\PaymentSetting;
use App\Booking;
use App\User;
use App\Language;
use Redirect;
use Hash;
use Auth;
use DB;
use App\Salon;
use Illuminate\Support\Facades\Storage;
use LicenseBoxAPI;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function index()
    {
        $setting = AdminSetting::find(1);
        $currency = Currency::get();
        $setting = AdminSetting::first();
        $payment = PaymentSetting::first();
        $language = Language::where('status',1)->get();
        return view('admin.pages.settings', compact('currency','setting','payment','language'));
    }

    public function update_license(Request $request, $id)
    {
        $request->validate([
            'license_code' => 'required',
            'license_client_name' => 'required',
            ]);
            $api = new LicenseBoxAPI();
            $activate_response = $api->activate_license($request->license_code, $request->license_client_name);
          
        if($activate_response['status'] === true){
            $setting = AdminSetting::find(1);
            $setting->license_code = $request->license_code;
            $setting->license_client_name = $request->license_client_name;
            $setting->license_status = 1;
            $setting->save();
            return redirect('/admin/dashboard');
        }
        else{
            return Redirect::back()->withStatus($activate_response['message']);

        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'radius' => 'required',

            'app_id' => 'required_if:notification,1',
            'project_no' => 'required_if:notification,1',
            'api_key' => 'required_if:notification,1',
            'auth_key' => 'required_if:notification,1',
            
            'owner_app_id' => 'required_if:notification,1',
            'owner_api_key' => 'required_if:notification,1',
            'owner_auth_key' => 'required_if:notification,1',
            'owner_project_no' => 'required_if:notification,1',
            
            'employee_app_id' => 'required_if:notification,1',
            'employee_project_no' => 'required_if:notification,1',
            'employee_api_key' => 'required_if:notification,1',
            'employee_auth_key' => 'required_if:notification,1',

            'mail_host' => 'required_if:mail_by,smtp',
            'mail_encryption' => 'required_if:mail_by,smtp',
            'mail_port' => 'required_if:mail_by,smtp',
            'mail_username' => 'required_if:mail_by,smtp',
            'mail_password' => 'required_if:mail_by,smtp',
            'sender_email' => 'required_if:mail_by,smtp',
            
            'mailgun_key' => 'required_if:mail_by,mailgun',
            'mailgun_domain' => 'required_if:mail_by,mailgun',

            'twilio_acc_id' => 'required_if:sms,1',
            'twilio_auth_token' => 'required_if:sms,1',
            'twilio_phone_no' => 'required_if:sms,1',

            'stripe_public_key' => 'required_if:stripe,1',
            'stripe_secret_key' => 'required_if:stripe,1',
            
            // 'paypal_sandbox_key' => 'required_if:paypal,1',
            // 'paypal_production_key' => 'required_if:paypal,1',
           
            'commission_amount' => 'bail|required|numeric',

            'latitude' => 'bail|required|numeric',
            'longitude' => 'bail|required|numeric',
            'app_name' => 'bail|required',
        ]);

        $setting = AdminSetting::find(1);
        $payment = PaymentSetting::find(1);

        if(isset($request->user_verify)){ $setting->user_verify = 1; }
        else{ $setting->user_verify = 0; }

        if($request->user_verify == 1) {
            if(isset($request->user_verify_sms) || isset($request->user_verify_email)) {
                if(isset($request->user_verify_sms)){ $setting->user_verify_sms = 1; }
                else{ $setting->user_verify_sms = 0; }
    
                if(isset($request->user_verify_email)){ $setting->user_verify_email = 1; }
                else{ $setting->user_verify_email = 0; }
            }
            else {
                return Redirect::back()->withErrors(['Please Check at least one between SMS or Email']);
            }
        } else {
            if(isset($request->user_verify_sms)){ $setting->user_verify_sms = 1; }
            else{ $setting->user_verify_sms = 0; }

            if(isset($request->user_verify_email)){ $setting->user_verify_email = 1; }
            else{ $setting->user_verify_email = 0; }
        }

        $currency = Currency::where('code',$request->currency)->first();
        $setting->currency_symbol = $currency->symbol;

        $setting->currency = $request->currency;
        $setting->language = $request->language;
        $setting->mapkey = $request->mapkey;
        $setting->radius = $request->radius;
        $setting->lat = $request->latitude;
        $setting->lang = $request->longitude;
        
        if(isset($request->notification)){ $setting->notification = 1; }
        else{ $setting->notification = 0; }

        $setting->app_id = $request->app_id;
        $setting->api_key = $request->api_key;
        $setting->auth_key = $request->auth_key;
        $setting->project_no = $request->project_no;
        
        $setting->owner_app_id = $request->owner_app_id;
        $setting->owner_api_key = $request->owner_api_key;
        $setting->owner_auth_key = $request->owner_auth_key;
        $setting->owner_project_no = $request->owner_project_no;
        
        $setting->employee_app_id = $request->employee_app_id;
        $setting->employee_api_key = $request->employee_api_key;
        $setting->employee_auth_key = $request->employee_auth_key;
        $setting->employee_project_no = $request->employee_project_no;


        $setting->terms_conditions = $request->terms_conditions;
        $setting->privacy_policy = $request->privacy_policy;
        $setting->commission_type = $request->commission_type;
        $setting->commission_amount = $request->commission_amount;

        
        if(isset($request->mail)){ $setting->mail = 1; }
        else{ $setting->mail = 0; $setting->user_verify_email = 0; }

        $setting->mail_by = $request->mail_by;
        $setting->mail_encryption = $request->mail_encryption;
        $setting->mail_host = $request->mail_host;
        $setting->mail_port = $request->mail_port;
        $setting->mail_username = $request->mail_username;
        $setting->mail_password = $request->mail_password;
        $setting->sender_email = $request->sender_email;
        $setting->mailgun_key = $request->mailgun_key;
        $setting->mailgun_domain = $request->mailgun_domain;

        if(isset($request->sms)){ $setting->sms = 1; }
        else{ $setting->sms = 0;  $setting->user_verify_sms = 0; }

        $setting->twilio_acc_id = $request->twilio_acc_id;
        $setting->twilio_auth_token = $request->twilio_auth_token;
        $setting->twilio_phone_no = $request->twilio_phone_no;


        if(isset($request->cod)){ $payment->cod = 1; }
        else{ $payment->cod = 0; }
        if(isset($request->stripe)){ $payment->stripe = 1; }
        else{ $payment->stripe = 0; }

        $payment->stripe_public_key = $request->stripe_public_key;
        $payment->stripe_secret_key = $request->stripe_secret_key;

        $setting->app_name = $request->app_name;
        $setting->color = $request->color;
        $setting->app_version = $request->app_version;
        $setting->footer1 = $request->footer1;
        $setting->footer2 = $request->footer2;

        $setting->shared_name = $request->shared_name;
        $setting->shared_url = $request->shared_url;

        // website
        $setting->play_store_link = $request->play_store_link;
        $setting->app_store_link = $request->app_store_link;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->address = $request->address;

        if($request->hasFile('favicon_icon'))
        {
            if(\File::exists(public_path('/storage/images/app/'. $setting->favicon))){
                \File::delete(public_path('/storage/images/app/'. $setting->favicon));
            }

            $image = $request->file('favicon_icon');
            $name = 'favicon.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/app');
            $image->move($destinationPath, $name);
            $setting->favicon = $name;
        }
        if($request->hasFile('black_logo'))
        {
            if(\File::exists(public_path('/storage/images/app/'. $setting->black_logo))){
                \File::delete(public_path('/storage/images/app/'. $setting->black_logo));
            }
            
            $image = $request->file('black_logo');
            $name = 'black_logo.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/app');
            $image->move($destinationPath, $name);
            $setting->black_logo = $name;
        }
        if($request->hasFile('white_logo'))
        {
            if(\File::exists(public_path('/storage/images/app/'. $setting->white_logo))){
                \File::delete(public_path('/storage/images/app/'. $setting->white_logo));
            }

            $image = $request->file('white_logo');
            $name = 'white_logo.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/app');
            $image->move($destinationPath, $name);
            $setting->white_logo = $name;
        }
        
        if($request->hasFile('bg_img'))
        {
            if(\File::exists(public_path('/storage/images/app/'. $setting->bg_img))){
                \File::delete(public_path('/storage/images/app/'. $setting->bg_img));
            }

            $image = $request->file('bg_img');
            $name = 'bg_img.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/app');
            $image->move($destinationPath, $name);
            $setting->bg_img = $name;
        }
        
        if($request->hasFile('shared_image'))
        {
            if(\File::exists(public_path('/storage/images/app/'. $setting->shared_image))){
                \File::delete(public_path('/storage/images/app/'. $setting->shared_image));
            }

            $image = $request->file('shared_image');
            $name = 'shared_image.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/app');
            $image->move($destinationPath, $name);
            $setting->shared_image = $name;
        }

        $payment->save();
        $setting->save();


        $data['APP_ID']=$request->app_id;
        $data['REST_API_KEY']=$request->api_key;
        $data['USER_AUTH_KEY']=$request->auth_key;
        
        $data['OWNER_APP_ID']=$request->owner_app_id;
        $data['OWNER_REST_API_KEY']=$request->owner_api_key;
        $data['OWNER_USER_AUTH_KEY']=$request->owner_auth_key;
        
        $data['EMPLOYEE_APP_ID']=$request->employee_app_id;
        $data['EMPLOYEE_REST_API_KEY']=$request->employee_api_key;
        $data['EMPLOYEE_USER_AUTH_KEY']=$request->employee_auth_key;
        
        $data['MAIL_MAILER']=$request->mail_by;
        $data['MAIL_HOST']=$request->mail_host;
        $data['MAIL_ENCRYPTION']=$request->mail_encryption;
        $data['MAIL_PORT']=$request->mail_port;
        $data['MAIL_USERNAME']=$request->mail_username;
        $data['MAIL_PASSWORD']=$request->mail_password;
        $data['MAIL_FROM_ADDRESS']=$request->sender_email;
        $data['MAILGUN_SECRET']=$request->mailgun_key;
        $data['MAILGUN_DOMAIN']=$request->mailgun_domain;


        $envFile = app()->environmentFilePath();
        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                  
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){ return false;  }
            else{   return redirect('admin/settings');   }
        return Redirect::back()->withErrors(['Error check']);
        }

    }

    // Admin Profile
    public function admin_show()
    {
        $user = User::find(Auth::user()->id);
        $commission = Booking::where([['payment_status',1],['booking_status','!=','Cancel']])->sum('commission');
        $symbol = AdminSetting::find(1)->currency_symbol;
        $salon = Salon::count();
        $users = User::where('role', '=', 3)->count();

        $language = Language::where('status',1)->get();
        return view('admin.pages.profile', compact('user','salon','commission','symbol','users','language'));
    }
    
    public function admin_update(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:users,email,' . Auth::user()->id . ',id',
            'name' => 'bail|required',
            'code' => 'bail|required',
            'phone' => 'bail|required|numeric'
        ]);


        $user = User::find(Auth::user()->id);
        if($request->hasFile('image'))
        {
            if($user->image != 'noimage.jpg')
            {
                if(\File::exists(public_path('/storage/images/users/'. $user->image))){
                    \File::delete(public_path('/storage/images/users/'. $user->image));
                }
            }
            $image = $request->file('image');
            $name = 'admin_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/users');
            $image->move($destinationPath, $name);
            $user->image = $name;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->code = "+".$request->code;
        $user->phone = $request->phone;
        $user->language = $request->language;
        $user->save();
         
        $lang = $request->language;
        $lang = Language::where('name',$lang)->first();
        \App::setLocale($lang->name);
        session()->put('locale', $lang->name);
        if($lang){
            session()->put('direction', $lang->direction);
        }
        return Redirect::back();
    }
    
    public function admin_changePassword(Request $request)
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
        }
        return Redirect::back();
    }
}