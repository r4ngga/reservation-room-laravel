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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AuthController@index');
Route::get('/login', 'AuthController@loginpage');
Route::post('/login', 'AuthController@login');

Route::get('/register', 'AuthController@register');
Route::post('/register', 'UserController@store');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', 'AuthController@logout')->middleware('auth');
    Route::get('/myaccount', 'AuthController@myaccount')->middleware('auth');
    Route::get('/setting', 'AuthController@settingaccount')->middleware('auth');
    Route::post('/setting', 'AuthController@updatesettingacc')->middleware('auth');
    Route::get('/changepassword', 'AuthController@changepassword')->middleware('auth');
    Route::post('/changepassword', 'AuthController@updatechangepassword')->middleware('auth');
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::get('/admindashboard', 'AdminController@admindashboard');
        Route::get('/rooms', 'RoomController@show_all');
        Route::get('/rooms/addroom', 'RoomController@insert');
        Route::post('/rooms', 'RoomController@store');
        Route::get('/change/{room}', 'RoomController@edit');
        Route::patch('/rooms/{room}', 'RoomController@update');
        Route::delete('/rooms/{room}', 'RoomController@destroy');

        Route::get('/reservation', 'ReservationController@confirmationbooking');
        Route::post('/confirmpaymentroom', 'ReservationController@confirmpaymentreservation');
        Route::get('/users', 'UserController@show_all_user');
    });

    Route::group(['middleware' => ['cek_login:user']], function () {
        Route::get('/userdashboard', 'ReservationController@reservationlist');
        Route::get('/userdashboard/{reservation}', 'ReservationController@paidreservation');
        Route::post('/paymentroom', 'ReservationController@paymentreservation');

        Route::get('/roomsdashboard', 'ReservationController@index');
        Route::get('/bookingrooms/{room}', 'ReservationController@reservation');
        Route::post('/bookingrooms', 'ReservationController@booking');

        Route::get('/history', 'ReservationController@loghistory');
    });
});
