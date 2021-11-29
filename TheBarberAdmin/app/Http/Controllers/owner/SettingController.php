<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\AdminSetting;
use App\Salon;
use Carbon\Carbon;

class SettingController extends Controller
{
   
    public function index()
    {
        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        return view('owner.pages.settings', compact('salon'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
            'desc' => 'bail|required',
            'gender' => 'bail|required',
            'website' => '',
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
        
        $salon = Salon::find($id);
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/storage/images/salon logos/'. $salon->image))){
                \File::delete(public_path('/storage/images/salon logos/'. $salon->image));
            }

            $image = $request->file('image');
            $name = 'salon_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/salon logos');
            $image->move($destinationPath, $name);
            $salon->image = $name;
        }
        if($request->hasFile('logo'))
        {
            if(\File::exists(public_path('/storage/images/salon logos/'. $salon->logo))){
                \File::delete(public_path('/storage/images/salon logos/'. $salon->logo));
            }

            $image = $request->file('logo');
            $name = 'salonLogo_'.time().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images/salon logos');
            $image->move($destinationPath, $name);
            $salon->logo = $name;
        }

        $salon->name = $request->name;
        $salon->desc = $request->desc;
        
        $salon->address = $request->address;
        $salon->zipcode = $request->zipcode;
        $salon->city = ucfirst($request->city);
        $salon->state = ucfirst($request->state);
        $salon->country = ucfirst($request->country);
        $salon->website = $request->website;
        $salon->phone = $request->phone;
        $salon->gender = $request->gender;
        $salon->give_service = $request->give_service;
        $salon->home_charges = $request->home_charges;
        if($request->give_service == "Salon"){
            $salon->home_charges = '0';
        }

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
       
        $salon->save();
        return redirect('/owner/settings');
    }
}
