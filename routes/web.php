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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}', 'EmailController@verify')->name('email.verify');

Route::get('avatar','UserController@avatar');
Route::post('avatar','UserController@updateAvatar');

Route::get('password','UserController@password');
Route::post('password/update','UserController@updatePassword');

Route::get('setting','UserController@setting');
Route::post('setting','UserController@updateSetting');

Route::resource('question','QuestionController');

Route::get('/test', function () {
    return view('test');
});
