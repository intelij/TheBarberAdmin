<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification'; 
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','salonImage'];

    public function getImagePathAttribute()
    {
        return url('storage/images/salon%20logos') . '/'; 
    }

    public function getSalonImageAttribute()
    {
        $booking = Booking::find($this->attributes['booking_id']);
        $salon_id = $booking->salon_id;
        $salon =  Salon::find($salon_id)->image;
        return $salon;
    }
}
