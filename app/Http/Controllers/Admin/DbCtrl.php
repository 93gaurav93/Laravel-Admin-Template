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

class DbCtrl extends Controller
{
    public static function applyJoins($query, $tableMeta, $tableName)
    {

        if (isset($tableMeta['joins']) && sizeof($tableMeta['joins'])) {

            $joins = $tableMeta['joins'];


            foreach ($joins as $joinInfo) {


                $query->leftJoin(
                    $joinInfo['foreignTable'],
                    $tableName . '.' . $joinInfo['localColumn'],
                    $joinInfo['condition'],
                    $joinInfo['foreignTable'] . '.' . $joinInfo['foreignColumn']
                );

                $query->addSelect(
                    $joinInfo['foreignTable'] . '.' .
                    $joinInfo['foreignTitleColumn'] .
                    ' as ' .
                    '_' . $joinInfo['foreignTable'] . '_title'
                );

            }
            return $query;
        }
        return $query;
    }

    public static function getNewId($tableName)
    {
        return (DB::table($tableName)->count() > 0) ? (DB::table($tableName)->orderBy('id', 'desc')->get(['id'])->first()->id + 1) : (1);
    }

    public static function validateRequest($request, $columnsMeta, $classInstance)
    {
        $rules = [];

        foreach ($columnsMeta as $columnName => $column) {
            if (isset($column['backRules']) && isset($column['backEditRules'])) {
                $rules = array_add($rules, $columnName, $column['backEditRules']);
            }
            if (isset($column['backRules']) && !isset($column['backEditRules'])) {
                $rules = array_add($rules, $columnName, $column['backRules']);
            }
        }
        $classInstance->validate($request, $rules);
    }

    public static function constructFrontRules($columnsMeta)
    {
        $frontRules = '';
        foreach ($columnsMeta as $name => $column) {
            if ($column['showInForm'] && isset($column['frontRules']) && isset($column['frontEditRules'])) {
                $frontRules .= "'" . $name . "': " . "{" . $column['frontEditRules'] . "},";
            }
            if ($column['showInForm'] && isset($column['frontRules']) && !isset($column['frontEditRules'])) {
                $frontRules .= "'" . $name . "': " . "{" . $column['frontRules'] . "},";
            }
        }

        return $frontRules;
    }

    public static function saveImages($request, $tableMeta, $id, $columnsMeta, $initData, $insertValues)
    {
        if (isset($tableMeta['imageColumns']) && sizeof($tableMeta['imageColumns'])) {

            $imageColumns = $tableMeta['imageColumns'];

            foreach ($imageColumns as $imageColumn) {

                if (isset($insertValues[$imageColumn])) {

                    $image = $request->file($imageColumn);

                    if (is_a($image, UploadedFile::class)) {

                        $img_name = $id . '.jpg';

                        $img = Image::make($image);

                        self::saveImage($img, $img_name,
                            $columnsMeta[$imageColumn]['imageWidth'], 90, $initData['imageDir']);
                        self::saveImage($img, $img_name, 100, 50, $initData['imageThumbDir']);

                        $insertValues[$imageColumn] = $img_name;
                    }
                }
            }
            return $insertValues;
        }
        return $insertValues;
    }

    public static function saveFiles($request, $tableMeta, $id, $initData, $insertValues)
    {
        if (isset($tableMeta['fileColumns']) && sizeof($tableMeta['fileColumns'])) {

            $fileColumns = $tableMeta['fileColumns'];

            foreach ($fileColumns as $fileColumn) {

                if (isset($insertValues[$fileColumn])) {

                    $file = $request->file($fileColumn);

                    if (is_a($file, UploadedFile::class)) {

                        $ext = $file->getClientOriginalExtension();

                        $fileName = $id . '.' . $ext;

                        Storage::put($initData['fileDir'] . $fileName, file_get_contents($file));

                        $insertValues[$fileColumn] = $fileName;
                    }
                }
            }
            return $insertValues;
        }
        return $insertValues;
    }

    public static function saveImage($img, $img_name, $width, $quality, $dir)
    {
        $img
            ->resize($width, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })
            ->encode('jpg', $quality);

        Storage::put($dir . $img_name, $img);
    }
}
