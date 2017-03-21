<?php

namespace App\Http\Controllers\Admin;

use App\User as CurrentModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserCtrl extends Controller
{
    public static function filterUserRecords($recordsUserFilter, $query, $tableName)
    {
        if ($tableName != 'users') {
            if ($recordsUserFilter && Auth::check()) {
                $currentUserLevel = Auth::user()->level;
                $query->leftJoin('users', $tableName . '.user_id', '=', 'users.id');
                $query->addSelect('users.level as _user_level');
                $query->where('users.level', '>=', $currentUserLevel);

                return $query;
            }
        }

        return $query;
    }

    public static function denyUserOnAccess($id, $recordsUserFilter, $tableName)
    {
        if ($tableName != 'users') {
            if ($recordsUserFilter && Auth::check()) {
                $currentUserLevel = Auth::user()->level;
                $recordUserLevel = self::getRecordUserLevel($tableName, $id);
                if ($currentUserLevel > $recordUserLevel->level) {
                    abort(403, 'Unauthorized action...!');
                }
            }
        }
        return null;
    }

    public static function getRecordUserLevel($tableName, $id)
    {
        $level = DB::table($tableName)
            ->where($tableName . '.id', $id)
            ->leftJoin('users', $tableName . '.user_id', '=', 'users.id')
            ->select('users.*')
            ->first();

        return $level;
    }
}
