<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';

    public function getDobAttribute($value)
    {
        if (!$value) return null;

        $date = date("d-M-Y", strtotime($value));
        return $date;
    }

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

    public function getGenderAttribute($value)
    {
        if ($value) {
            switch ($value) {
                case 1: {
                    return 'Male';
                }
                case 2: {
                    return 'Female';
                }
                default: {
                    return 'N/A';
                }
            }
        } else {
            return null;
        }
    }

    public function setDobAttribute($value)
    {
        if ($value) {

            $date = strtotime($value);
            $date = date('Y-m-d', $date);

            $this->attributes['dob'] = $date;
        }
        else {
            $this->attributes['dob'] = null;
        }

    }
}
