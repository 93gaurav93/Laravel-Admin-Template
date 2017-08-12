<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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

        $this->modelName = UrlCtrl::getModelNameFromUrl();

        $this->tableName = UrlCtrl::getTableNameFromModelName($this->modelName);

        $this->tablesJson = FileCtrl::getFile('table_config', 'tables.json', true);

        $this->tableMeta = $this->tablesJson[$this->tableName];

        $this->middleware('checkUserLevel:' . $this->tableMeta['userLevel']);

        $this->columnsMeta = FileCtrl::getFile('table_config', $this->tableName . '_columns.json', true);

        $this->recordsUserFilter = $this->tableMeta['recordsUserFilter'];

        $this->initData = DataCtrl::getInitData($this->urlPrefix, $this->modelName, $this->tableMeta);

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

        $query->select($this->tableName . '.*');

        $query = DbCtrl::applyJoins($query, $this->tableMeta, $this->tableName);

        $query = UserCtrl::filterUserRecords($this->recordsUserFilter, $query, $this->tableName);

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
    }

    public function index()
    {
        $data = array_merge_recursive($this->initData, ['columns' => $this->columnsMeta]);
        return view('pages.admin.record_index', $data);
    }

    public function create()
    {

        $frontRules = DbCtrl::constructFrontRules($this->columnsMeta);

        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->urlPrefix . $this->modelName,
            'formType' => 'Add',
            'columns' => $this->columnsMeta,
            'frontRules' => $frontRules
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

        UserCtrl::denyUserOnAccess($id, $this->recordsUserFilter, $this->tableName);

        $model = null;

        $query = DB::table($this->tableName);

        $query->where($this->tableName . '.id', $id);

        $query->select($this->tableName . '.*');

        $query = DbCtrl::applyJoins($query, $this->tableMeta, $this->tableName);

        $model = $query->first();
        return $model;
    }

    public function store(Request $request)
    {

        DbCtrl::validateRequest($request, $this->columnsMeta, $this);

        $new_id = DbCtrl::getNewId($this->tableName);

        $this->saveRecord($request, $new_id);

        return redirect($this->initData['modelIndexUrl']);
    }

    protected function saveRecord(Request $request, $new_id)
    {

        $insertValues = $request->all();


        $insertValues =
            DbCtrl::saveImages($request, $this->tableMeta, $new_id, $this->columnsMeta, $this->initData, $insertValues);

        $insertValues =
            DbCtrl::saveFiles($request, $this->tableMeta, $new_id, $this->initData, $insertValues);

        $insertValues['created_at'] = Carbon::now();
        $insertValues['updated_at'] = Carbon::now();

        array_pull($insertValues, '_token');

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $insertValues['user_id'] = $userId;
        }

        if(isset($insertValues['password'])) {
            $insertValues['password'] = Hash::make($insertValues['password']);
        }

        DB::table($this->tableName)->insert($insertValues);


    }

    public function show($id)
    {
        $columnsValues = (array)$this->getSpecificModel($id);

        $unformattedRecords[0] = (object) $columnsValues;


        $records = $this->applyAccessors($this->columnsMeta, $unformattedRecords);

        $columnsValues = (array)$records[0];

        $data = array_merge_recursive(
            $this->initData,
            ['columns' => $this->columnsMeta],
            ['columnsValues' => $columnsValues]
        );

        return view('pages.admin.record_show', $data);

    }

    public function edit($id)
    {
        $columnsValues = (array)$this->getSpecificModel($id);

        $frontRules = DbCtrl::constructFrontRules($this->columnsMeta);

        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->urlPrefix . $this->modelName . '/' . $columnsValues['id'],
            'formType' => 'Update',
            'columns' => $this->columnsMeta,
            'columnsValues' => $columnsValues,
            'frontRules' => $frontRules
        ]);

        return view('pages.admin.record_form', $data);
    }

    public function update(Request $request, $id)
    {

        DbCtrl::validateRequest($request, $this->columnsMeta, $this);

        $model = DB::table($this->tableName)->where('id', $id);

        $updateValues = $request->all();

        array_pull($updateValues, '_token');
        array_pull($updateValues, '_method');
        array_pull($updateValues, 'created_at');

        $updateValues['updated_at'] = Carbon::now();

        $updateValues =
            DbCtrl::saveImages($request, $this->tableMeta, $id, $this->columnsMeta, $this->initData, $updateValues);

        $updateValues =
            DbCtrl::saveFiles($request, $this->tableMeta, $id, $this->initData, $updateValues);

        // Remove null values
        foreach ($updateValues as $key => $value) {
            if ($value == null) {
                array_pull($updateValues, $key);
            }
        }

        if(isset($updateValues['password'])) {
            $updateValues['password'] = Hash::make($updateValues['password']);
        }

        $model->update($updateValues);

        return redirect($this->initData['modelIndexUrl']);
    }

    public function destroy($id)
    {

        UserCtrl::denyUserOnAccess($id, $this->recordsUserFilter, $this->tableName);

        $model = (array)DB::table($this->tableName)->where('id', $id)->first();

        if (isset($this->tableMeta['imageColumns']) && sizeof($this->tableMeta['imageColumns'])) {

            $imageColumns = $this->tableMeta['imageColumns'];

            foreach ($imageColumns as $imageColumn) {

                if (isset($model[$imageColumn])) {

                    Storage::delete([
                        $this->initData['imageDir'] . $model[$imageColumn],
                        $this->initData['imageThumbDir'] . $model[$imageColumn]
                    ]);
                }
            }
        }

        if (isset($this->tableMeta['fileColumns']) && sizeof($this->tableMeta['fileColumns'])) {

            $fileColumns = $this->tableMeta['fileColumns'];

            foreach ($fileColumns as $fileColumn) {

                if (isset($model[$fileColumn])) {

                    Storage::delete([
                        $this->initData['fileDir'] . $model[$fileColumn],
                    ]);
                }
            }
        }

        DB::table($this->tableName)->where('id', $id)->delete();

        return redirect($this->initData['modelIndexUrl']);
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

                    $radioValue = $record->$radioColumn;
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
