<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

 
//Login
Route::get('/','LoginController@index'); 
Route::get('login', 'LoginController@formLogin');
Route::post('login', 'LoginController@login');

//Logout
Route::get('logout/{id_user}', 'LoginController@logout');

//Home
Route::get('home', 'HomeController@index'); 

//Administrasi
Route::get('{id_survey}/administrasi', 'AdministrasiController@index');
Route::post('{id_survey}/administrasi/tambah', 'AdministrasiController@postAdministrasi');
Route::get('{id_survey}/administrasi/{user_hakakses}/edit', 'AdministrasiController@editAdministrasi');
Route::post('{id_survey}/administrasi/{user_hakakses}/edit', 'AdministrasiController@saveAdministrasi');

//user
Route::get('user', 'UserController@index');
Route::post('user/create', 'UserController@create');
Route::get('user/edit/{id_user}', 'UserController@edit');
Route::get('user/delete/{id_user}', 'UserController@delete'); 
Route::get('user/tableuser', 'UserController@tableuser');

//Survey
Route::get('createsurvey', 'SurveyController@index');
Route::post('createsurvey', 'SurveyController@create');
Route::get('survey/{id_survey}', 'SurveyController@survey');
Route::get('survey/{id_survey}/edit', 'SurveyController@formEdit');
Route::post('survey/{id_survey}/edit', 'SurveyController@editSurvey');
Route::get('survey/{id_survey}/create', 'TahapanController@viewcreatetahapan');
Route::post('survey/{id_survey}/create', 'TahapanController@viewcreatetahapan');
Route::get('{id_survey}/{id_tahapan}', 'TahapanController@viewTahapan');

//input data
Route::get('{id_survey}/{id_tahapan}/input', 'InputController@index');
Route::post('{id_survey}/{id_Tahapan}/input/tambah', 'InputController@tambah');
Route::post('{id_survey}/{id_Tahapan}/input/tambah/file', 'InputController@tambahdgnfile');

