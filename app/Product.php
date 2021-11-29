<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function salon(){
        return $this->belongsTo(Salon::class, 'salon_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }
}
