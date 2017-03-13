<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StudentCtrl extends Controller
{

    public $rules = [
        'name' => 'required|max:100',
        'image' => 'nullable|image|max:1024|min:1',
        'about' => 'nullable|max:500',
        'dob' => 'nullable|date',
        'book' => 'nullable|numeric',
        'email' => 'nullable|email',
        'file' => 'nullable|file|max:5120|mimes:pdf',
        'profile_link' => 'nullable|url',
        'age' => 'nullable|numeric|min:1|max:100'
    ];

    public $dir = [
        'imageDir' => '/images/student/',
        'imageThumbDir' => '/images/student/thumb/',
        'fileDir' => '/files/student/',
    ];

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

    public $modelName = 'Student';
    public $pageTitle = 'Student';
    public $routePrefix = '/admin/';
    public $formFieldsAdd = [];
    public $formFieldsUpdate = [];
    public $dataToSend = [];
    public $indexParams = [];

    function __construct()
    {
        $this->formFieldsAdd = [
            'name' => [
                'type' => 'text',
                'title' => 'Name',
                'required' => true,
            ],
            'about' => [
                'type' => 'textArea',
                'title' => 'About',
            ],
            'dob' => [
                'type' => 'date',
                'title' => 'Date of Birth',
                'width' => '6'
            ],
            'file' => [
                'type' => 'file',
                'title' => 'File',
                'rule' => 'Max. Size : 1 MB'
            ],
            'photo' => [
                'type' => 'file',
                'title' => 'Photo',
                'rule' => 'Max. Size : 5 MB'
            ],
            'book' => [
                'type' => 'remoteList',
                'title' => 'Book',
                'remoteUrl' => '/admin/getBooks',
                'width' => '6'
            ],
            'profile_link' => [
                'type' => 'textArea',
                'title' => 'Profile Link',
                'rows' => '1'
            ],
            'gender' => [
                'type' => 'radio',
                'title' => 'Gender',
                'radios' => [
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
                    ],
                ]
            ],
            'email' => [
                'type' => 'email',
                'title' => 'Email',
            ],
            'age' => [
                'type' => 'number',
                'title' => 'Age',
                'width' => '3',
                'rule' => 'Between 1 to 100'
            ],
        ];

        $this->dataToSend = [
            'modelIndexUrl' => $this->routePrefix . $this->modelName,
            'modelName' => $this->modelName,
            'pageTitle' => $this->pageTitle,
            'frontEndRules' => $this->frontEndRules(),
            'imageThumbDir' => $this->dir['imageThumbDir'],
            'imageDir' => $this->dir['imageDir'],
            'fileDir' => $this->dir['fileDir']
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
                'Date of Birth' => [
                    'type' => 'text',
                    'tableColumn' => 'dob',
                    'class' => 'w_100 exportable',
                    'showInIndex' => true
                ],
                'Photo' => [
                    'type' => 'image',
                    'tableColumn' => 'photo',
                    'class' => 'no_orderable',
                    'showInIndex' => true
                ],
                'File' => [
                    'type' => 'file',
                    'tableColumn' => 'file',
                    'class' => 'no_orderable',
                    'showInIndex' => true
                ],
                'Book' => [
                    'type' => 'text',
                    'tableColumn' => 'book',
                    'class' => 'w_150 exportable',
                    'showInIndex' => true
                ],
                'Profile Link' => [
                    'type' => 'url',
                    'tableColumn' => 'profile_link',
                    'class' => 'no_orderable',
                    'showInIndex' => true
                ],
                'Gender' => [
                    'type' => 'text',
                    'tableColumn' => 'gender',
                    'class' => 'exportable',
                    'showInIndex' => true
                ],
                'Email' => [
                    'type' => 'text',
                    'tableColumn' => 'email',
                    'class' => 'exportable',
                    'showInIndex' => true
                ],
                'Age' => [
                    'type' => 'text',
                    'tableColumn' => 'age',
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

        $query = Student::from('student');

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

        $query->leftJoin('book', 'student.book', '=', 'book.id');
        $query->select('student.*', 'book.title as book_title');


        // Response Data

        $records = $query->get();
        $recordsTotal = Student::count();
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

        $new_id = (Student::count() > 0) ? (Student::orderBy('id', 'desc')->get(['id'])->first()->id + 1) : (1);

        $student = new Student();

        $this->saveRecord($request, $student, $new_id);

        return redirect()->route('Student.index');

    }


    public function show($id)
    {
        $student = Student::
        where('student.id', $id)
            ->leftJoin('book', 'student.book', '=', 'book.id')
            ->select('student.*', 'book.title as book_title')
            ->first();

        $showParams = [
            'columnDefs' => [
                'Id' => [
                    'value' => $student->id
                ],
                'Name' => [
                    'value' => $student->name
                ],
                'Date of Birth' => [
                    'value' => $student->dob
                ],
                'Photo' => [
                    'value' => $student->photo
                ],
                'File' => [
                    'value' => $student->file
                ],
                'Book' => [
                    'value' => $student->book
                ],
                'Profile Link' => [
                    'value' => $student->profile_link
                ],
                'Gender' => [
                    'value' => $student->gender
                ],
                'Email' => [
                    'value' => $student->email
                ],
                'Age' => [
                    'value' => $student->age
                ],
                'Created At' => [
                    'value' => $student->created_at
                ],
                'Updated At' => [
                    'value' => $student->updated_at
                ],
            ]
        ];

        $data = array_merge_recursive($this->dataToSend, $this->indexParams, $showParams);


        return view('pages.admin.record_show', $data);
    }


    public function edit($id)
    {
        $student = Student::
        where('student.id', $id)
            ->leftJoin('book', 'student.book', '=', 'book.id')
            ->select('student.*', 'book.title as book_title')
            ->first();

        $this->formFieldsUpdate = [
            'name' => [
                'value' => $student->name
            ],
            'about' => [
                'value' => $student->about
            ],
            'dob' => [
                'value' => $student->dob
            ],
            'file' => [
                'value' => $student->file,
                'dirName' => $this->dir['fileDir'],
                'isImage' => false,
            ],
            'photo' => [
                'value' => $student->photo,
                'dirName' => $this->dir['imageThumbDir'],
                'isImage' => false,
            ],
            'book' => [
                'value' => $student->book,
                'remoteRecordTitle' => $student->book_title,
            ],
            'profile_link' => [
                'value' => $student->profile_link
            ],
            'gender' => [
                'value' => $student->gender
            ],
            'email' => [
                'value' => $student->email
            ],
            'age' => [
                'value' => $student->age
            ],
        ];

        $data = array_merge_recursive($this->dataToSend, [
            'formAction' => $this->routePrefix . $this->modelName . '/' . $student->id,
            'formType' => 'Update',
            'formFields' => array_merge_recursive($this->formFieldsAdd, $this->formFieldsUpdate)
        ]);

        return view('pages.admin.record_form', $data);
    }


    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $this->validate($request, $this->rules);

        $new_id = $student->id;

        $this->saveRecord($request, $student, $new_id);

        return redirect()->route('Student.index');
    }


    public function destroy($id)
    {
        $student = Student::find($id);

        if (isset($student->photo)) {
            Storage::delete([
                $this->dir['imageDir'] . $student->photo,
                $this->dir['imageThumbDir'] . $student->photo
            ]);
        }

        if (isset($student->file)) {
            Storage::delete([
                $this->dir['fileDir'] . $student->file
            ]);
        }

        $student->delete();

        return redirect()->route('Student.index');


    }

    public function saveRecord($request, $student, $new_id)
    {
        // Saving Image

        $image = $request->file('photo');

        if (isset($image)) {

            if (is_a($image, UploadedFile::class)) {

                $img_name = $new_id . '.jpg';

                $img = Image::make($image);

                $this->saveImage($img, $img_name, 800, 90, $this->dir['imageDir']);
                $this->saveImage($img, $img_name, 100, 50, $this->dir['imageThumbDir']);

                $student->photo = $img_name;
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

                $student->file = $fileName;

            }
        }

        // Saving File Ends

        $student->name = $request->get('name');
        $student->about = $request->get('about');
        $student->dob = $request->get('dob');
        $student->book = $request->get('book');
        $student->profile_link = $request->get('profile_link');
        $student->gender = $request->get('gender');
        $student->email = $request->get('email');
        $student->age = $request->get('age');

        $student->save();
    }

    public function getBooks()
    {
        $books = Book::get(['id', 'title']);
        return $books;
    }

    public function saveImage($img, $img_name, $width, $quality, $dir)
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
