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

class TableCtrl extends Controller
{
    protected $modelName;
    protected $tableName;
    protected $tablesJson;
    protected $tableMeta;
    protected $columnsMeta;
    protected $initData;
    protected $urlPrefix = '/admin/_t_/';
    protected $recordsUserFilter = false;

    function __construct()
    {

        // get model name from the URL

        $urlParts = explode('/', url()->current());
        $key = array_search('_t_', $urlParts);
        $this->modelName = array_get($urlParts, $key + 1);

        //get table name by model name

        $this->tablesJson = json_decode(Storage::disk('table_config')->get('tables.json'), true);
        foreach ($this->tablesJson as $tableName => $tableMeta) {
            if ($tableMeta['modelName'] == $this->modelName) {
                $this->tableName = $tableName;
            }
        }
        if (!$this->tableName) {
            abort(404);
        }

        $this->tableMeta = $this->tablesJson[$this->tableName];

        $this->columnsMeta = json_decode(Storage::disk('table_config')->get($this->tableName . '_columns.json'), true);

        $this->recordsUserFilter = $this->tableMeta['recordsUserFilter'];

        // Construct initial data

        $this->initData = [
            'modelIndexUrl' => $this->urlPrefix . $this->modelName . '/',
            'modelName' => $this->modelName,
            'pageTitle' => $this->tableMeta['pageTitle'],
            'indexRecordsUrl' => $this->urlPrefix . $this->modelName . '/get' . $this->modelName . 'Records',
            'imageDir' => '/images/' . $this->modelName . '/',
            'imageThumbDir' => '/images/' . $this->modelName . '/thumb/',
            'fileDir' => '/files/' . $this->modelName . '/'
        ];

    }

    protected function getRecords(Request $request)
    {
        // Don't change from here

        // Request Data

        $searchVal = $request->get('search')['value'];
        $start = $request->get('start');
        $length = $request->get('length');
        $draw = intval($request->get('draw'));
        $orderColumn = intval($request->get('order')[0]['column']);
        $orderDir = $request->get('order')[0]['dir'];
        $orderColumnName = $request->get('columns')[$orderColumn]['data'];

        // Query Build

        $query = DB::table($this->tableName);

        if ($searchVal) {
            $query->where($this->tableName . '.' . $this->tableMeta['searchableColumnName'], 'LIKE', '%' . $searchVal . '%');
        }

        if ($orderColumnName && $orderDir) {
            $query->orderBy($this->tableName . '.' . $orderColumnName, $orderDir);
        }

        if ($start) {
            $query->skip($start);
        }

        if ($length) {
            $query->take($length);
        }


        // Don't change till here


        /*********************
         *  Need to change this
         */

        if (isset($this->tableMeta['hasJoins']) && $this->tableMeta['hasJoins']) {

            $joins = $this->tableMeta['joins'];

            $query->select($this->tableName . '.*');

            foreach ($joins as $join) {

                $query->leftJoin(
                    $join['foreignTable'],
                    $this->tableName . '.' . $join['localColumn'],
                    $join['condition'],
                    $join['foreignTable'] . '.' . $join['foreignColumn']
                );

                $query->addSelect(
                    $join['foreignTable']. '.' .
                    $join['foreignTitleColumn'] .
                    ' as '.
                    '_' . $join['foreignTable'] . '_title'
                );

            }

        }

        /*********************
         *  change till here
         */

        // Don't change from here

        // Filter records according to the level of user
        if ($this->recordsUserFilter && Auth::check()) {
            $currentUserLevel = Auth::user()->level;
            $query->leftJoin('users', $this->tableName.'.user_id', '=', 'users.id');
            $query->addSelect('users.level as _user_level');
            $query->where('users.level', '>=', $currentUserLevel);
        }

        // Response Data

        $unformattedRecords = $query->get();

        $records = $this->applyAccessors($this->columnsMeta, $unformattedRecords);
        $recordsTotal = DB::table($this->tableName)->count();
        $recordsFiltered = $recordsTotal;

        $data = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
        ];

