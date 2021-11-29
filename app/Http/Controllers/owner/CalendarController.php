<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Booking;
use App\Salon;
use App\Service;
use App\User;
use App\Employee;
use DateTime;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {

        $salon = Salon::where('owner_id',Auth()->user()->id)->first();
        $salon_id = $salon->salon_id;
        $give_service = $salon->give_service;
        $booking = Booking::where('salon_id',$salon_id)->get();
        
        $event = [];
        foreach ($booking as $row)
        {
            $start_time = strtolower(Carbon::parse($row->start_time)->format('H:i'));
            $end_time = strtolower(Carbon::parse($row->end_time)->format('H:i'));

            $_start = date('Y-m-d H:i:s', strtotime("$row->date $start_time"));
            $_end = date('Y-m-d H:i:s', strtotime("$row->date $end_time"));

            if ($row->booking_status == "Cancel")
            {
                $bgColor = "rgba(251, 175, 190, .5)";
                $textColor = "#b3092b";
            }
            else if($row->booking_status == "Pending")
            {
                $bgColor = "rgba(203, 210, 246, .5)";
                $textColor = "#2236a8";
            }
            else if($row->booking_status == "Approved")
            {
                $bgColor = "rgba(136, 230, 247, .5)";
                $textColor = "#05879e";
            }
            else if($row->booking_status == "Completed")
            {
                $bgColor = "rgba(147, 231, 195, .5)";
                $textColor = "#1a8a59";
            }
            else{
                $bgColor = "rgba(11, 11, 11, .5)";
                $textColor = "#111111";
            }

            $event[] = Calendar::event(
                $row->user->name,
                false,
                $_start,
                $_end,
                $row->id,
                [
                    'color' => $bgColor,
                    'textColor' => $textColor,
                ]
            );
        }
        $salon = Salon::where('owner_id', Auth()->user()->id)->first();
        $users = User::where([['status',1],['role',3]])->get();
        $services = Service::where([['salon_id',$salon->salon_id],['isdelete',0]])->get();

        $calendar = Calendar::addEvents($event)->setCallbacks(['eventClick' => 'eventClicked']);
        return view('owner.pages.calendar', compact('give_service','booking','calendar','users','services'));
    }
   
}
