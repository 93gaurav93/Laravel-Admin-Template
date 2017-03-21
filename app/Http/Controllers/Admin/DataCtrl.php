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

class DataCtrl extends Controller
{
    public static function getInitData($urlPrefix, $modelName, $tableMeta)
    {
        $initData = [
            'modelIndexUrl' => $urlPrefix . $modelName . '/',
            'modelName' => $modelName,
            'pageTitle' => $tableMeta['pageTitle'],
            'indexRecordsUrl' => $urlPrefix . $modelName . '/get' . $modelName . 'Records',
            'imageDir' => '/images/' . $modelName . '/',
            'imageThumbDir' => '/images/' . $modelName . '/thumb/',
            'fileDir' => '/files/' . $modelName . '/'
        ];

        return $initData;
    }

}
