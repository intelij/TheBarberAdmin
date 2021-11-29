<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $appends = ['services','userDetails','empDetails','addressDetails','currencySymbol','status'];


    public function salon()
    {
        return $this->hasOne('App\Salon', 'salon_id', 'salon_id');
    }
    public function employee()
    {
        return $this->hasOne('App\Employee', 'emp_id', 'emp_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function review()
    {
        return $this->hasOne('App\Review', 'booking_id','id');
    }

    public function getServicesAttribute()
    {
        $var = json_decode($this->service_id, true);
        return Service::whereIn('service_id',$var)->get();
    }
    public function getUserDetailsAttribute()
    {
        return User::find($this->user_id);
    }
    public function getEmpDetailsAttribute()
    {
        return Employee::find($this->emp_id);
    }
    public function getAddressDetailsAttribute()
    {
        return Address::find($this->address_id);
    }
    public function getCurrencySymbolAttribute()
    {
        return AdminSetting::first()->currency_symbol;
    }
    public function getStatusAttribute()
    {
        if($this->booking_status == "Pending")
            return 0;
        else if($this->booking_status == "Completed")
            return 1;
        else if($this->booking_status == "Cancel")
            return 3;
        else 
            return 4;
    }
}
