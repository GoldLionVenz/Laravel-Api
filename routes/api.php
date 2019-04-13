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
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        
    });
});
Route::post('addserie', 'seriesController@add');
Route::post('addseason','seasonController@create');
Route::post('addepisodes','episodesController@add');
Route::get('episodes','episodesController@getEpisodes');
Route::get('title/{serie}','SeriesController@title');
Route::get('series','seriesController@all');
Route::post('suscribe','seriesController@suscribe')->middleware('auth:api');
Route::post('unsubscribe','seriesController@unsubscribe')->middleware('auth:api');
Route::get('watch/{episode}','episodesController@show');
Route::post('comment/{episode}','episodesController@addComment')->middleware('auth:api');
Route::get('comments/{episode}','episodesController@getComments');
Route::get('notications','AuthController@userNotications')->middleware('auth:api');
Route::get('noticationsunread','AuthController@userUnReadNotications')->middleware('auth:api');
Route::post('markasreadnotication','AuthController@markAsRead')->middleware('auth:api');
Route::post('markasreadnotications','AuthController@markAsReadAllNotification')->middleware('auth:api');
Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});