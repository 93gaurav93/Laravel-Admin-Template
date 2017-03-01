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

Route::post('SubmitForm', function (Request $request) {
    $r = $request->all();
    dd($r);
});

