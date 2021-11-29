<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Salon extends Model
{
    protected $table = 'salon';
    public $primaryKey = 'salon_id';
    public $timestamps = true;
    public $appends = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday',
    'rate','rateCount','imagePath','ownerName','ownerDetails','open','completedBooking','serviceName'];

    public function getSundayAttribute()
    {
        return json_decode($this->sun, true);
    }
    public function getMondayAttribute()
    {
        return json_decode($this->mon, true);
    }
    public function getTuesdayAttribute()
    {
        return json_decode($this->tue, true);
    }
    public function getWednesdayAttribute()
    {
        return json_decode($this->wed, true);
    }
    public function getThursdayAttribute()
    {
        return json_decode($this->thu, true);
    }
    public function getFridayAttribute()
    {
        return json_decode($this->fri, true);
    }
    public function getSaturdayAttribute()
    {
        return json_decode($this->sat, true);
    }
    public function getRateAttribute()
    {
        $review =  Review::where('salon_id', $this->attributes['salon_id'])->get(['rate']);
        if(count($review)>0)
        {
            $totalRate = 0;
            foreach ($review as $r)
            {
                $totalRate=$totalRate+$r->rate;
            }
            return number_format($totalRate / count($review),1);
        }else{
            return 0;
        } 
    }

    public function getRateCountAttribute()
    {
        $review =  Review::where('salon_id', $this->attributes['salon_id'])->get(['rate']);
        return count($review);
    }

    public function getOpenAttribute()
    {
        $day = strtolower(Carbon::now()->format('D'));
        $decode = json_decode($this->$day, true);
        if($decode['open'] == null || $decode['close'] == null)
            return 0;
        $start_time = new Carbon(date('Y-m-d').' '.$decode['open']);
        $end_time = new Carbon(date('Y-m-d').' '.$decode['close']);
        $now = Carbon::now();
        if($now->between($start_time, $end_time))
            return 1;
        else
            return 0;
    }
    
    public function getCompletedBookingAttribute()
    {
        return Booking::where([['salon_id',$this->attributes['salon_id']],['booking_status','Completed']])->count();
    }

    public function getImagePathAttribute()
    {
        return url('storage/images/salon%20logos') . '/';
    }

    public function scopeGetByDistance($query, $lat, $lang, $radius)
    {
        $results = DB::select(DB::raw('SELECT salon_id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lang . ') ) + sin( radians(' . $lat . ') ) * sin( radians(latitude) ) ) ) AS distance FROM salon HAVING distance < ' . $radius . ' ORDER BY distance'));
        if (!empty($results)) {
            $ids = [];

            foreach ($results as $q) {
                array_push($ids, $q->salon_id);
            }
            return $query->whereIn('salon_id', $ids);
        }
        return $query->whereIn('salon_id', []);
    }
    
    public function getOwnerNameAttribute()
    {
        $owner = User::find($this->attributes['owner_id']);
        if(isset($owner)) {
            return $owner->name;
        } else {
            return '';
        }
    }
     
    public function getOwnerDetailsAttribute()
    {
        $owner = User::find($this->attributes['owner_id']);
        if(isset($owner)) {
            return $owner;
        } else {
            return '';
        }
    }

    public function getServiceNameAttribute()
    {
        $ser = Service::where([['salon_id',$this->attributes['salon_id']],['status',1],['isdelete',0]])->get();
        return $ser;
    }
    
    public function service()
    {
        return $this->hasMany('App\Service');
    }
    public function gallery()
    {
        return $this->hasMany('App\Gallery');
    }
    public function employee()
    {
        return $this->hasMany('App\Employee');
    }
    public function booking()
    {
        return $this->hasMany('App\Booking');
    }
    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }
    public function review()
    {
        return $this->hasMany('App\Review');
    }
}
