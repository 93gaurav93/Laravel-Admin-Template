<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
//    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $dateFormat = 'DD/MM/YYYY';
}
