<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function books()
    {
        return $this->hasMany('App\Models\Book');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    /**
     * Has user any role
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return 1 == auth()->user()->roles->where('name', $role)->count();
    }

    public function hasBook($bookId)
    {
        return 1 == auth()->user()->books->where('id', $bookId)->count();
    }
}
