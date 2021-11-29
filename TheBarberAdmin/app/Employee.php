<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Employee extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'email', 'password'
    ];
    protected $table = 'employee';
    public $primaryKey = 'emp_id';
    public $timestamps = true;
    public $appends = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday','imagePath','services','salon'];

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

    public function getImagePathAttribute()
    {
        return url('storage/images/employee') . '/';
    }

    public function getServicesAttribute()
    {
        $var = json_decode($this->service_id, true);
        return Service::whereIn('service_id',$var)->get();
    }
    
    public function getSalonAttribute()
    {
        $salon = Salon::find($this->attributes['salon_id']);
        return $salon;
    }

    public function salon()
    {
        return $this->belongsTo('App\Salon');
    }
    public function booking()
    {
        return $this->belongsTo('App\Booking','booking_id','id');
    }
    public function service()
    {
        return $this->hasOne('App\Service','service_id','service_id');
    }
}
