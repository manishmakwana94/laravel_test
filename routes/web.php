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
	Route::get('/studentslist', 'StudentsController@index')->name('studentslist');
	Route::get('/getstudentlist', 'StudentsController@getStudentList')->name('getstudentlist');
	Route::get('/createstudent', 'StudentsController@create')->name('createstudent');
	Route::post('/storestudent', 'StudentsController@store')->name('storestudent');
	Route::get('/editstudents/{id}', 'StudentsController@edit')->name('editstudents');
	Route::post('/updatestudent', 'StudentsController@update')->name('updatestudent');
	Route::post('/studentdelete', 'StudentsController@destroy')->name('studentdelete');
	Route::post('/getcitydefault', 'StudentsController@getCityData')->name('getcitydefault');
});