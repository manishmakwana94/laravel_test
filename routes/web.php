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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group([ 'middleware' => ['auth:web'], 'as'=> 'student.'], function () {
	Route::get('/getstudentlist', 'StudentsController@getStudentList')->name('getstudentlist');
	Route::post('/getcitydefault', 'StudentsController@getCityData')->name('getcitydefault');
});
Route::group([ 'middleware' => ['auth:web']], function () {
	Route::resource('students','StudentsController');
});