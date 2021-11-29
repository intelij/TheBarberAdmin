<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Salon;
use App\Service;
use App\Employee;
use App\Review;
use App\Booking;
use App\AdminSetting;
use App\AppNotification;
use App\Notification;
use App\Gallery;

class SalonOwnerController extends Controller
{
    public function index()
    {
        $users = User::where('role', 2)
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.pages.salonowner', compact('users'));
    }

    public function show($id)
    {
        $data['user'] = User::find($id);
        $data['salon'] = Salon::where('owner_id',$data['user']->id)->first();
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Owner show'], 200);
    }
      
    public function destroy($id)
    {
        $owner = User::find($id);
        $salon = Salon::where('owner_id',$id)->first();
        if(isset($salon))
        {
            AppNotification::where('salon_id',$salon->salon_id)->get()->each->delete();
            Review::where('salon_id',$salon->salon_id)->get()->each->delete();

            $bookings = Booking::where('salon_id',$salon->salon_id)->get();
            foreach($bookings as $booking)
            {
                Notification::where('booking_id',$booking->salon->salon_id)->get()->each->delete();
                $booking->delete();
            }

            $emps = Employee::where('salon_id',$salon->salon_id)->get(); // image
            foreach($emps as $emp)
            {
                if($emp->image != "noimage.jpg") {
                    \File::delete(public_path('/storage/images/employee/'. $emp->image));
                }
                $emp->delete();
            }
            $imgs = Gallery::where('salon_id',$salon->salon_id)->get();
            foreach($imgs as $img)
            {
                if($img->image != "noimage.jpg") {
                    \File::delete(public_path('/storage/images/gallery/'. $img->image));
                }
                $img->delete();
            }
            $services = Service::where('salon_id',$salon->salon_id)->get();
            foreach($services as $service)
            {
                if($service->image != "noimage.jpg") {
                    \File::delete(public_path('/storage/images/services/'. $service->image));
                }
                $service->delete();
            }
           
            $salon = Salon::find($salon->salon_id);
            \File::delete(public_path('/storage/images/salon logos/'. $salon->image));
            \File::delete(public_path('/storage/images/salon logos/'. $salon->logo));
            $salon->delete();
            
        }
        if($owner->image != "noimage.jpg") {
            \File::delete(public_path('/storage/images/users/'. $owner->image));
        }
        $owner->delete();
    }
}
