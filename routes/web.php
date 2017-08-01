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

Route::get('/','HomeController@Home');
Route::get('/login',function(){
	return view('Pages.LogIn');
});
Route::post('/login','Authentication@LogIn');
Route::get('/register','Authentication@GetRegisterForm');
Route::post('/Register','Authentication@Register');
Route::get('logout','Authentication@LogOut');

// Log Request Handler
Route::post('AddRequest','RequestDetails@AddRequest');
Route::post('DraftRequest','RequestDetails@DraftRequest');
Route::post('SubmitRequest','RequestDetails@SubmitRequest');
Route::post('GetRequestDetailsByID','RequestDetails@GetRequestDetailsByID');

Route::post('GetRoleData','HomeController@GetRoleData');
Route::post('GetAssignmentLog','HomeController@GetAssignmentLog');
Route::post('AssignTo','HomeController@AssignTo');
Route::post('PickUpAssignment','HomeController@PickUpAssignment');
Route::post('ScheduleRequest','HomeController@ScheduleRequest');
Route::post('GetScheduleLog','HomeController@GetScheduleLog');
Route::post('DiscussionPointAddNote','HomeController@DiscussionPointAddNote');
Route::post('GetDiscussionPointNotes','HomeController@GetDiscussionPointNotes');
Route::post('AddFinalNote','HomeController@AddFinalNote');
Route::post('CancelSchedule','HomeController@CancelSchedule');

// Payment ---------------------
Route::get('TestPayment','RequestDetails@TestPayment');
Route::post('indipay/response','RequestDetails@TestPaymentResponse');













