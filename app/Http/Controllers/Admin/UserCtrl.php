<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserCtrl extends Controller
{
    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|max:250|email|unique:users',
        'password' => 'required|min:6|max:40|confirmed',
        'level' => 'numeric|min:1|max:10'
    ];

    public function frontEndRules()
    {
        return "
        'name': {required: true,maxlength: 255},
        'email': {required: true,maxlength: 255,email: true},
        'password': {required:true,minlength: 6,maxlength: 255},
        'level': {digits: true,range: [1,10]}
        ";
    }

    public $modelName = 'User';
    public $pageTitle = 'User';
    public $routePrefix = '/admin/';
    public $indexRecordsUrl = 'getUsers';
    public $formFieldsAdd = [];
    public $formFieldsUpdate = [];
    public $dataToSend = [];
    public $indexParams = [];

    function __construct()
    {

        $this->indexRecordsUrl = $this->routePrefix . $this->indexRecordsUrl . '/';

        $this->formFieldsAdd = [
            'name' => [
                'type' => 'text',
                'title' => 'Name',
                'required' => true,
            ],
            'email' => [
                'type' => 'email',
                'title' => 'Email',
            ],
            'password' => [
                'type' => 'text',
                'title' => 'Password'
            ],
            'password_confirmation' => [
                'type' => 'text',
                'title' => 'Password Confirmation'
            ],
            'level' => [
                'type' => 'number',
                'title' => 'Level',
                'width' => '3',
                'rule' => 'Between 1 to 10'
            ],
        ];

        $this->dataToSend = [
            'modelIndexUrl' => $this->routePrefix . $this->modelName . '/',
            'modelName' => $this->modelName,
            'pageTitle' => $this->pageTitle,
            'indexRecordsUrl' => $this->indexRecordsUrl,
            'frontEndRules' => $this->frontEndRules()
        ];

        $this->indexParams = [
            'columnDefs' => [
                'Id' => [
                    'type' => 'text',
                    'showInIndex' => false
                ],
                'Name' => [
                    'type' => 'text',
                    'tableColumn' => 'name',
                    'class' => 'exportable',
                    'showInIndex' => true
                ],
                'Email' => [
                    'type' => 'text',
                    'tableColumn' => 'email',
                    'class' => 'w_100 exportable',
                    'showInIndex' => true
                ],
                'Level' => [
                    'type' => 'text',
                    'tableColumn' => 'level',
                    'class' => 'exportable',
                    'showInIndex' => true
                ],
                'Created At' => [
                    'type' => 'text',
                    'showInIndex' => false
                ],
                'Updated At' => [
                    'type' => 'text',
                    'showInIndex' => false
                ],
            ]
        ];
    }

    public function index()
    {
        $data = array_merge_recursive($this->dataToSend, $this->indexParams);
        return view('pages.admin.record_index', $data);
    }

    public function getRecords(Request $request)
    {
        // Request Data

        $searchVal = $request->get('search')['value'];
        $start = $request->get('start');
        $length = $request->get('length');
        $draw = intval($request->get('draw'));
        $orderColumn = intval($request->get('order')[0]['column']);
        $orderDir = $request->get('order')[0]['dir'];

        $orderColumnName = $request->get('columns')[$orderColumn]['data'];


        // Query Build

        $query = User::from('users');

        if ($searchVal) {
            $query->where('name', 'LIKE', '%' . $searchVal . '%');
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


        // Response Data

        $records = $query->get();
        $recordsTotal = User::count();
        $recordsFiltered = $recordsTotal;

        $data = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
        ];

        return $data;
    }

    public function create()
    {

        $data = array_merge_recursive($this->dataToSend, [
            'formAction' => $this->routePrefix . $this->modelName,
            'formType' => 'Add',
            'formFields' => $this->formFieldsAdd
        ]);

        return view('pages.admin.record_form', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $user = new User();

        $this->saveRecord($request, $user);

        return redirect()->route('User.index');
    }


    public function show($id)
    {
        $user = User::
        where('users.id', $id)->first();

        $showParams = [
            'columnDefs' => [
                'Id' => [
                    'value' => $user->id
                ],
                'Name' => [
                    'value' => $user->name
                ],
                'Email' => [
                    'value' => $user->email
                ],
                'Level' => [
                    'value' => $user->level
                ],
                'Created At' => [
                    'value' => $user->created_at
                ],
                'Updated At' => [
                    'value' => $user->updated_at
                ],
            ]
        ];

        $data = array_merge_recursive($this->dataToSend, $this->indexParams, $showParams);


        return view('pages.admin.record_show', $data);
    }


    public function edit($id)
    {
        $user = User::
        where('users.id', $id)->first();

        $this->formFieldsUpdate = [
            'name' => [
                'value' => $user->name
            ],
            'email' => [
                'value' => $user->email
            ],
            'password' => [
                'value' => $user->password
            ],
            'password_confirmation' => [
                'value' => $user->password
            ],
            'level' => [
                'value' => $user->level
            ],
        ];

        $data = array_merge_recursive($this->dataToSend, [
            'formAction' => $this->routePrefix . $this->modelName . '/' . $user->id,
            'formType' => 'Update',
            'formFields' => array_merge_recursive($this->formFieldsAdd, $this->formFieldsUpdate)
        ]);

        return view('pages.admin.record_form', $data);
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, $this->rules);

        $this->saveRecord($request, $user);

        return redirect()->route('User.index');
    }


    public function destroy($id)
    {
        $user = User::find($id);


        $user->delete();

        return redirect()->route('User.index');


    }

    public function saveRecord($request, $user)
    {

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->level = $request->get('level');

        $user->save();
    }

}
