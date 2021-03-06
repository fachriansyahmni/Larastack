<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/home/{id}/edit', 'HomeController@edit')->name('edit-home')->middleware('auth');
Route::put('/home/{id}', 'HomeController@update')->name('update-home');
Route::get('/', 'PertanyaanController@index');
Route::get('/pertanyaan', 'PertanyaanController@index')->name('question');
Route::get('/pertanyaan/new', 'PertanyaanController@create')->middleware('auth');
Route::post('/pertanyaan', 'PertanyaanController@store')->name('store-question');
Route::get('/pertanyaan/{id}', 'PertanyaanController@show')->name('question-detail');
Route::get('/pertanyaan/{id}/edit', 'PertanyaanController@edit')->name('edit-question')->middleware('auth');
Route::put('/pertanyaan/{id}', 'PertanyaanController@update')->name('update-question');
Route::delete('/pertanyaan/{id}', 'PertanyaanController@delete')->name('delete-question');
Route::get('/pertanyaan/komentar/{id}', 'PertanyaanController@komentar')->name('comments-question');
Route::post('/pertanyaan/komentar/{id}', 'PertanyaanController@store_comment')->name('store-comment-pertanyaan');

Route::get('/jawaban/{pertanyaan_id}', 'JawabanController@index')->name('answer');
Route::post('/jawaban/{pertanyaan_id}', 'JawabanController@store')->name('store-answer');
Route::put('/jawaban/best_answer', 'JawabanController@best_aswer')->name('best-answer');
Route::get('/jawaban/{id}/edit', 'JawabanController@edit')->name('edit-answer')->middleware('auth');
Route::put('/jawaban/{id}', 'JawabanController@update')->name('update-answer');
Route::delete('/jawaban/{id}', 'JawabanController@delete')->name('delete-answer');

Route::post('/komentar/{id}', 'KomentarJawabanController@store')->name('store-comment');

Route::post('/vote/jawaban', 'VoteJawabanController@vote')->name('vote-jawaban');
Route::post('/vote/pertanyaan', 'VotePertanyaanController@vote')->name('vote-pertanyaan');
