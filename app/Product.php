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

    public function getStatusAttribute(){
        return $this->is_active == 1 ? "Active" : "In-active";
    }

    public function getFirstImageAttribute(){
        $imageUrl = "https://dummyimage.com/600x400/000/ffffff&text=No+image";
        if(count($this->images) > 0){
            if($this->images[0]){
                if($this->images[0]->image_url){
                    return asset('storage/images/product/'.$this->images[0]->image_url);
                }
                else{
                    return $imageUrl;
                }
            }
            else{
                return $imageUrl;
            }
        }
        else{
            return $imageUrl;
        }
    }
}
