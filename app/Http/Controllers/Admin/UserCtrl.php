<?php

namespace App\Http\Controllers\Admin;

use App\User as CurrentModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserCtrl extends Controller
{
    protected $modelIndexUrl;

    protected $initData;

    protected $modelName = 'User';

    protected $tableName = 'users';

    protected $searchableColumnName = 'name';

    protected $pageTitle = 'User';

    protected $routePrefix = '/admin/';

    /* URL from where you are fetching all records for index page */
    protected $indexRecordsUrl = 'getUserRecords';

    /* Array of directories where you are storing your asset (images and files) */
    protected $dir = [
        'imageDir' => '/images/student/',
        'imageThumbDir' => '/images/student/thumb/',
        'fileDir' => '/files/student/',
    ];

    /* Columns configuration for Index, Show, Add and Update */
    protected $columns = [
        'id' => [
            'formType' => '',
            'showType' => 'text',
            'showInForm' => false,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Id',
            'requiredInForm' => true,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => null,
            'backRules' => '',
        ],
        'name' => [
            'formType' => 'text',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Name',
            'requiredInForm' => true,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'exportable w_100',
            'backRules' => 'required|max:255',
        ],
        'email' => [
            'formType' => 'email',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Email',
            'requiredInForm' => true,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'backRules' => 'required|email|max:250|unique:users',
            'backEditRules' => 'required|email|max:250',
        ],
        'password' => [
            'formType' => 'text',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => false,
            'showInView' => false,
            'title' => 'Password',
            'requiredInForm' => true,
            'widthInForm' => null,
            'displayRule' => 'Min 6 characters',
            'textAreaRows' => null,
            'indexClasses' => '',
            'backRules' => 'required|min:6|max:40',
            'backEditRules' => 'nullable|min:6|max:40',
        ],
        'level' => [
            'formType' => 'number',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Level',
            'requiredInForm' => true,
            'widthInForm' => 3,
            'displayRule' => '1 to 10',
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'backRules' => 'required',
        ],
        'created_at' => [
            'formType' => null,
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => false,
            'showInView' => true,
            'title' => 'Created At',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => null,
            'backRules' => null,
        ],
        'updated_at' => [
            'formType' => null,
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => false,
            'showInView' => true,
            'title' => 'Updated At',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => null,
            'backRules' => null,
        ],
    ];

    /* Rules to be validated by JavaScript */
    public function frontEndRules()
    {
        return "
        'name': {required: true,maxlength: 100},
        'about': {maxlength: 500},
        'dob': {date: true},
        'photo': {extension: 'jpg|jpeg|png'},
        'file': {extension: 'pdf'},
        'book': {digits: true},
        'age': {digits: true,range: [1,100]},
        'profile_link': {url: true}
        ";
    }

    function __construct()
    {

        /*
            Construction of indexing records fetch URL e.g. /admin/getRecords/
            (Don't change this)
        */
        $this->indexRecordsUrl = $this->routePrefix . $this->indexRecordsUrl . '/';

        /*
            Construction of indexing URL e.g. /admin/Model/
            (Don't change this)
        */
        $this->modelIndexUrl = $this->routePrefix . $this->modelName . '/';

        /*
            Initial data to be sent
            (Don't change this)
        */
        $this->initData = [
            'modelIndexUrl' => $this->modelIndexUrl,
            'modelName' => $this->modelName,
            'pageTitle' => $this->pageTitle,
            'indexRecordsUrl' => $this->indexRecordsUrl,
            'frontEndRules' => $this->frontEndRules(),
            'imageThumbDir' => $this->dir['imageThumbDir'],
            'imageDir' => $this->dir['imageDir'],
            'fileDir' => $this->dir['fileDir']
        ];

    }

    public function getRecords(Request $request)
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

        $query = CurrentModel::from($this->tableName);

        if ($searchVal) {
            $query->where($this->searchableColumnName, 'LIKE', '%' . $searchVal . '%');
        }

        if ($orderColumnName && $orderDir) {
            $query->orderBy($orderColumnName, $orderDir);
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

        /*********************
         *  change till here
         */

        // Don't change from here
        // Response Data

        $records = $query->get();
        $recordsTotal = CurrentModel::count();
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

    protected function getSpecificModel($id, $join)
    {

        /***********************
         * Change this
         */

        $model = null;
        if ($join) {

        } else {
            $model = CurrentModel::find($id);
        }

        return $model;
    }

    protected function setShowAndEditColumns($model)
    {
        /***********************
         * Change this
         */

        $columns = [
            'id' => [
                'value' => $model->id
            ],
            'name' => [
                'value' => $model->name
            ],
            'email' => [
                'value' => $model->email
            ],
            'password' => [
                'value' => null
            ],
            'level' => [
                'value' => $model->level
            ],
            'created_at' => [
                'value' => $model->created_at
            ],
            'updated_at' => [
                'value' => $model->updated_at
            ],
        ];
        return $columns;
    }

    public function index()
    {
        /***********************
         * Don't Change this
         */

        $data = array_merge_recursive($this->initData, ['columns' => $this->columns]);
        return view('pages.admin.record_index', $data);
    }

    public function create()
    {
        /***********************
         * Don't Change this
         */
        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->routePrefix . $this->modelName,
            'formType' => 'Add',
            'columns' => $this->columns
        ]);
        return view('pages.admin.record_form', $data);
    }

    public function store(Request $request)
    {

        /***********************
         * Don't Change this
         */

        $rules = [];

        foreach ($this->columns as $columnName => $column) {
            if ($column['backRules']) {
                $rules = array_add($rules, $columnName, $column['backRules']);
            }
        }

        $this->validate($request, $rules);

        $new_id = (CurrentModel::count() > 0) ? (CurrentModel::orderBy('id', 'desc')->get(['id'])->first()->id + 1) : (1);

        $model = new CurrentModel();

        $this->saveRecord($request, $model, $new_id);

        return redirect($this->modelIndexUrl);

    }

    public function show($id)
    {

        /***********************
         * Change this if you are not using join on tables
         */

        $model = $this->getSpecificModel($id, false);
        $showParams = $this->setShowAndEditColumns($model);

        $data = array_merge_recursive(
            $this->initData,
            ['columns' => array_merge_recursive($this->columns, $showParams)]);
        return view('pages.admin.record_show', $data);
    }

    public function edit($id)
    {

        /***********************
         * Change this if you are not using join on tables
         */

        $model = $this->getSpecificModel($id, false);

        $columnsUpdate = $this->setShowAndEditColumns($model);

        $data = array_merge_recursive($this->initData, [
            'formAction' => $this->routePrefix . $this->modelName . '/' . $model->id,
            'formType' => 'Update',
            'columns' => array_merge_recursive($this->columns, $columnsUpdate)
        ]);

        return view('pages.admin.record_form', $data);
    }

    public function update(Request $request, $id)
    {
        /***********************
         * Don't Change this
         */
        $model = CurrentModel::find($id);

        $rules = [];

        foreach ($this->columns as $columnName => $column) {
            if ($column['backRules']) {
                if (isset($column['backEditRules'])) {
                    $rules = array_add($rules, $columnName, $column['backEditRules']);
                }
                else {
                    $rules = array_add($rules, $columnName, $column['backRules']);
                }
            }
        }

        $this->validate($request, $rules);

        $new_id = $model->id;

        $this->saveRecord($request, $model, $new_id);

        return redirect($this->modelIndexUrl);
    }

    public function destroy($id)
    {
        /***********************
         * Only change file and image columns if table has assets
         */
        $model = $this->getSpecificModel($id, false);

        $model->delete();

        return redirect($this->modelIndexUrl);


    }

    public function saveRecord($request, $model, $new_id)
    {

        /***********************
         * Change this and remove image and file save code if table has no assets
         */

        $model->name = $request->get('name');
        $model->email = $request->get('email');
        $pwd = $request->get('password');
        if(isset($pwd)) {
            $model->password = Hash::make($pwd);
        }
        $model->level = $request->get('level');

        $model->save();
    }

}
