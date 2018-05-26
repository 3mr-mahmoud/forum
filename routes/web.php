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
Route::post('/threads/{channel}/{thread}/replies','ReplyController@store');
Route::get('threads','ThreadController@index');
Route::get('threads/create','ThreadController@create');
Route::get('threads/{channel}/{thread}','ThreadController@show');
Route::delete('threads/{channel}/{thread}','ThreadController@destroy');
Route::get('threads/{channel}','ThreadController@index');
Route::patch('threads/{thread}','ThreadController@update');
Route::post('threads','ThreadController@store');
Route::delete('threads/{thread}','ThreadController@destroy');
Route::get('threads/{thread}/edit','ThreadController@edit');
Route::post('replies/{reply}/favorites','FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
Route::get('profile/{user}','ProfilesController@show')->name('profile');
Route::delete('replies/{reply}','ReplyController@destroy');
Route::patch('replies/{reply}','ReplyController@update');