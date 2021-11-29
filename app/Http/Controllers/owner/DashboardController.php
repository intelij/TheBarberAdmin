<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Hash;
use App\User;
use App\Salon;
use App\Service;
use App\Employee;
use App\Booking;
use App\AdminSetting;
use App\Language;
use Redirect;


class DashboardController extends Controller
{
    public function index()
    {
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $services = Service::where([['salon_id', $salon->salon_id],['isdelete',0]])->get();
        $employees = Employee::where([['salon_id', $salon->salon_id],['isdelete',0]])->get();
        $salon_income = Booking::where([['salon_id', $salon->salon_id],['payment_status',1],['booking_status','!=','Cancel']])->sum('salon_income');
        $give_service = $salon->give_service;
        
        $booking = Booking::where('salon_id',$salon->salon_id)->get();
        $ar = array();
        foreach($booking as $user)
        {
            array_push($ar,$user->user_id);
        }
        $users = User::whereIn('id',$ar)->get();

        $last_users = User::where('role',3)
        ->whereIn('id',$ar)
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->count();
        
        $last_income = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])
        ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        ->sum('payment');

        $ar = array();
        $master = array();
        $top_services = array();
        $book_service = Booking::where('salon_id',$salon->salon_id)->get();
        foreach($book_service as $item)
        {
            $ab = json_decode($item->service_id);
            foreach($ab as $value)
            {
                array_push($ar,$value);
            }
        }
        $reduce = array_count_values($ar);
        arsort($reduce);
        foreach ($reduce as $k => $v)
        {
            array_push($master,$k);
        }
        $count = 0;
        foreach ($master as $key)
        {
            $count++;
            if($count == 6)
            {
                break;
            }
            array_push($top_services,Service::find($key));
        }

        $upcommings = Booking::where([['salon_id',$salon->salon_id],['date', '>=', Carbon::today()->toDateString()],['booking_status','Approved']])
        ->orderBy('date', 'asc')
        ->orderBy('start_time', 'asc')
        ->take(8)
        ->get();

        $symbol = AdminSetting::find(1)->currency_symbol;
        return view('owner.pages.dashboard', compact('give_service','services','employees',
        'salon_income','users','last_users','last_income','top_services','upcommings','symbol'));
    }

    public function ownerOrderChartData()
    {
        $masterYear = array();
        $labelsYear = array();
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterYear,Booking::where('salon_id',$salon_id)
        ->whereMonth('date', Carbon::now())
        ->count());

        for ($i=1; $i <= 11 ; $i++)
        {
            if($i >= Carbon::now()->month){
                array_push($masterYear,Booking::where('salon_id',$salon_id)
                ->whereMonth('created_at',Carbon::now()->subMonths($i))
                ->whereYear('created_at', Carbon::now()->subYears(1))
                ->count());
            } else {
                array_push($masterYear,Booking::where('salon_id',$salon_id)
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

    public function ownerOrderMonthChartData()
    {
        $masterMonth = array();
        $labelsMonth = array();

        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterMonth,Booking::where('salon_id',$salon_id)
        ->whereDate('date',Carbon::today()->format('Y-m-d'))
        ->count());
        for ($i=1; $i <= 30 ; $i++)
        { 
            array_push($masterMonth,Booking::where('salon_id',$salon_id)
            ->whereDate('date',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->count());
        }

        array_push($labelsMonth,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 30 ; $i++)
        { 
            array_push($labelsMonth,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterMonth,$labelsMonth];
    }
    
    public function ownerOrderWeekChartData()
    {
        $masterWeek = array();
        $labelsWeek = array();
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterWeek,Booking::where('salon_id',$salon_id)
        ->whereDate('date', Carbon::today()->format('Y-m-d'))
        ->count());
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($masterWeek,Booking::where('salon_id',$salon_id)
            ->whereDate('date', Carbon::now()->subDays($i)->format('Y-m-d'))
            ->count());
        }

        array_push($labelsWeek,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($labelsWeek,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterWeek,$labelsWeek];
    }

    public function ownerRevenueChartData()
    {
        $masterYear = array();
        $labelsYear = array();
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
        ->whereMonth('date', Carbon::now())
        ->sum('salon_income')));

        for ($i=1; $i <= 11 ; $i++)
        {
            if($i >= Carbon::now()->month){
                array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
                ->whereMonth('date',Carbon::now()->subMonths($i))
                ->whereYear('date', Carbon::now()->subYears(1))
                ->sum('salon_income')));
            } else {
                array_push($masterYear,ceil(Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
                ->whereMonth('date',Carbon::now()->subMonths($i))
                ->whereYear('date', Carbon::now()->year)
                ->sum('salon_income')));
            }
            
        }
        
        array_push($labelsYear, Carbon::now()->format('M-y'));
        for ($i=1; $i <= 11 ; $i++)
        { 
            array_push($labelsYear, Carbon::now()->subMonths($i)->format('M-y'));
        }

        return [$masterYear,$labelsYear];
    }

    public function ownerRevenueMonthChartData()
    {
        $masterMonth = array();
        $labelsMonth = array();
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterMonth,Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
        ->whereDate('date', Carbon::today()->format('Y-m-d'))
        ->sum('salon_income'));
        for ($i=1; $i <= 29 ; $i++)
        { 
            array_push($masterMonth,Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
            ->whereDate('date',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->sum('salon_income'));
        }

        array_push($labelsMonth,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 29 ; $i++)
        { 
            array_push($labelsMonth,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterMonth,$labelsMonth];
    }
    
    public function ownerRevenueWeekChartData()
    {
        $masterWeek = array();
        $labelsWeek = array();
        
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;

        array_push($masterWeek,Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
        ->whereDate('date', Carbon::today()->format('Y-m-d'))
        ->sum('salon_income'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($masterWeek,Booking::where([['payment_status',1],['booking_status','!=','Cancel'],['salon_id',$salon_id]])
            ->whereDate('date',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->sum('salon_income'));
        }

        array_push($labelsWeek,Carbon::now()->format('d-M'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($labelsWeek,Carbon::now()->subDays($i)->format('d-M'));
        }

        return [$masterWeek,$labelsWeek];
    }

    public function ownerlogin(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'role' => 2,
        );
        if (Auth::attempt($userdata))
        {
            $salon = Salon::where('owner_id', Auth::user()->id)->first();
            $lang = Language::where('name',Auth::user()->language)->first();
            \App::setLocale($lang->name);
            session()->put('locale', $lang->name);
            if($lang){
                session()->put('direction', $lang->direction);
            }
            if(!$salon)
            {
                return redirect('owner/salons/create');
            }
            
            return redirect('owner/dashboard');
        }
        else
        {      
            return Redirect::back()->withErrors(['Invalid Email or Passoword']);
        }
    }

    public function ownerregister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'code' =>  ['required','numeric','max:999'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
        ]);
        
        $language = AdminSetting::first()->language;
        $user = new User();
        $user->name = $request->name;
        $user->code = "+".$request->code;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->provider = "local";
        $user->password = Hash::make($request->password);
        $user->role = 2;
        $user->language = $language;
        $user->save();
        return redirect('owner/login');
    }
}
