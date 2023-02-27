<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
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

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'loginpage']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [UserController::class, 'store']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/myaccount', [AuthController::class, '@myaccount'])->middleware('auth');
    Route::get('/setting', [AuthController::class, 'settingaccount'])->middleware('auth');
    Route::post('/setting', [AuthController::class, 'updatesettingacc'])->middleware('auth');
    Route::get('/changepassword', [AuthController::class, 'changepassword'])->middleware('auth');
    Route::post('/changepassword', [AuthController::class, 'updatechangepassword'])->middleware('auth');
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::get('/admindashboard', [AdminController::class, 'admindashboard']);
        Route::get('/rooms', [RoomController::class, 'show_all']);
        Route::get('/rooms/addroom', [RoomController::class, 'insert']);
        Route::post('/rooms', [RoomController::class, 'store']);
        Route::get('/change/{room}', [RoomController::class, 'edit']);
        Route::patch('/rooms/{room}', [RoomController::class, 'update']);
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy']);

        Route::get('/reservation', [ReservationController::class, 'confirmationbooking']);
        Route::post('/confirmpaymentroom', [ReservationController::class, 'confirmpaymentreservation']);
        Route::get('/users', [UserController::class, 'show_all_user']);
    });

    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::get('/userdashboard', [ReservationController::class, 'reservationlist']);
        Route::get('/userdashboard/{reservation}', [ReservationController::class, 'paidreservation']);
        Route::post('/paymentroom', [ReservationController::class, 'paymentreservation']);

        Route::get('/roomsdashboard', [ReservationController::class, 'index']);
        Route::post('/roomsdashboard', [ReservationController::class, 'filter']);
        Route::get('/bookingrooms/{room}', [ReservationController::class, 'reservation']);
        Route::post('/bookingrooms', [ReservationController::class, 'booking']);

        Route::get('/history', [ReservationController::class, 'loghistory']);
    });
});
