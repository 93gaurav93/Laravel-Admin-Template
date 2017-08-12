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

use App\Http\Controllers\Admin\FileCtrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('test', function () {
    dd(Auth::user());
});


View::composer(['layouts.admin.main', 'pages.admin.dashboard'], function ($view) {

    $tablesList = FileCtrl::getFile('table_config', 'tables.json', true, false);

    $tablesIndex = [];

    foreach ($tablesList as $tableName => $tableMeta) {

        array_push($tablesIndex, [
            'tableTitle' => $tableMeta->pageTitle,
            'userLevel' => $tableMeta->userLevel,
            'tableIndexUrl' => '/admin/_t_/' . $tableMeta->modelName,
            'recordsCount' => DB::table($tableName)->count()
        ]);
    }

    $view->with([
        'tablesIndex' => $tablesIndex,
    ]);
});

Route::group([
    'prefix' => 'admin/_t_',
    'namespace' => 'Admin',
    'middleware' => 'auth'],
    function () {

        Route::get('Dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('admin_dashboard');

        $tablesList = FileCtrl::getFile('table_config', 'tables.json', true, false);

        foreach ($tablesList as $tableName => $tableMeta) {


            Route::get(
                $tableMeta->modelName . '/getRemoteRecords', 'TableCtrl@getRemoteRecords');

            Route::resource($tableMeta->modelName, 'TableCtrl');

            Route::post(
                $tableMeta->modelName . '/get'. $tableMeta->modelName . 'Records',
                'TableCtrl@getRecords'
            );
        }



    });



Auth::routes();
Route::get('logout', function () {
    if (Auth::check()) {
        Auth::logout();
    }
    return redirect()->route('login');
});

