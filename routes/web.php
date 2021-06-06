<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function (){

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('userfiles', 'UserFilesController')->only(['index', 'create', 'store', 'destroy']);
});

Route::post('download/{uuid}', 'UserFilesController@download')->name('userfiles.download');
Route::get('{uuid}', 'UserFilesController@show')->name('userfiles.show');