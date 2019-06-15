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

Route::prefix('api')->group(function(){
    Route::post('login', 'SPAController@login');
    Route::post('logout', 'SPAController@logout');
    Route::post('register', 'SPAController@register');
    Route::get('/lastEpisodes', 'SPAController@lastEpisodes');
    Route::get('/lasItemAdded', 'SPAController@lasItemAdded');
    Route::get('episode', 'EpisodeController@index');
    Route::get('group', 'GroupController@index');
    Route::get('groupType', 'GroupTypeController@index');
    Route::get('detailEpisode/{id}', 'EpisodeController@detailEpisode');
    Route::get('detailGroup/{id}', 'EpisodeController@detailGroup');
    Route::resources(['comments' => 'CommentController']);
    

     
});
Route::get('/{any}', 'SPAController@index')->where('any','.*');


 // Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
