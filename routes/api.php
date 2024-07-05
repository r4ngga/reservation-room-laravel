<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function(){
    //logs
    Route::get('logs', 'LogApiController@getLogs');
    Route::get('logs/{id}', 'LogApiController@getFetchLogs');
    Route::get('logs-by-role', 'LogApiController@FetchLogsByRole');

    //rooms
    Route::get('rooms', 'RoomApiController@getAllRooms');
    //Route::get('rooms-free', 'RoomApiController@getFreeRoom');
    //Route::get('rooms-booked', 'RoomApiController@getBookedRoom');

    //users
    Route::get('users', 'UserApiController@getAllUsers');
    Route::get('users/{id}', 'UserApiController@getFetchUsers');
    Route::get('users-gender', 'UserApiController@fetchUsersByGender');

    //religions
    Route::get('religions', 'ReligionApiController@index');
});

// Route::get('logs', 'LogApiController@getLogs');
