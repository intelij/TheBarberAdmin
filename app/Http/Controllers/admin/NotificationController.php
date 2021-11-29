<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Template;
use OneSignal;
use Redirect;
use Config;
use App\AdminSetting;

class NotificationController extends Controller
{
    public function template()
    {
        $templates = Template::get();
        return view('admin.notification.template', compact('templates'));
    }

    public function edit_template($id)
    {
        $template = Template::find($id);
        return response()->json(['msg' => 'Show Template', 'data' => $template, 'success' => true], 200);
    }
    
    public function update_template(Request $request)
    {
        $temp = Template::find($request->id);
        $temp->subject = $request->subject;
        $temp->mail_content = $request->mail_content;
        $temp->msg_content = $request->msg_content;
        $temp->save();

        return Redirect::back();
    }

    
    public function send()
    {
        $users = User::where('role', '=', 3)
        ->orderBy('id','DESC')
        ->get();
        return view('admin.notification.send', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
            'msg' => 'bail|required',
            'title' => 'bail|required',
        ]);

        $str = json_encode($request->user_id);
        $ids =  str_replace('"', '',$str);

        $notification_enable = AdminSetting::first()->notification;
        
        if($notification_enable)
        {
            foreach (json_decode($ids) as $key)
            {
                if($user->device_token != null){
                    try{
                        Config::set('onesignal.app_id', env('APP_ID'));
                        Config::set('onesignal.rest_api_key', env('REST_API_KEY'));
                        Config::set('onesignal.user_auth_key', env('USER_AUTH_KEY'));
                        $user = User::where('status',1)->find($key);
                        OneSignal::sendNotificationToUser(
                            $request->msg,
                            $user->device_token,
                            $url = null,
                            $data = null,
                            $buttons = null,
                            $schedule = null,
                            $request->title
                        );
                    
                    }
                    catch (\Throwable $th) {}
                }
            }
        }
        return redirect('admin/notification/send');
    }

}
