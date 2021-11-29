<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Salon;
use App\Category;
use App\Service;
use App\Employee;
use App\Review;
use App\Booking;
use App\User;
use Auth;
use Carbon\Carbon;

class SalonController extends Controller
{
    public function index()
    {
        $salon = Salon::where([['owner_id', '=', Auth::user()->id]])->first();
        $services = Service::where([['status',1],['salon_id',$salon->salon_id]])->get();
        $emps = Employee::where([['status',1],['salon_id',$salon->salon_id]])->get();
        $reviews = Review::where([['report',0],['salon_id',$salon->salon_id]])->get();
        $bookings = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])->get();
        $ar = array();
        foreach ($bookings as $user)
        {
            array_push($ar,$user->user_id);
        }
        $users = User::whereIn('id',$ar)->get();
        return view('owner.salon.show', compact('salon','services','emps','reviews','users'));
    }

    public function create()
    {
        $user = User::find(Auth::user()->id);
        if($user->role == 2 && $user->salonName == ""){
            return view('owner.salon.create');
        }
        return redirect()->route('onwerDashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'desc' => 'bail|required',
            'gender' => 'bail|required',
            'image' => 'bail|required',
            'logo' => 'bail|required',
            'phone' => 'bail|required|numeric',
            'home_charges' => 'required_if:give_service,Home,Both',

            'sunopen' => 'required_if:sun,',
            'sunclose' => 'required_if:sun,',

            'monopen' => 'required_if:mon,',
            'monclose' => 'required_if:mon,',

            'tueopen' => 'required_if:tue,',
            'tueclose' => 'required_if:tue,',
            
            'wedopen' => 'required_if:wed,',
            'wedclose' => 'required_if:wed,',
            
            'thuopen' => 'required_if:thu,',
            'thuclose' => 'required_if:thu,',
            
            'friopen' => 'required_if:fri,',
            'friclose' => 'required_if:fri,',

            'satopen' => 'required_if:sat,',
            'satclose' => 'required_if:sat,',

            'address' => 'bail|required',
            'city' => 'bail|required',
            'state' => 'bail|required',
            'country' => 'bail|required',
            'zipcode' => 'bail|required|numeric'
        ]);
        
        $salon = new Salon();
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'salon_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/salon logos');
            $image->move($destinationPath, $name);
            $salon->image = $name;
        }
        
        if($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            $name = 'salonLogo_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/salon logos');
            $image->move($destinationPath, $name);
            $salon->logo = $name;
        }

        $salon->name = $request->name;
        $salon->desc = $request->desc;
        $salon->gender = $request->gender;
        $salon->give_service = $request->give_service;
        $salon->home_charges = $request->home_charges;
        if($request->give_service == "Salon") {
            $salon->home_charges = '0';
        }

        $salon->address = $request->address;
        $salon->zipcode = $request->zipcode;
        $salon->city = ucfirst($request->city);
        $salon->state = ucfirst($request->state);
        $salon->country = ucfirst($request->country);
        $salon->website = $request->website;
        $salon->phone = $request->phone;

       
        if($request->sunopen == null || $request->sunclose == null){
            $salon->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        } else {
            $salon->sun = json_encode(array('open' => Carbon::parse($request->sunopen)->format('H:i'),'close' => Carbon::parse($request->sunclose)->format('H:i')));
        }
        
        if($request->monopen == null || $request->monclose == null){
            $salon->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        } else {
            $salon->mon = json_encode(array('open' => Carbon::parse($request->monopen)->format('H:i'),'close' => Carbon::parse($request->monclose)->format('H:i')));
        }
  
        if($request->tueopen == null || $request->tueclose == null){
            $salon->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        } else {
            $salon->tue = json_encode(array('open' => Carbon::parse($request->tueopen)->format('H:i'),'close' => Carbon::parse($request->tueclose)->format('H:i')));
        }

        if($request->wedopen == null || $request->wedclose == null){
            $salon->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        } else {
            $salon->wed = json_encode(array('open' => Carbon::parse($request->wedopen)->format('H:i'),'close' => Carbon::parse($request->wedclose)->format('H:i')));
        }

        if($request->thuopen == null || $request->thuclose == null){
            $salon->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        } else {
            $salon->thu = json_encode(array('open' => Carbon::parse($request->thuopen)->format('H:i'),'close' => Carbon::parse($request->thuclose)->format('H:i')));
        }

        if($request->friopen == null || $request->friclose == null){
            $salon->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        } else {
            $salon->fri = json_encode(array('open' => Carbon::parse($request->friopen)->format('H:i'),'close' => Carbon::parse($request->friclose)->format('H:i')));
        }

        if($request->satopen == null || $request->satclose == null){
            $salon->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));
        } else {
            $salon->sat = json_encode(array('open' => Carbon::parse($request->satopen)->format('H:i'),'close' => Carbon::parse($request->satclose)->format('H:i')));
        }

        $salon->longitude = $request->long;
        $salon->latitude = $request->lat;
        $salon->owner_id = Auth()->user()->id;
        $salon->save();
        
        // $cat = Category::where('name','Default Category')->first();
        // $cat_id = $cat->cat_id;
        // $service = new Service();
        // $service->salon_id = $salon->salon_id;
        // $service->cat_id = $cat_id;
        // $service->image = 'noimage.jpg';
        // $service->name = 'Demo Service';
        // $service->time = 30;
        // $service->gender = "Both";
        // $service->price = 100;
        // $service->save();

        // $owner = User::find(Auth()->user()->id);

        // $emp = new Employee();
        // $emp->salon_id = $salon->salon_id;
        // $emp->name = $owner->name;
        // $emp->email = $owner->email;
        // $ser = array();
        // array_push($ser,$service->service_id);

        // $emp->service_id = json_encode($ser);
        // $emp->phone = $owner->phone;
        
        // if($request->sunopen == null || $request->sunclose == null){
        //     $emp->sun = json_encode(array('open' => $request->sunopen,'close' => $request->sunclose));
        // } else {
        //     $emp->sun = json_encode(array('open' => Carbon::parse($request->sunopen)->format('H:i'),'close' => Carbon::parse($request->sunclose)->format('H:i')));
        // }
        
        // if($request->monopen == null || $request->monclose == null){
        //     $emp->mon = json_encode(array('open' => $request->monopen,'close' => $request->monclose));
        // } else {
        //     $emp->mon = json_encode(array('open' => Carbon::parse($request->monopen)->format('H:i'),'close' => Carbon::parse($request->monclose)->format('H:i')));
        // }
  
        // if($request->tueopen == null || $request->tueclose == null){
        //     $emp->tue = json_encode(array('open' => $request->tueopen,'close' => $request->tueclose));
        // } else {
        //     $emp->tue = json_encode(array('open' => Carbon::parse($request->tueopen)->format('H:i'),'close' => Carbon::parse($request->tueclose)->format('H:i')));
        // }

        // if($request->wedopen == null || $request->wedclose == null){
        //     $emp->wed = json_encode(array('open' => $request->wedopen,'close' => $request->wedclose));
        // } else {
        //     $emp->wed = json_encode(array('open' => Carbon::parse($request->wedopen)->format('H:i'),'close' => Carbon::parse($request->wedclose)->format('H:i')));
        // }

        // if($request->thuopen == null || $request->thuclose == null){
        //     $emp->thu = json_encode(array('open' => $request->thuopen,'close' => $request->thuclose));
        // } else {
        //     $emp->thu = json_encode(array('open' => Carbon::parse($request->thuopen)->format('H:i'),'close' => Carbon::parse($request->thuclose)->format('H:i')));
        // }

        // if($request->friopen == null || $request->friclose == null){
        //     $emp->fri = json_encode(array('open' => $request->friopen,'close' => $request->friclose));
        // } else {
        //     $emp->fri = json_encode(array('open' => Carbon::parse($request->friopen)->format('H:i'),'close' => Carbon::parse($request->friclose)->format('H:i')));
        // }

        // if($request->satopen == null || $request->satclose == null){
        //     $emp->sat = json_encode(array('open' => $request->satopen,'close' => $request->satclose));
        // } else {
        //     $emp->sat = json_encode(array('open' => Carbon::parse($request->satopen)->format('H:i'),'close' => Carbon::parse($request->satclose)->format('H:i')));
        // }
        
        // $emp->save();
        
        return redirect('/owner/dashboard');
    }

    public function hideSalon(Request $request)
    {
        $salon = Salon::find($request->salonId);
        if ($salon->status == 0) 
        {   
            $salon->status = 1;
            $salon->save();
        }
        else if($salon->status == 1)
        {
            $salon->status = 0;
            $salon->save();
        }
    }
    public function salonDayOff(Request $request)
    {
        $salon = Salon::where([['owner_id', '=', Auth::user()->id]])->first();
        $salon_day = $request->day;
        $salon->$salon_day = json_encode(array('open' => null,'close' => null));
        $salon->save();
    }
}
