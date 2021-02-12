<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function new()
    {
        $new = false;
        if((time() - strtotime($this->created_at)) < (7 * 24 * 60 * 60)){
            $new = true;
        }

        return $new;
    }

    public function discountedPrice()
    {
        $discountedPrice = $this->price * (1 - ($this->discount / 100));
        return $discountedPrice;
    }

}
