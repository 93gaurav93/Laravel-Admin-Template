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

class FileCtrl extends Controller
{
    public static function getFile($disk, $fileName, $json, $assoc = true)
    {

        if(Storage::disk($disk)->exists($fileName)){
            if ($json) {
                $file = json_decode(Storage::disk($disk)->get($fileName), $assoc);
            } else {
                $file = Storage::disk($disk)->get($fileName);
            }
            return $file;
        }
        else{
            abort(403, 'File ' . $fileName . ' not found in disk ' . $disk);
        }

    }
}
