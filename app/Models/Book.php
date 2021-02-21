<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
    ];

    public function getPriceAttribute($price)
    {
        return $price / 100;
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = $price * 100;
    }

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

    public function user()
    {
        return $this->belongsto('App\Models\User');
    }

    /**
     * Returns rounded rating of the book from all the reviews
     * @return float
     */
    public function reviewsRating()
    {
       $reviewsCount = $this->reviews->count();

       if($reviewsCount){
           return round($this->reviews->sum('rating') / $this->reviews->count());
       }

       return 0;
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
        if($this->discount){
            return $this->price * (1 - ($this->discount / 100));
        }

        return $this->price;
    }

    /**
     * @param $request
     * @return Book
     */
    static public function createBookWithAuthorsGenres($request)
    {
        $book = auth()->user()->books()->create($request);
        $book->genres()->attach($request['genres']);
        $authors = explode(',', $request['authors']);

        foreach($authors as $authorName){
            $author = Author::updateOrCreate(['name' => $authorName]);
            $book->authors()->attach($author->id);
        }

        return $book;
    }

    /**
     * @return string
     */
    public function getImagePathAttribute()
    {
        return  ($this->image ? 'Storage/Images/'.$this->image : 'Storage/Images/default_image.png');
    }
}
