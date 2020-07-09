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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/', 'PertanyaanController@index');
Route::get('/pertanyaan', 'PertanyaanController@index')->name('question');
Route::get('/pertanyaan/new', 'PertanyaanController@create')->middleware('auth');
Route::post('/pertanyaan', 'PertanyaanController@store')->name('store-question');
Route::get('/pertanyaan/{id}', 'PertanyaanController@show')->name('question-detail');
Route::get('/pertanyaan/{id}/edit', 'PertanyaanController@edit')->name('edit-question')->middleware('auth');
Route::put('/pertanyaan/{id}', 'PertanyaanController@update')->name('update-question');
Route::delete('/pertanyaan/{id}', 'PertanyaanController@delete')->name('delete-question');

Route::get('/jawaban/{pertanyaan_id}', 'JawabanController@index')->name('answer');
Route::post('/jawaban/{pertanyaan_id}', 'JawabanController@store')->name('store-answer');

Route::post('/komentar/{id}', 'KomentarController@store')->name('store-comment');

Route::post('/vote/jawaban', 'VoteJawabanController@vote')->name('vote-jawaban');
