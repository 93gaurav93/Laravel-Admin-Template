<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getCreatedAtAttribute($value)
    {
        if (!$value) return null;

        $date = date("d-M-Y H:i:s", strtotime($value));
        return $date;
    }

    public function getUpdatedAtAttribute($value)
    {
        if (!$value) return null;

        $date = date("d-M-Y H:i:s", strtotime($value));
        return $date;
    }
}
