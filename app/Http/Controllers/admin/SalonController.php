<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Salon;
use App\Service;
use App\Employee;
use App\User;
use App\Review;
use App\Booking;
use App\AdminSetting;
use App\AppNotification;
use App\Notification;
use App\Gallery;


class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::orderBy('salon_id', 'DESC')->get();
        return view('admin.pages.salon', compact('salons'));
    }

    public function show($id)
    {
        $salon = Salon::find($id);
        $services = Service::where([['salon_id',$id],['isdelete',0]])->get();
        $emps = Employee::where([['salon_id',$id],['isdelete',0]])->get();
        $owner = User::where('id',$salon->owner_id)->first();
        $reviews = Review::where('salon_id',$salon->salon_id)->get();
        $bookings = Booking::where([['salon_id',$salon->salon_id],['payment_status',1]])->get();
        $ar = array();
        foreach ($bookings as $user)
        {
            array_push($ar,$user->user_id);
        }
        $users = User::whereIn('id',$ar)->get();
        $symbol = AdminSetting::find(1)->currency_symbol;
        return view('admin.salon.show', compact('salon','services','emps','owner','reviews','users','symbol'));
    }
    
    public function destroy($id)
    {
        AppNotification::where('salon_id',$id)->get()->each->delete();
        Review::where('salon_id',$id)->get()->each->delete();

        $bookings = Booking::where('salon_id',$id)->get();
        foreach($bookings as $booking)
        {
            Notification::where('booking_id',$booking->id)->get()->each->delete();
            $booking->delete();
        }

        $emps = Employee::where('salon_id',$id)->get();
        foreach($emps as $emp)
        {
            if($emp->image != "noimage.jpg") {
                \File::delete(public_path('/storage/images/employee/'. $emp->image));
            }
            $emp->delete();
        }
        $imgs = Gallery::where('salon_id',$id)->get();
        foreach($imgs as $img)
        {
            if($img->image != "noimage.jpg") {
                \File::delete(public_path('/storage/images/gallery/'. $img->image));
            }
            $img->delete();
        }
        $services = Service::where('salon_id',$id)->get();
        foreach($services as $service)
        {
            if($service->image != "noimage.jpg") {
                \File::delete(public_path('/storage/images/services/'. $service->image));
            }
            $service->delete();
        }
        
        $salon = Salon::find($id);
        \File::delete(public_path('/storage/images/salon logos/'. $salon->image));
        \File::delete(public_path('/storage/images/salon logos/'. $salon->logo));
        $salon->delete();
        return response()->json(['success' => true, 'msg' => 'Salon Deleted'], 200);

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
}
