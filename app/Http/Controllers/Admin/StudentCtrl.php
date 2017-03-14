<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CurrentModel extends Student
{
}

class StudentCtrl extends Controller
{
    protected $modelIndexUrl;

    protected $initData;

    protected $modelName = 'Student';

    protected $tableName = 'student';

    protected $searchableColumnName = 'name';

    protected $pageTitle = 'Student';

    protected $routePrefix = '/admin/';

    /* URL from where you are fetching all records for index page */
    protected $indexRecordsUrl = 'getStudents';

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
            'backRules' => 'required|max:100',
        ],
        'about' => [
            'formType' => 'textArea',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => false,
            'showInView' => true,
            'title' => 'About',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => 'Max 500 characters',
            'textAreaRows' => 3,
            'indexClasses' => null,
            'backRules' => 'nullable|max:500',
        ],
        'dob' => [
            'formType' => 'date',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'About',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'w_100 exportable',
            'backRules' => 'nullable|date',
        ],
        'file' => [
            'formType' => 'file',
            'showType' => 'file',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'File',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => 'Max 5 MB',
            'textAreaRows' => null,
            'indexClasses' => 'no_orderable',
            'backRules' => 'nullable|file|max:5120|mimes:pdf',
        ],
        'photo' => [
            'formType' => 'image',
            'showType' => 'image',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Photo',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => 'Max 1 MB',
            'textAreaRows' => null,
            'indexClasses' => 'no_orderable',
            'backRules' => 'nullable|image|max:1024|min:1',
        ],
        '_book' => [
            'formType' => null,
            'showType' => 'text',
            'showInForm' => false,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Book',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'backRules' => null,
        ],
        'book' => [
            'formType' => 'remoteList',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => false,
            'showInView' => false,
            'title' => 'Book',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => null,
            'remoteListUrl' => '/admin/getBooks',
            'backRules' => 'nullable|numeric',
        ],
        'profile_link' => [
            'formType' => 'textArea',
            'showType' => 'url',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Profile Link',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => 2,
            'indexClasses' => 'no_orderable',
            'backRules' => 'nullable|url',
        ],
        'gender' => [
            'formType' => 'radio',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Gender',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'radioButtonsInForm' => [
                [
                    'title' => 'Male',
                    'value' => '1',
                ],
                [
                    'title' => 'Female',
                    'value' => '2',
                ],
                [
                    'title' => 'N/A',
                    'value' => '3',
                    'checked' => true
                ],
            ],
            'backRules' => '',
        ],
        'email' => [
            'formType' => 'email',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Email',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => null,
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'backRules' => 'nullable|email',
        ],
        'age' => [
            'formType' => 'number',
            'showType' => 'text',
            'showInForm' => true,
            'showInIndex' => true,
            'showInView' => true,
            'title' => 'Age',
            'requiredInForm' => false,
            'widthInForm' => null,
            'displayRule' => '1 to 100',
            'textAreaRows' => null,
            'indexClasses' => 'exportable',
            'backRules' => 'nullable|numeric|min:1|max:100',
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

        $query->leftJoin('book', 'student.book', '=', 'book.id');
        $query->select('student.*', 'book.title as _book');

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
            $model = CurrentModel::from('student')
                ->where('student.id', $id)
                ->leftJoin('book', 'student.book', '=', 'book.id')
                ->select('student.*', 'book.title as _book')
                ->first();
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
            'about' => [
                'value' => $model->about
            ],
            'dob' => [
                'value' => $model->dob
            ],
            'file' => [
                'value' => $model->file,
            ],
            'photo' => [
                'value' => $model->photo,
            ],
            'book' => [
                'value' => $model->book,
                'remoteRecordTitle' => $model->_book,
            ],
            '_book' => [
                'value' => $model->_book,
            ],
            'profile_link' => [
                'value' => $model->profile_link
            ],
            'gender' => [
                'value' => $model->gender
            ],
            'email' => [
                'value' => $model->email
            ],
            'age' => [
                'value' => $model->age
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
         * Don't Change this
         */

        $model = $this->getSpecificModel($id, true);

        $showParams = $this->setShowAndEditColumns($model);

        $data = array_merge_recursive(
            $this->initData,
            ['columns' => array_merge_recursive($this->columns, $showParams)]);
        return view('pages.admin.record_show', $data);
    }

    public function edit($id)
    {

        /***********************
         * Don't Change this
         */

        $model = $this->getSpecificModel($id, true);

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
                $rules = array_add($rules, $columnName, $column['backRules']);
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

        // Remove this if model has not any files
        // Delete files
        if (isset($model->photo)) {
            Storage::delete([
                $this->dir['imageDir'] . $model->photo,
                $this->dir['imageThumbDir'] . $model->photo
            ]);
        }

        if (isset($model->file)) {
            Storage::delete([
                $this->dir['fileDir'] . $model->file
            ]);
        }
        // Delete files End

        $model->delete();

        return redirect($this->modelIndexUrl);


    }

    public function saveRecord($request, $model, $new_id)
    {

        /***********************
         * Change this and remove image and file save code if table has no assets
         */
        // Saving Image

        $image = $request->file('photo');

        if (isset($image)) {

            if (is_a($image, UploadedFile::class)) {

                $img_name = $new_id . '.jpg';

                $img = Image::make($image);

                $this->saveImage($img, $img_name, 800, 90, $this->dir['imageDir']);
                $this->saveImage($img, $img_name, 100, 50, $this->dir['imageThumbDir']);

                $model->photo = $img_name;
            }
        }

        // Saving Image Ends

        // Saving File

        $file = $request->file('file');

        if (isset($file)) {

            if (is_a($file, UploadedFile::class)) {

                $ext = $file->getClientOriginalExtension();
                $fileName = $new_id . '.' . $ext;

                Storage::put($this->dir['fileDir'] . $fileName, file_get_contents($file));

                $model->file = $fileName;

            }
        }

        // Saving File Ends

        $model->name = $request->get('name');
        $model->about = $request->get('about');
        $model->dob = $request->get('dob');
        $model->book = $request->get('book');
        $model->profile_link = $request->get('profile_link');
        $model->gender = $request->get('gender');
        $model->email = $request->get('email');
        $model->age = $request->get('age');

        $model->save();
    }

    public function getBooks()
    {
        /***********************
         * Change this or remove this function if table has no dependency
         */
        $models = Book::get(['id', 'title']);
        return $models;
    }

    public function saveImage($img, $img_name, $width, $quality, $dir)
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
}
