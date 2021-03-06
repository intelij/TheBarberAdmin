<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    public $primaryKey = 'review_id';
    public $timestamps = true;
    public $appends = ['display'];
    
    public function getDisplayAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function salon()
    {
        return $this->hasOne('App\Salon', 'salon_id', 'salon_id');
    }
}
