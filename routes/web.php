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

Route::get('/','QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('question','QuestionController');
// Route::post('question/{id}','QuestionController@update');		// 表单伪造 PUT 请求失败

//回答
Route::post('question/{questionId}/answer','AnswerController@store')->name('question.answer')->middleware('auth');;

//标签
Route::get('/label/{id}','LabelController@show')->name('label.show');

//用户
Route::get('/user/{id?}','UserController@show')->name('user.show');

//个人主页
Route::get('/user/{id?}/questions','UserController@show')->name('user.questions');
Route::get('/user/{id?}/answers','UserController@show')->name('user.answers');
Route::get('/user/{id?}/follows','UserController@show')->name('user.follows');
Route::get('/user/{id?}/followers','UserController@show')->name('user.followers');

//点赞
Route::get('/answer/{id}/like','LikeController@answer')->name('answer.like');

//关注
Route::get('/follow/{id}/user','FollowController@user')->name('user.follow');
Route::get('/follow/{id}/question','FollowController@question')->name('question.follow');
Route::get('/follow/{id}/label','FollowController@label')->name('label.follow');


//私信
Route::post('/user/message','MessageController@store')->name('user.message');
Route::get('/user/{id}/message','MessageController@show')->name('message.read');

//通知
Route::get('/notification/show','NotificationController@show')->name('notification.show');
Route::get('/notification/read','NotificationController@read')->name('notification.read');

