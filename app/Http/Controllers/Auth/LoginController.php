<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Redirect;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTP;
use App\Template;
use App\AdminSetting;
use App\Language;
use Hash;
use App\Mail\ForgetPassword;
use Twilio\Rest\Client;
use LicenseBoxAPI;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function admin()
    {
        if(Auth::check())
        {
            Auth::logout();
        }
        return view('admin.login.login');
    }

    public function login_verify(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'role' => 1
        );

        if(Auth::attempt($userdata))
        {
            $license_code = AdminSetting::find(1)->license_code;
            $client_name = AdminSetting::find(1)->license_client_name;
            $lang = Language::where('name',Auth::user()->language)->first();
            \App::setLocale($lang->name);
            session()->put('locale', $lang->name);
            if($lang){
                session()->put('direction', $lang->direction);
            }
            $api = new LicenseBoxAPI();
            $verify = $api->verify_license();

            if($verify['status'] == true){
                $set = AdminSetting::find(1);
                $set->license_status = 1;
                $set->save();
            }
            else{
                $set = AdminSetting::find(1);
                $set->license_status = 1; // make it 0 when goes to live
                $set->save();
            }
            $license_status = AdminSetting::find(1)->license_status;
            if ($license_status == 1) {
                return redirect('/admin/dashboard');
            }
            else{
                return redirect('/admin/settings');
            }
        }
        else
        {
            return redirect()->Route('admin.login') ->with('error','Invalid email address or password');
        }

    }

    public function owner()
    {
//        if(env('DB_DATABASE') == null)
//        {
//            return view('welcome');
//        }
        if(Auth::check())
        {
            Auth::logout();
        }
        return view('owner.login.login');
    }

    // owner forget password
    public function forgetpassword()
    {
        return view('owner.login.forgetPassword');
    }

    public function ownerforgetpassword(Request $request)
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
                    catch(\Throwable $th){
                    }
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
                return redirect('/owner/login');
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

    public function savelicense(Request $request)
    {
        $setting = AdminSetting::find(1);
        $setting->license_code = $request->license_code;
        $setting->license_client_name = $request->license_client_name;
        $setting->license_status = $request->license_status;
        $setting->save();
        return redirect('/admin/login');
    }

    public function saveEnvData(Request $request)
    {
        $data['DB_HOST']=$request->db_host;
        $data['DB_DATABASE']=$request->db_name;
        $data['DB_USERNAME']=$request->db_user;
        $data['DB_PASSWORD']=$request->db_pass;

        $envFile = app()->environmentFilePath();

        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $str .= "\n"; // In case the searched variable is in the last line without \n
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){
                return response()->json(['data' => null,'success'=>false], 200);
            }

            $set = AdminSetting::first();
            $set->license_client_name = $request->client_name;
            $set->license_code = $request->license_code;
            $set->license_status = 1;
            $set->save();

            return response()->json([ 'data' => url('admin/login'),'success'=>true], 200);
        }
    }

    public function admin_logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }

    public function owner_logout()
    {
        Auth::logout();
        return redirect('/owner/login');
    }
}
