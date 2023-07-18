<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Controller\User;
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

// Route::get('/register', [Authentication\AuthController::class, 'register']);
Route::get('/register', [Authentication\AuthController::class, 'register'])->name('register');
// Route::post('/register', [UserController::class, 'store']);
Route::post('/register', [Authentication\AuthController::class, 'store']);
//Route::post('/register', [Authentication\AuthController::class, 'store']);->name('regist')

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [Authentication\AuthController::class, 'logout'])->middleware('auth');
    Route::get('/myaccount', [Authentication\AuthController::class, 'myaccount'])->middleware('auth');
    Route::get('/setting', [Authentication\AuthController::class, 'settingaccount'])->middleware('auth');
    Route::post('/setting', [Authentication\AuthController::class, 'updatesettingacc'])->middleware('auth');
    Route::get('/changepassword', [Authentication\AuthController::class, 'changepassword'])->middleware('auth');
    Route::post('/changepassword', [Authentication\AuthController::class, 'updatechangepassword'])->middleware('auth');
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/admindashboard', [Admin\AdminController::class, 'admindashboard']);
        //Route::get('/admindashboard', [Admin\AdminController::class, 'admindashboard'])->name('admin');
        Route::get('/rooms', [Admin\RoomController::class, 'show_all']);
        //Route::get('/rooms', [Admin\RoomController::class, 'show_all'])->name('room');
        Route::get('/rooms/addroom', [Admin\RoomController::class, 'insert']);
        Route::post('/rooms', [Admin\RoomController::class, 'store']);
        //Route::post('/rooms', [Admin\RoomController::class, 'store'])->name('room.store');
        Route::get('/change/{room}', [Admin\RoomController::class, 'edit']);
        Route::patch('/rooms/{room}', [Admin\RoomController::class, 'update']);
        Route::delete('/rooms/{room}', [Admin\RoomController::class, 'destroy']);

        Route::get('/reservation', [Admin\ReservationController::class, 'confirmationbooking']);
        Route::post('/confirmpaymentroom', [Admin\ReservationController::class, 'confirmpaymentreservation']);
        Route::get('/users', [Admin\UserController::class, 'show_all_user']);
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/userdashboard', [ReservationController::class, 'reservationlist']);
        //Route::get('/userdashboard', [ReservationController::class, 'reservationlist'])->name('user');
        Route::get('/userdashboard/{reservation}', [ReservationController::class, 'paidreservation']);
        Route::post('/paymentroom', [ReservationController::class, 'paymentreservation']);

        Route::get('/roomsdashboard', [ReservationController::class, 'index']);
        Route::post('/roomsdashboard', [ReservationController::class, 'filter']);
        Route::get('/bookingrooms/{id}', [ReservationController::class, 'reservation']);
        Route::post('/bookingrooms', [ReservationController::class, 'booking']);

        Route::get('/history', [ReservationController::class, 'loghistory']);
    });
});
