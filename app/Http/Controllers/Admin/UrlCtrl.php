<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UrlCtrl extends Controller
{
    public static function getModelNameFromUrl()
    {
        $urlParts = explode('/', url()->current());
        $key = array_search('_t_', $urlParts);
        return array_get($urlParts, $key + 1);
    }

    public static function getTableNameFromModelName($modelName)
    {
        $tablesJson = FileCtrl::getFile( 'table_config', 'tables.json', true);

        $tableName = null;
        foreach ($tablesJson as $name => $tableMeta) {
            if ($tableMeta['modelName'] == $modelName) {
                $tableName = $name;
            }
        }
        if ($tableName == null) {
            abort(404, "Unable to fetch table name. Verify model name and table name in tables.json");
        }
        return $tableName;
    }

}
