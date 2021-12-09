<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Salon;
use App\AdminSetting;
use Redirect;
use Auth;
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

    public function revenue_general()
    {
        if(isset($_GET['salon']) && $_GET['salon'] != 'owner'){
            $user_id = $_GET['salon'];
            $total_no_of_product = Product::where('salon_id', $user_id)->where('is_owner_product',0)->get()->count();
            $total_no_of_order = Order::where('salon_id', $user_id)->where('is_admin_order',0)->get()->count();
            $total_no_amount = Order::where('salon_id', $user_id)->where('is_admin_order',0)->sum("total_price");
            $total_no_amount_open = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',1)->sum("total_price");
            $total_no_amount_in_progress = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',2)->sum("total_price");
            $total_no_amount_completed = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',3)->sum("total_price");
            $total_no_amount_cancel = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',4)->sum("total_price");

            $total_no_order_open = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',1)->get()->count();
            $total_no_order_in_progress = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',2)->get()->count();
            $total_no_order_completed = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',3)->get()->count();
            $total_no_order_cancel = Order::where('salon_id', $user_id)->where('is_admin_order',0)->where('order_status_id',4)->get()->count();
        }
        else{
            $total_no_of_product = Product::where('is_owner_product',1)->get()->count();
            $total_no_of_order = Order::where('is_admin_order',1)->get()->count();
            $total_no_amount = Order::where('is_admin_order',1)->sum("total_price");
            $total_no_amount_open = Order::where('is_admin_order',1)->where('order_status_id',1)->sum("total_price");
            $total_no_amount_in_progress = Order::where('is_admin_order',1)->where('order_status_id',2)->sum("total_price");
            $total_no_amount_completed = Order::where('is_admin_order',1)->where('order_status_id',3)->sum("total_price");
            $total_no_amount_cancel = Order::where('is_admin_order',1)->where('order_status_id',4)->sum("total_price");

            $total_no_order_open = Order::where('is_admin_order',1)->where('order_status_id',1)->get()->count();
            $total_no_order_in_progress = Order::where('is_admin_order',1)->where('order_status_id',2)->get()->count();
            $total_no_order_completed = Order::where('is_admin_order',1)->where('order_status_id',3)->get()->count();
            $total_no_order_cancel = Order::where('is_admin_order',1)->where('order_status_id',4)->get()->count();
        }


        $salons = Salon::all();
        return view('admin.report.revenue_general',compact('total_no_of_product', 'total_no_of_order', 'total_no_amount', 'total_no_amount_open', 'total_no_amount_in_progress', 'total_no_amount_completed', 'total_no_amount_cancel','total_no_order_open', 'total_no_order_in_progress', 'total_no_order_completed', 'total_no_order_cancel', 'salons'));
    }
}
