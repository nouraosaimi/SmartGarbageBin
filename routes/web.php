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

/*Route::get('/', function () {
   return view('welcome');
  // return 'hello world';
   
});

Route::get('/about', function () {
    return view('pages.about');
   // return 'hello world';
    
 });*/


 //Route::get('/', 'loginMController@index');
 //Route::get('/', 'indexController@index');

Route::get('/Dashboard','CleanersController@openDashboard');
Route::get('/signin','CleanersController@login');
Route::get('/','CleanersController@login');
Route::post('/checkUser','CleanersController@successLogin');
Route::get('/Logout','CleanersController@Logout');


 


 Route::get('/Cleaners', 'CleanersController@Index');
 Route::get('get-cleaners-data', ['as'=>'get.cleaners','uses'=>'CleanersController@getData']);
Route::post('/AddCleaner','CleanersController@Add');
Route::post('/GetCleaner','CleanersController@GetCleanerID');
Route::post('/EditCleaner','CleanersController@EditeCleaner');
Route::post('/deleteCleaner','CleanersController@deleteCleaner');

Route::post('/AddBin','BinsContrller@Add');
Route::get('get-AssignedBins-data', ['as'=>'get.getAssignedBinsData','uses'=>'BinsContrller@getAssignedBinsData']);
Route::post('/AssignBin','BinsContrller@AssignBin');
Route::post('/GetAllBins','BinsContrller@GetAllBins');
Route::get('get-View-data', ['as'=>'get.getViewData','uses'=>'BinsContrller@getViewData']);
Route::post('/DeleteAssinedBins','BinsContrller@DeleteAssinedBins');
Route::post('/CheckAssignedBins','BinsContrller@CheckAssignedBins');