        return $data;
        // Don't change till here
    }

    public function index()
    {
        $data = array_merge_recursive($this->initData, ['columns' => $this->columnsMeta]);
        return view('pages.admin.record_index', $data);
    }

    public function create()
    {
        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->urlPrefix . $this->modelName,
            'formType' => 'Add',
            'columns' => $this->columnsMeta
        ]);
        return view('pages.admin.record_form', $data);
    }

    protected function getRemoteRecords(Request $request)
    {
        if (sizeof($request->all()) == 0) {
            return null;
        }
        $urlParams = explode(':', $request->get('foreignTableAndTitle'));

        $foreignTable = array_get($urlParams, 0);
        $foreignTitleColumn = array_get($urlParams, 1);

        $models = DB::table($foreignTable)->get(['id', $foreignTitleColumn . ' as title']);
        return $models;
    }

    protected function getSpecificModel($id)
    {

        // Deny access if user tries to retrieve another user level record
        if ($this->recordsUserFilter && Auth::check()) {
            $currentUserLevel = Auth::user()->level;
            $recordUserLevel = DB::table($this->tableName)
                ->where($this->tableName.'.id', $id)
                ->leftJoin('users', $this->tableName . '.user_id', '=', 'users.id')
                ->select('users.*')
                ->first();
            if ($currentUserLevel > $recordUserLevel->level) {
                abort(403, 'Unauthorized action...!');
            }
        }

        $model = null;

        $query = DB::table($this->tableName);

        $query->where('student.id', $id);

        if (isset($this->tableMeta['hasJoins']) && $this->tableMeta['hasJoins']) {

            $joins = $this->tableMeta['joins'];

            $query->select($this->tableName . '.*');

            foreach ($joins as $join) {

                $query->leftJoin(
                    $join['foreignTable'],
                    $this->tableName . '.' . $join['localColumn'],
                    $join['condition'],
                    $join['foreignTable'] . '.' . $join['foreignColumn']
                );

                $query->addSelect(
                    $join['foreignTable']. '.' .
                    $join['foreignTitleColumn'] .
                    ' as '.
                    '_' . $join['foreignTable'] . '_title'
                );

            }

        }

        $model = $query->first();
        return $model;
    }

    public function store(Request $request)
    {
        $rules = [];

        foreach ($this->columnsMeta as $columnName => $column) {
            if ($column['backRules']) {
                $rules = array_add($rules, $columnName, $column['backRules']);
            }
        }
        $this->validate($request, $rules);

        $new_id = (DB::table($this->tableName)->count() > 0) ? (DB::table($this->tableName)->orderBy('id', 'desc')->get(['id'])->first()->id + 1) : (1);

        $this->saveRecord($request, $new_id);

        return redirect($this->initData['modelIndexUrl']);
    }

    protected function saveRecord(Request $request, $new_id)
    {

        $insertValues = $request->all();


        if(sizeof($this->tableMeta['imageColumns'])){

            $imageColumns = $this->tableMeta['imageColumns'];

            foreach ($imageColumns as $imageColumn) {

                $image = $request->file($imageColumn);

                if (is_a($image, UploadedFile::class)) {

                    $img_name = $new_id . '.jpg';

                    $img = Image::make($image);

                    $this->saveImage($img, $img_name,
                        $this->columnsMeta[$imageColumn]['imageWidth'], 90, $this->initData['imageDir']);
                    $this->saveImage($img, $img_name, 100, 50, $this->initData['imageThumbDir']);

                    $insertValues[$imageColumn] = $img_name;
                }
            }
        }

        if(sizeof($this->tableMeta['fileColumns'])){

            $fileColumns = $this->tableMeta['fileColumns'];

            foreach ($fileColumns as $fileColumn) {

                $file = $request->file($fileColumn);

                if (is_a($file, UploadedFile::class)) {

                    $ext = $file->getClientOriginalExtension();

                    $fileName = $new_id . '.' . $ext;

                    Storage::put($this->initData['fileDir'] . $fileName, file_get_contents($file));

                    $insertValues[$fileColumn] = $fileName;
                }
            }
        }

        $insertValues['created_at'] = Carbon::now();
        $insertValues['updated_at'] = Carbon::now();

        array_pull($insertValues, '_token');

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $insertValues['user_id'] = $userId;
        }

        DB::table($this->tableName)->insert($insertValues);



    }

    public function show($id)
    {
        $columnsValues = (array) $this->getSpecificModel($id);

        $data = array_merge_recursive(
            $this->initData,
            ['columns' => $this->columnsMeta],
            ['columnsValues' => $columnsValues]
        );
        return view('pages.admin.record_show', $data);

    }

    public function edit($id)
    {
        $columnsValues = (array) $this->getSpecificModel($id);

        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->urlPrefix . $this->modelName . '/' . $columnsValues['id'],
            'formType' => 'Update',
            'columns' => $this->columnsMeta,
            'columnsValues' => $columnsValues
        ]);
        return view('pages.admin.record_form', $data);
    }

    public function update(Request $request, $id)
    {

        $rules = [];

        foreach ($this->columnsMeta as $columnName => $column) {
            if ($column['backRules']) {
                $rules = array_add($rules, $columnName, $column['backRules']);
            }
        }

        $this->validate($request, $rules);

        $model = DB::table($this->tableName)->where('id', $id);

        $new_id = $id;

        $updateValues = $request->all();

        array_pull($updateValues, '_token');
        array_pull($updateValues, '_method');
        array_pull($updateValues, 'created_at');

        $updateValues['updated_at'] = Carbon::now();

        if(sizeof($this->tableMeta['imageColumns'])){

            $imageColumns = $this->tableMeta['imageColumns'];

            foreach ($imageColumns as $imageColumn) {

                if (isset($updateValues[$imageColumn])){

                    $image = $request->file($imageColumn);

                    if (is_a($image, UploadedFile::class)) {

                        $img_name = $new_id . '.jpg';

                        $img = Image::make($image);

                        $this->saveImage($img, $img_name,
                            $this->columnsMeta[$imageColumn]['imageWidth'], 90, $this->initData['imageDir']);
                        $this->saveImage($img, $img_name, 100, 50, $this->initData['imageThumbDir']);

                        $updateValues[$imageColumn] = $img_name;
                    }
                }
            }
        }


        if(sizeof($this->tableMeta['fileColumns'])){

            $fileColumns = $this->tableMeta['fileColumns'];

            foreach ($fileColumns as $fileColumn) {

                if (isset($updateValues[$fileColumn])){

                    $file = $request->file($fileColumn);

                    if (is_a($file, UploadedFile::class)) {

                        $ext = $file->getClientOriginalExtension();

                        $fileName = $new_id . '.' . $ext;

                        Storage::put($this->initData['fileDir'] . $fileName, file_get_contents($file));

                        $updateValues[$fileColumn] = $fileName;
                    }
                }
            }
        }


        $model->update($updateValues);

        return redirect($this->initData['modelIndexUrl']);
    }

    public function destroy($id)
    {

        // Deny access if user tries to retrieve another user level record
        if ($this->recordsUserFilter && Auth::check()) {
            $currentUserLevel = Auth::user()->level;
            $recordUserLevel = DB::table($this->tableName)
                ->where($this->tableName.'.id', $id)
                ->leftJoin('users', $this->tableName . '.user_id', '=', 'users.id')
                ->select('users.*')
                ->first();
            if ($currentUserLevel > $recordUserLevel->level) {
                abort(403, 'Unauthorized action...!');
            }
        }


        $model = (array) DB::table($this->tableName)->where('id', $id)->first();


        if(sizeof($this->tableMeta['imageColumns'])){

            $imageColumns = $this->tableMeta['imageColumns'];

            foreach ($imageColumns as $imageColumn) {

                if (isset($model[$imageColumn])){

                    Storage::delete([
                        $this->initData['imageDir'] . $model[$imageColumn],
                        $this->initData['imageThumbDir'] . $model[$imageColumn]
                    ]);
                }
            }
        }


        if(sizeof($this->tableMeta['fileColumns'])){

            $fileColumns = $this->tableMeta['fileColumns'];

            foreach ($fileColumns as $fileColumn) {

                if (isset($model[$fileColumn])){

                    Storage::delete([
                        $this->initData['fileDir'] . $model[$fileColumn],
                    ]);
                }
            }
        }

        DB::table($this->tableName)->where('id' , $id)->delete();

        return redirect($this->initData['modelIndexUrl']);
    }

    protected function saveImage($img, $img_name, $width, $quality, $dir)
    {
        /***********************
         * Don't Change this
         */
        $img
            ->resize($width, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })
            ->encode('jpg', $quality);

        Storage::put($dir . $img_name, $img);
    }

    protected function applyAccessors($columns, $records)
    {
        $dates = [];
        $radios = [];

        // Collecting dates and radios columns

        foreach ($columns as $name => $value) {
                if ($value['formType'] == 'date') {
                    array_push($dates, $name);
                }
                if ($value['formType'] == 'radio') {
                    array_push($radios, $name);
                }
            }

        // Date formatting

        if (sizeof($dates)) {
            foreach ($records as $record) {
                foreach ($dates as $dateColumn) {

                    if ($record->$dateColumn != null) {
                        $date = date_create($record->$dateColumn);
                        if ($dateColumn == 'created_at' || $dateColumn == 'updated_at') {
                            $fDate = date_format($date, 'd M Y - H:i:s');
                        } else {
                            $fDate = date_format($date, 'd M Y');
                        }
                        $record->$dateColumn = $fDate;
                    }
                }
            }
        }

        //Radio formatting

        if (sizeof($radios)) {
            foreach ($records as $record) {
                foreach ($radios as $radioColumn) {

                    $radioValue  = $record->$radioColumn;
                    $radioButtons = $columns[$radioColumn]['radioButtonsInForm'];
                    $radioTitle = null;
                    foreach ($radioButtons as $radioButton) {
                        if ($radioButton['value'] == $radioValue) {
                            $radioTitle = $radioButton['title'];
                        }
                    }

                    $record->$radioColumn = $radioTitle;
                }
            }
        }

        return $records;

    }
}
