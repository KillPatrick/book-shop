<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Models\Genre');
    }
}
