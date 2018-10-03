<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $topics = \App\Topic::select(['id','name'])
        ->where('name','like','%'.$request->get('q').'%')
        ->get();
    return $topics;
});

// 获取用户关注问题的状态
Route::middleware('auth:api')
    ->post('/question/follow_status','QuestionFollowController@follow_status');
// 执行用户关注问题
Route::middleware('auth:api')
    ->post('/question/follow','QuestionFollowController@followThisQuestion');

Route::get('/user/followers/{id}','FollowerController@index');
Route::post('/user/follow','FollowerController@follow');