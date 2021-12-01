<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeInitiatePayment extends Model
{
    protected $fillable = [
        'paymentIntent',
        'ephemeralKey',
        'customer',
        'status',
    ];
}
