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

use App\User;

Route::get('test', function () {
    $users = User::all();

    dd($users);
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin'],
    function () {

        Route::post('getStudents', 'StudentCtrl@getRecords');
        Route::get('getBooks', 'StudentCtrl@getBooks');
        Route::resource('Student', 'StudentCtrl');

        Route::post('getUsers', 'UserCtrl@getRecords');
        Route::resource('User', 'UserCtrl');

    });


