<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
