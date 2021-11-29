<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Review;
use App\Booking;
use App\AdminSetting;
use App\Address;
use App\AppNotification;
use App\Notification;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '=', 3)
        ->orderBy('id','DESC')->get();
        return view('admin.pages.user', compact('users'));
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $completed = Booking::where([['user_id',$user->id],['booking_status','Completed']])->orderBy('date','DESC')->get();
        $pending = Booking::where([['user_id',$user->id],['booking_status','Pending']])->orderBy('date','DESC')->get();
        $approved = Booking::where([['user_id',$user->id],['booking_status','Approved']])->orderBy('date','DESC')->get();
        $cancel = Booking::where([['user_id',$user->id],['booking_status','Cancel']])->orderBy('date','DESC')->get();
        $setting = AdminSetting::find(1,['currency_symbol']);
        $address = Address::where('user_id',$user->id)->get();
        return view('admin.users.show', compact('user','completed','cancel','pending','approved','setting','address'));
    }

    public function destroy($id)
    {
        // delete address
        $addr = Address::where('user_id',$id)->get();
        foreach($addr as $item){
            $item->delete();
        }

        // delete app_notification
        $app_not = AppNotification::where('user_id',$id)->get();
        foreach($app_not as $item){
            $item->delete();
        }

        // Delete Booking
        $booking = Booking::where('user_id',$id)->get();
        foreach($booking as $item){
            $item->delete();
        }

        // Delete Notification
        $notification = Notification::where('user_id',$id)->get();
        foreach($notification as $item){
            $item->delete();
        }

        // delete Review
        $review = Review::where('user_id',$id)->get();
        foreach($review as $item){
            $item->delete();
        }

        // delete User
        $user = User::find($id);
        if($user->image != "noimage.jpg") {
            \File::delete(public_path('/storage/images/users/'. $user->image));
        }
        $user->delete();
        return redirect()->back();
    }

    public function hideUser(Request $request)
    {
        $user = User::find($request->userId);
        if ($user->status == 0) 
        {   
            $user->status = 1;
            $user->save();
        }
        else if($user->status == 1)
        {
            $user->status = 0;
            $user->save();
        }
    }

}
