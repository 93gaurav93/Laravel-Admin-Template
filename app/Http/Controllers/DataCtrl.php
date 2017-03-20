<?php
/**
 * Created by PhpStorm.
 * User: Gaurav
 * Date: 17/3/2017
 * Time: 15:28
 */

namespace App\Http\Controllers;


class DataCtrl
{
    public static $MyName_ = 'Gaurav';

    /**
     * @return string
     */
    public static function getMyName()
    {
        return "hi";

    }
}