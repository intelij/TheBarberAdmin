<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Salon;
use App\Category;
use App\Booking;
use App\Service;
use App\AdminSetting;
use App\Template;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTP;
use Carbon\Carbon;
use Redirect;
use Math;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role', '=', 3)
        ->orderBy('id','DESC')->get();

        $salons = Salon::count();
        $categories = Category::where([['status',1],['name','!=','Default Category']])->count();
        $commission = Booking::where([['payment_status',1],['booking_status','!=','Cancel']])->sum('commission');

        $table_cat = Category::orderBy('cat_id','DESC')->get();
        $setting = AdminSetting::find(1,['currency_symbol']);

        return view('admin.pages.dashboard', compact('users','salons','categories','commission','table_cat','setting'));
    }

    // User Charts
    public function adminUserChartData()
    {
        $masterYear = array();
        $labelsYear = array();

        array_push($masterYear,User::where([['status',1],['role',3]])
        ->whereMonth('created_at', Carbon::now())
        ->count());

        for ($i=1; $i <= 11 ; $i++)
        {
            if($i >= Carbon::now()->month){
                array_push($masterYear,User::where([['status',1],['role',3]])
                ->whereMonth('created_at',Carbon::now()->subMonths($i))
                ->whereYear('created_at', Carbon::now()->subYears(1))
                ->count());
            } else {
                array_push($masterYear,User::where([['status',1],['role',3]])
                ->whereMonth('created_at',Carbon::now()->subMonths($i))
                ->whereYear('created_at', Carbon::now()->year)
                ->count());
            }
            
        }

        array_push($labelsYear, Carbon::now()->format('M-y'));
        for ($i=1; $i <= 11 ; $i++)
        { 
            array_push($labelsYear, Carbon::now()->subMonths($i)->format('M-y'));
        }

        return [$masterYear,$labelsYear];
    }

    public function adminUserMonthChartData()
    {
        $masterMonth = array();
        $labelsMonth = array();

        array_push($masterMonth,User::where([['status',1],['role',3]])
        ->whereDate('created_at',Carbon::today()->format('Y-m-d'))
        ->count());
        for ($i=1; $i <= 30 ; $i++)
        { 

            array_push($masterMonth,User::where([['status',1],['role',3]])
            ->whereDate('created_at',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->count());
        }

        array_push($labelsMonth,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 30 ; $i++)
        { 
            array_push($labelsMonth,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterMonth,$labelsMonth];
    }
    
    public function adminUserWeekChartData()
    {
        $masterWeek = array();
        $labelsWeek = array();

        array_push($masterWeek,User::where([['status',1],['role',3]])
        ->whereDate('created_at', Carbon::today()->format('Y-m-d'))
        ->count());
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($masterWeek,User::where([['status',1],['role',3]])
            ->whereDate('created_at', Carbon::now()->subDays($i)->format('Y-m-d'))
            ->count());
        }

        array_push($labelsWeek,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($labelsWeek,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterWeek,$labelsWeek];
    }

    // Revenue Chart
    public function adminRevenueChartData()
    {
        $masterYear = array();
        $labelsYear = array();

        array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
        ->whereMonth('date', Carbon::now())
        ->sum('commission')));
        
        for ($i=1; $i <= 11 ; $i++)
        {
            if($i >= Carbon::now()->month) {
                array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
                ->whereMonth('date',Carbon::now()->subMonths($i))
                ->whereYear('date', Carbon::now()->subYears(1))
                ->sum('commission')));
            } else {
                array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
                ->whereMonth('date',Carbon::now()->subMonths($i))
                ->whereYear('date', Carbon::now()->year)
                ->sum('commission')));
            }
            
        }

        array_push($labelsYear, Carbon::now()->format('M-y'));
        for ($i=1; $i <= 11 ; $i++)
        { 
            array_push($labelsYear, Carbon::now()->subMonths($i)->format('M-y'));
        }

        return [$masterYear,$labelsYear];
    }

    public function adminRevenueMonthChartData()
    {
        $masterMonth = array();
        $labelsMonth = array();

        array_push($masterMonth,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
        ->whereDate('date', Carbon::today()->format('Y-m-d'))
        ->sum('commission')));
        for ($i=1; $i <= 30 ; $i++)
        { 
            array_push($masterMonth,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
            ->whereDate('date',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->sum('commission')));
        }

        array_push($labelsMonth,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 30 ; $i++)
        { 
            array_push($labelsMonth,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterMonth,$labelsMonth];
    }
    
    public function adminRevenueWeekChartData()
    {
        $masterWeek = array();
        $labelsWeek = array();

        array_push($masterWeek,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
        ->whereDate('date', Carbon::today()->format('Y-m-d'))
        ->sum('commission')));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($masterWeek,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel']])
            ->whereDate('date',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->sum('commission')));
        }

        array_push($labelsWeek,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($labelsWeek,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterWeek,$labelsWeek];
    }

    // Salon chart
    public function adminsalondata()
    {
        $yearSalon = array();
        $labelsYear = array();

        array_push($yearSalon,Salon::where('status',1)->whereMonth('created_at', Carbon::now())->count());

        for ($i=1; $i <= 11 ; $i++)
        {
            array_push($yearSalon,Salon::where('status',1)
            ->whereMonth('created_at',Carbon::now()->subMonths($i))
            ->count());
        }

        array_push($labelsYear, Carbon::now()->format('M-y'));
        for ($i=1; $i <= 11 ; $i++)
        { 
            array_push($labelsYear, Carbon::now()->subMonths($i)->format('M-y'));
        }

        return [$yearSalon,$labelsYear];
    }

    // Country wise salon chart
    public function adminsaloncountrydata()
    {
        $con = array();
        $sal = array();
        $clr = array();
        $countSalon = array();
        $country = array();

        $salon = Salon::get();
        foreach($salon as $item)
        {
            array_push($con, $item->country);
        }
        
        $reduce = array_count_values($con);
        arsort($reduce);
        $country = array_keys($reduce);

        $countSalon = array_values($reduce);

        $permitted_chars = '0123456789ABCDEF';

        $clr = array();
        for ($i=1; $i <= count($countSalon) ; $i++)
        {
            $r = substr(str_shuffle($permitted_chars), 0, 2);
            $g = substr(str_shuffle($permitted_chars), 0, 2);
            $b = substr(str_shuffle($permitted_chars), 0, 2);
            $final = "#".''.$r.''.$g.''.$b;
            array_push($clr,$final);
        }
        return [$countSalon,$country,$clr];
    }
}
