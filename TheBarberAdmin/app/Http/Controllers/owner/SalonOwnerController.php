<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\User;
use App\Booking;
use App\Salon;
use App\AdminSetting;
use App\Service;
use App\Language;
use Redirect;
use Auth;

class SalonOwnerController extends Controller
{
    public function show()
    {
        $user = User::find(Auth()->user()->id);
        $salon = Salon::where('owner_id', $user->id)->first();
        $income = Booking::where([['salon_id', $salon->salon_id],['payment_status',1],['booking_status','!=','Cancel']])->sum('salon_income');
        $service = Service::where('salon_id', $salon->salon_id)->count();

        $booking = Booking::where('salon_id',$salon->salon_id)->get();
        $ar = array();
        foreach($booking as $item)
        {
            array_push($ar,$item->user_id);
        }
        $users_count = User::whereIn('id',$ar)->count();
        $currency_symbol = AdminSetting::first()->currency_symbol;
        $language = Language::where('status',1)->get();
        return view('owner.pages.profile', compact('user','service','income','users_count','currency_symbol','language'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email|unique:users,email,' . Auth::user()->id . ',id',
            'name' => 'bail|required',
            'code' => 'bail|required|numeric|max:999',
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
            $name = 'owner_'.time().'.'. $image->getClientOriginalExtension();
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
         
        $lang = Language::where('name',$request->language)->first();
        \App::setLocale($lang->name);
        session()->put('locale', $lang->name);
        if($lang){
            session()->put('direction', $lang->direction);
        }
        return Redirect::back();
    }

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
        }
        return Redirect::back();
    }
}
