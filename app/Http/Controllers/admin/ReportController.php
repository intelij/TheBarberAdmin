<?php

namespace App\Http\Controllers\admin;

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
        $bookings = Booking::where('payment_status',1)
        ->orderBy('id', 'DESC')
        ->get();
        $setting = AdminSetting::find(1,['currency_symbol']);
        return view('admin.report.revenue',compact('bookings','setting','pass'));
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
            $setting = AdminSetting::find(1,['currency_symbol']);
            return view('admin.report.revenue',compact('bookings','setting','pass'));
        }
        else{
            return redirect('/admin/report/revenue')->withErrors(['Select Date In Range']);
        }
    }
    
    public function user()
    {
        $pass = '';
        $users = User::where('role',3)
        ->orderBy('id','DESC')
        ->get();
        $booking = Booking::get();
        return view('admin.report.userReport',compact('users','booking','pass'));
    }
    public function user_filter(Request $request)
    {
        if($request->filter_date != null)
        {
            $pass = $request->filter_date;
            $dates = explode(' to ', $request->filter_date);
            $from = $dates[0];
            $to = $dates[1];

            $users = User::where('role',3)
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at','ASC')
            ->get();
            $booking = Booking::get();
            return view('admin.report.userReport',compact('users','booking','pass'));
        }
        else{
            return redirect('/admin/report/user')->withErrors(['Select Date In Range']);
        }
    }

    public function salonrevenue()
    {
        $pass = '';
        $salons = Salon::orderBy('salon_id', 'DESC')->get();
        $booking = Booking::get();
       
        $setting = AdminSetting::find(1,['currency_symbol']);
        return view('admin.report.salonrevenue',compact('salons','booking','setting','pass'));
    }

    public function salonrevenue_filter(Request $request)
    {
        if($request->filter_date != null)
        {
            $pass = $request->filter_date;
            $dates = explode(' to ', $request->filter_date);
            $from = $dates[0];
            $to = $dates[1];

            $salons = Salon::orderBy('salon_id', 'DESC')->get();
            $booking = Booking::whereBetween('date', [$from, $to])
            ->orderBy('date', 'ASC')
            ->get();
            $setting = AdminSetting::find(1,['currency_symbol']);
            return view('admin.report.salonrevenue',compact('salons','booking','setting','pass'));
        }
        else{
            return redirect('/admin/report/salon/revenue')->withErrors(['Select Date In Range']);
        }
    }
}
