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

    /**
     * Returns rounded rating of the book from all the reviews
     * @return float
     */
    public function reviewsRating()
    {
       return round($this->reviews->sum('rating') / $this->reviews->count());
    }

    /**
     * Checks if book is new
     * @return bool
     */
    public function new()
    {
        if((time() - strtotime($this->created_at)) < (7 * 24 * 60 * 60)){
            return true;
        }

        return false;
    }

    /**
     * Gets discounted price
     * @return float|int
     */
    public function discountedPrice()
    {
        return $this->price * (1 - ($this->discount / 100));
    }

}
