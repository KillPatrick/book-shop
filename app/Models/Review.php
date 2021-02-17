<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'review',
        'rating',
        'book_id',
        'user_id',
    ];

    public function book()
    {
        return $this->belongsTo('App\Model\Book');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\Book');
    }
}
