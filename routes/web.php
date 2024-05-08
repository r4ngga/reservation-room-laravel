<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use App\Http\Controllers\Auth as Authentication; // because conflict with Illuminate\Support\Facades\Auth

use App\Http\Controllers\Admin\UserController;
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

Route::get('/', [Authentication\AuthController::class, 'index']);
// Route::get('/login', [Authentication\AuthController::class, 'loginpage']);
Route::get('/login', [Authentication\AuthController::class, 'loginpage'])->name('login');
// Route::post('/login', [Authentication\AuthController::class, 'login']);
Route::post('/login', [Authentication\AuthController::class, 'login'])->name('login-act');

Route::get('/forgot-password', [Authentication\AuthController::class, 'forgotPassword'])->name('forgot-password');

// Route::get('/register', [Authentication\AuthController::class, 'register']);
Route::get('/register', [Authentication\AuthController::class, 'register'])->name('register');
Route::post('/register', [Authentication\AuthController::class, 'store'])->name('regist');

Route::post('validation-phone-number', [Authentication\AuthController::class, 'validationPhoneNumber'])->name('validation-phone'); //checking email phone number
Route::post('validation-email', [Authentication\AuthController::class, 'validationEmail'])->name('validation-email'); //checking email

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [Authentication\AuthController::class, 'logout'])->middleware('auth');
    Route::get('/myaccount', [Authentication\AuthController::class, 'myaccount'])->middleware('auth');
    Route::get('/setting', [Authentication\AuthController::class, 'settingaccount'])->middleware('auth');
    Route::post('/setting', [Authentication\AuthController::class, 'updatesettingacc'])->middleware('auth');
    Route::get('/changepassword', [Authentication\AuthController::class, 'changepassword'])->middleware('auth');
    Route::post('/changepassword', [Authentication\AuthController::class, 'updatechangepassword'])->middleware('auth');
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('admin-dashboard', [Admin\AdminController::class, 'admindashboard'])->name('admin');
        Route::get('count-rooms', [Admin\AdminController::class, 'countRoom'])->name('count-rooms');
        Route::get('count-users', [Admin\AdminController::class, 'countUser'])->name('count-users');
        Route::get('count-reservations', [Admin\AdminController::class, 'countReservation'])->name('count-reservations');
        Route::get('room', [Admin\RoomController::class, 'show_all'])->name('room');
        // Route::get('fetchroom', [Admin\RoomController::class, 'fetchRoom'])->name('fetchroom');
        Route::get('/rooms/addroom', [Admin\RoomController::class, 'insert']);
        Route::get('rooms/{id}', [Admin\RoomController::class, 'fetchDetailRoom'])->name('rooms.show');
        Route::post('/rooms', [Admin\RoomController::class, 'store']);
        //Route::post('/rooms', [Admin\RoomController::class, 'store'])->name('room.store');
        Route::get('fetchedit/{id}', [Admin\RoomController::class, 'fetchEditRoom'])->name('room.fetchedit');
        // Route::get('/change/{id}', [Admin\RoomController::class, 'edit']);
        Route::get('/change/{room}', [Admin\RoomController::class, 'edit'])->name('room.edit');
        // Route::patch('/rooms/{id}', [Admin\RoomController::class, 'update']);
        Route::post('rooms/update/{id}', [Admin\RoomController::class, 'update'])->name('room.update');
        //Route::get('fetchroom/{id}', [Admin\RoomController::class, 'fetchEditRoom'])->name('room.fetchedit');
        Route::delete('/rooms/{room}', [Admin\RoomController::class, 'destroy']);
        //Route::delete('/rooms/{room}', [Admin\RoomController::class, 'destroy'])->name('room.destroy');

        Route::get('reservation', [Admin\ReservationController::class, 'confirmationbooking'])->name('reservation');
        Route::post('/confirmpaymentroom', [Admin\ReservationController::class, 'confirmpaymentreservation']);
        //Route::post('/confirmpaymentroom', [Admin\ReservationController::class, 'confirmpaymentreservation'])->name('confirmation-reservation');
        Route::get('users', [Admin\UserController::class, 'index'])->name('users');
        Route::get('users/{id}', [Admin\UserController::class, 'fetchDetailUser'])->name('users.show');

        Route::post('users/update/{id}', [Admin\UserController::class, 'update'])->name('users.update');
        //Route::post('users/delete/{id}', [Admin\UserController::class, 'delete'])->name('users.delete');

        Route::get('logs', [Admin\LogController::class, 'index'])->name('logs');
        Route::get('fetchlogs/{id}', [Admin\LogController::class, 'fetchDetail'])->name('logs.fetchlog');

        Route::get('religions', [Admin\ReligionController::class, 'index'])->name('religions');
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        // Route::get('/userdashboard', [User\ReservationController::class, 'reservationlist']);
        // Route::get('client-dashboard', [User\ReservationController::class, 'reservationlist'])->name('client');
        Route::get('client-dashboard', [User\UserDashboardController::class, 'index'])->name('client');
        Route::get('count-room', [User\UserDashboardController::class, 'countRooms'])->name('count-room');
        Route::get('count-reservation', [User\UserDashboardController::class, 'countReservations'])->name('count-reservation');
        Route::get('count-unpaid', [User\UserDashboardController::class, 'countUnpaid'])->name('count-unpaid');
        Route::get('/userdashboard/{reservation}', [User\ReservationController::class, 'paidreservation']);
        //Route::get('client-dashboard/{reservation}', [User\ReservationController::class, 'paidreservation'])->name('paidreservation');
        Route::post('/paymentroom', [ReservationController::class, 'paymentreservation']);

        // Route::get('/roomsdashboard', [ReservationController::class, 'index']);
        Route::get('rooms', [User\ReservationController::class, 'index'])->name('rooms');
        Route::post('/roomsdashboard', [ReservationController::class, 'filter']);
        //Route::post('filter', [User\ReservationController::class, 'filter'])->name('filter');  ///untuk filter ruangan
        Route::get('/bookingrooms/{id}', [ReservationController::class, 'reservation']);
        //Route::get('booking-rooms/{id}'[User\ReservationController::class, 'reservation'])->name('');
        Route::post('/bookingrooms', [ReservationController::class, 'booking']);
        //Route::post('booking-rooms', [User\ReservationController::class, 'booking'])->name('bookingroom');

        //Route::get('log', [User\ReservationController::class, 'log'])->name('log');
        Route::get('history', [User\ReservationController::class, 'loghistory'])->name('history');
    });
});
