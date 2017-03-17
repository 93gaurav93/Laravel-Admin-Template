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
use Illuminate\Support\Facades\Auth;

Route::get('test', function () {
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth'],
    function () {

        Route::group(
            [
//                'middleware' => 'checkUserLevel:2',
            ], function () {
                Route::post('getStudents', 'StudentCtrl@getRecords');
                Route::get('getBooks', 'StudentCtrl@getBooks');
                Route::resource('Student', 'StudentCtrl');

                Route::post('getUserRecords', 'UserCtrl@getRecords');
                Route::resource('User', 'UserCtrl');
            });
    });


// Authentication routes...

Auth::routes();
Route::get('logout', function () {
    if (Auth::check()) {
        Auth::logout();
    }
    return redirect()->route('login');
});

