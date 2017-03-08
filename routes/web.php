<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('layout', function () {
    return view('layouts.admin.main');
});

Route::get('addform', function () {
    return view('pages.admin.add_form');
});

Route::get('table', function () {
    $data = [
        'students' => Student::all(),
    ];
    return view('pages.admin.table', $data);
});

Route::post('getAllStudents', function (Request $request) {

    // Request Data

    $searchVal = $request->get('search')['value'];
    $start = $request->get('start');
    $length = $request->get('length');
    $draw = intval($request->get('draw'));
    $orderColumn = intval($request->get('order')[0]['column']);
    $orderDir = $request->get('order')[0]['dir'];

    $orderColumnName = $request->get('columns')[$orderColumn]['data'];


    // Query Build

    $query = DB::table('student');

    if($searchVal) {
        $query->where('name', 'LIKE', '%' . $searchVal . '%');
    }

    if ($orderColumnName && $orderDir) {
        $query->orderBy($orderColumnName, $orderDir);
    }

    if($start) {
        $query->skip($start);
    }

    if($length) {
        $query->take($length);
    }

    $query->join('book', 'student.book', '=', 'book.id');
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
});

Route::post('SubmitForm', function (Request $request) {
    $r = $request->all();
    dd($r);
});

