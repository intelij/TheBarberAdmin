<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Salon;
use App\AdminSetting;
use Redirect;

class ReportController extends Controller
{
    public function revenue()
    {
        $pass = '';
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $give_service = Salon::where('owner_id',Auth()->user()->id)->first()->give_service;
        $bookings = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])
        ->orderBy('id', 'DESC')
        ->get();
        $setting = AdminSetting::find(1,['currency_symbol']);
        return view('owner.report.revenueReport',compact('bookings','setting','pass','give_service'));
       
    }
    
    public function revenue_filter(Request $request)
    {
        if($request->filter_date != null)
        {
            $pass = $request->filter_date;
            $dates = explode(' to ', $request->filter_date);
            $from = $dates[0];
            $to = $dates[1];
            $bookings = Booking::where('payment_status',1)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'ASC')
            ->get();
            $give_service = Salon::where('owner_id',Auth()->user()->id)->first()->give_service;
            $setting = AdminSetting::find(1,['currency_symbol']);
            return view('owner.report.revenueReport',compact('bookings','setting','pass','give_service'));
        }
        else{
            return redirect('/owner/report/revenue')->withErrors(['Select Date In Range']);
        }
    }
    
    public function user()
    {
        $pass = '';

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $bookings = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])->get();
        $ar = array();
        foreach ($bookings as $user)
        {
            array_push($ar,$user->user_id);
        }
        $users = User::whereIn('id',$ar)
        ->orderBy('id','DESC')
        ->get();

        $booking = Booking::get();
        return view('owner.report.userReport',compact('users','booking','pass'));
    }
    public function user_filter(Request $request)
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
    
            $booking = Booking::get();
            return view('owner.report.userReport',compact('users','booking','pass'));
        }
        else{
            return redirect('/owner/report/user')->withErrors(['Select Date In Range']);

        }
        
    }

    // remove
    public function commission()
    {
        $bookings = Booking::where('payment_status',1)
        ->orderBy('id', 'DESC')
        ->get();
        return view('owner.report.commission',compact('bookings'));
    }
}
