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

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
    return ['user'=>$request->user(),'token'=> \Auth::user()->remember_token];
    });

    Route::get('userAcitivty/{type}','UserController@userActivity');
    Route::post('user/{id}', 'UserController@update');
    Route::post('group/{id}', 'GroupController@update');
    Route::post('episode/{id}', 'EpisodeController@update');

    Route::resources([
        'likes' => 'LikeController',
        'notify' => 'NotificationController',
        'servers' => 'ServersController',
        'episode' => 'EpisodeController',
        'favorites' => 'FavoriteController',
        'group' => 'GroupController',
        'user' => 'UserController',
        'rating' => 'RateController',
        'groupType' => 'GroupTypeController',
        'setting' => 'SettingController'
    ]);


});
