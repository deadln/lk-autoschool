<?php
use App\Http\Middleware\Auth;
use App\Http\Middleware\CheckAuthLoginPage;
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

Route::get('/', "Auth@index")->middleware('CheckAuthLoginPage');
Route::post('/login', 'Auth@login')->middleware('CheckAuthLoginPage');
Route::match(['get','post'], '/register', 'Auth@register');
Route::get('/exit', 'Auth@logout');
Route::get('/pay', 'PayController@index');

Route::post('/pay/checkurl','PayController@checkurl');
Route::post('/pay/avisourl','PayController@checkurl');

Route::get('/pay/shopsuccessurl','PayController@shopsuccessurl');
Route::get('/pay/shopfailurl','PayController@shopfailurl');
Route::get('/technical-break', 'PayController@technical_break');
Route::get('test-online-kassa', 'PayController@testOnlineKassa');
Route::match(['get', 'post'], 'test-checkbox', 'TestController@index');
Route::match(['get', 'post'], 'test-otvet', 'TestController@otvet');

Route::group(['middleware'=>'CheckAuth'], function (){
	Route::get('/profile', 'UsersController@profile');
	Route::get('/users', 'UsersController@index');
    Route::get('/users-no-active', 'UsersController@NoActiveUsers');
	Route::match(['get', 'post'], '/users/add', 'UsersController@add');
	Route::match(['get', 'post'], '/users/edit/{id?}', 'UsersController@edit');
	Route::match(['get', 'post'], '/users/schedule/{id?}', 'UsersController@edit_schedule');
	Route::get('/users/change-password/{id?}', 'UsersController@changePassword');
    Route::get('/users/active/{id?}', 'UsersController@active_user');
	Route::get('/users/remove/{id?}', 'UsersController@remove_user');
	Route::get('/users/students', 'UsersController@students');

	Route::get('/driving', 'UsersController@driving');

	Route::get('/offices', 'OfficesController@index');
	Route::match(['get', 'post'], '/offices/add', 'OfficesController@add');
	Route::match(['get', 'post'], '/offices/edit/{id?}', 'OfficesController@edit');
	Route::get('/offices/remove/{id?}', 'OfficesController@remove');

	Route::get('/group', 'GroupController@index');
	Route::match(['get','post'],'/group/add', 'GroupController@add');
	Route::match(['get','post'],'group/edit/{id?}', 'GroupController@edit');
	Route::get('/group/remove/{id?}', 'GroupController@remove');
	Route::get('static/', 'StatisticsController@index');
	Route::get('raspisanie/', 'OnlineRecordController@index');
	Route::match(['get', 'post'], 'online-record/', 'OnlineRecordController@record');
	Route::match(['get', 'post'], 'online-record/edit/{id?}', 'OnlineRecordController@edit_record');
	Route::get('online-record/remove', 'OnlineRecordController@remove');
	Route::get('week-shift/', 'WeekShift@index');
	Route::get('week-shift/{id?}', 'WeekShift@week');

	Route::get('payments-info/', 'PaymentsInfo@index');
});
