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

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

Route::get('test', function () {
    $columns = [
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
            'title' => 'Date of Birth',
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

    return json_encode($columns);
});


View::composer(['admin.modules.header', 'admin.dashboard'], function ($view) {

    $eventsCount = \App\Event::all()->count();

    $view->with([
        'eventsCount' => $eventsCount,
    ]);
});

Route::group([
    'prefix' => 'admin/_t_',
    'namespace' => 'Admin',
    'middleware' => 'auth'],
    function () {

        $table_file = Storage::disk('table_config')->get('tables.json');
        $tables_meta = json_decode($table_file);
        foreach ($tables_meta as $tableName => $tableMeta) {
            Route::get(
                $tableMeta->modelName . '/getRemoteRecords', 'TableCtrl@getRemoteRecords');

            Route::resource($tableMeta->modelName, 'TableCtrl');

            Route::post(
                $tableMeta->modelName . '/get'. $tableMeta->modelName . 'Records',
                'TableCtrl@getRecords'
            );

        }

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

