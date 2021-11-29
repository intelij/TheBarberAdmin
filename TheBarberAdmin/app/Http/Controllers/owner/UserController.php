<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Salon;
use App\Booking;
use App\Review;
use App\AdminSetting;
use App\Template;
use App\Address;
use Hash;
use Auth;
use Redirect;
use App\Mail\Welcome;

class UserController extends Controller
{
    public function index()
    {
        $pass = '';
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
        $users = User::whereIn('id',$ar)->get();
        
        return view('owner.pages.user', compact('users','pass'));
    }

    public function user_index_filter(Request $request)
    {
        if($request->filter_date != null)
        {
            $pass = $request->filter_date;
            $dates = explode(' to ', $request->filter_date);
            $from = $dates[0];
            $to = $dates[1];
            
            $salon = Salon::where('owner_id', Auth()->user()->id)->first();
            $bookings = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])->get();
            $ar = array();
            foreach ($bookings as $user)
            {
                array_push($ar,$user->user_id);
            }
            $users = User::whereIn('id',$ar)
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at','ASC')
            ->get();
    
            return view('owner.pages.user',compact('users','pass'));
        }
        else{
            return Redirect::back()->withErrors(['Select Date In Range']);
        }
        
    }

    public function create()
    {
        return view('owner.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'numeric'],
            'code' => ['required','numeric'],
            'referral_code'=> ['nullable','unique:users']
        ]);

        $salon = Salon::where('owner_id',Auth::user()->id)->first();
        $salon_id = $salon->salon_id;

        $setting = AdminSetting::find(1);

        $user = new User();
        $user->name = $request->name;
        if(config('point.active') == 1){
            $user->referral_code = $request->referral_code;
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
        $user->code = "+".$request->code;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->added_by = $salon_id;
        $user->verify = 1;
        $user->language = $setting->language;
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
        return response()->json(['success' => true,'data' => $user, 'msg' => 'User create'], 200);
    }

    public function show($id)
    {
        $user = User::with('address')->find($id);
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        $give_service = $salon->give_service;
        $review = Review::where([['salon_id',$salon->salon_id],['user_id',$user->id],['report',1]])->get();
        $completed = Booking::where([['salon_id',$salon->salon_id],['user_id',$user->id],['booking_status','Completed']])->orderBy('date','DESC')->get();
        $pending = Booking::where([['salon_id',$salon->salon_id],['user_id',$user->id],['booking_status','Pending']])->orderBy('date','DESC')->get();
        $approved = Booking::where([['salon_id',$salon->salon_id],['user_id',$user->id],['booking_status','Approved']])->orderBy('date','DESC')->get();
        $cancel = Booking::where([['salon_id',$salon->salon_id],['user_id',$user->id],['booking_status','Cancel']])->orderBy('date','DESC')->get();
        $setting = AdminSetting::find(1,['currency_symbol']);
        $address = Address::where('user_id',$user->id)->get();
        return view('owner.user.show', compact('give_service','user','completed','cancel','pending','approved','setting','address'));
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
    
    public function address_add(Request $request){
        $request->validate([
            'user_name' => 'bail|required',
            'street' => 'bail|required',
            'city' => 'bail|required|regex:/^([^0-9]*)$/',
            'state' => 'bail|required|regex:/^([^0-9]*)$/',
            'country' => 'bail|required|regex:/^([^0-9]*)$/',
            'lat' => 'bail|required',
            'long' => 'bail|required',
        ]);

        $address = new Address();
        $address->user_id = $request->user_name;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->let = $request->lat;
        $address->long = $request->long;
        $address->save();
        return Redirect::back();
    }
}