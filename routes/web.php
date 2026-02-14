<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ReligionController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ReservationController as UserReservationController;
use App\Http\Controllers\User\RoomController as UserRoomController;

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

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'loginpage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-act');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('regist');

Route::post('validation-phone-number', [AuthController::class, 'validationPhoneNumber'])->name('validation-phone');
Route::post('validation-email', [AuthController::class, 'validationEmail'])->name('validation-email');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/myaccount', [AuthController::class, 'myaccount'])->name('myaccount');
    Route::get('/setting', [AuthController::class, 'settingaccount'])->name('setting');
    Route::post('/setting', [AuthController::class, 'updatesettingacc']);
    Route::get('/changepassword', [AuthController::class, 'changepassword']);
    Route::post('/changepassword', [AuthController::class, 'updatechangepassword']);

    // Admin Routes
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin-dashboard', [AdminController::class, 'admindashboard'])->name('admin');
        Route::get('count-rooms', [AdminController::class, 'countRoom'])->name('count-rooms');
        Route::get('count-users', [AdminController::class, 'countUser'])->name('count-users');
        Route::get('count-reservations', [AdminController::class, 'countReservation'])->name('count-reservations');

        // Room Routes (Admin)
        Route::get('room', [AdminRoomController::class, 'show_all'])->name('room');
        Route::get('rooms/addroom', [AdminRoomController::class, 'insert'])->name('rooms.add');
        Route::post('rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
        Route::get('rooms/{id}', [AdminRoomController::class, 'fetchDetailRoom'])->name('rooms.show');
        Route::get('fetchroom', [AdminRoomController::class, 'fetchRoom'])->name('room.fetch-index');
        Route::get('fetchedit/{id}', [AdminRoomController::class, 'fetchEditRoom'])->name('room.fetchedit');
        Route::get('/change/{room}', [AdminRoomController::class, 'edit'])->name('room.edit');
        Route::put('rooms/update/{id}', [AdminRoomController::class, 'update'])->name('room.update');
        Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('room.delete');

        // Reservation Routes (Admin)
        Route::get('reservation', [AdminReservationController::class, 'confirmationbooking'])->name('reservation');
        Route::post('/confirmpaymentroom', [AdminReservationController::class, 'confirmpaymentreservation']);

        // User Routes (Admin)
        Route::get('users', [AdminUserController::class, 'index'])->name('users');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('fetchuser', [AdminUserController::class, 'fetchIndex'])->name('users.fetch-index');
        Route::get('fetchedit-user/{id}', [AdminUserController::class, 'fetchEditUser'])->name('users.fetchedit');
        Route::get('users/{id}', [AdminUserController::class, 'fetchDetailUser'])->name('users.show');
        Route::post('users/update/{id}', [AdminUserController::class, 'update'])->name('users.update');

        // Log Routes
        Route::get('logs', [LogController::class, 'index'])->name('logs');
        Route::get('fetchlogs/{id}', [LogController::class, 'fetchDetail'])->name('logs.fetchlog');

        // Religion Routes
        Route::get('religions', [ReligionController::class, 'index'])->name('religions');
        Route::get('religions/fetch', [ReligionController::class, 'fetchIndex'])->name('religions.fetch');
        Route::get('religions/{id}', [ReligionController::class, 'fetchDetail'])->name('religions.show');
        Route::get('religions-edit/{id}', [ReligionController::class, 'fetchEdit'])->name('religions.edit');
        Route::post('religions', [ReligionController::class, 'store'])->name('religions.store');
        Route::post('religions/update/{id}', [ReligionController::class, 'update'])->name('religions.update');
        Route::delete('religions/{id}', [ReligionController::class, 'delete'])->name('religions.delete');

        // Promotion Routes
        Route::get('promotions', [PromotionController::class, 'index'])->name('promotions');
        Route::get('promotions/{id}', [PromotionController::class, 'show'])->name('promotions.show');
        Route::get('promotionsfetch', [PromotionController::class, 'fetchIndex'])->name('promotions.fetch-index');
        Route::post('promotions-add', [PromotionController::class, 'add'])->name('promotions.add');
        Route::post('promotions-update/{id}', [PromotionController::class, 'update'])->name('promotions.update');
        Route::delete('promotions-delete/{id}', [PromotionController::class, 'delete'])->name('promotions.delete');

        // Event Routes
        Route::get('events', [EventController::class, 'index'])->name('events');
        Route::get('events/{id}', [EventController::class, 'show'])->name('events.show');
        Route::post('events-add', [EventController::class, 'add'])->name('events.add');
    });

    // User Routes
    Route::group(['middleware' => ['role:user']], function () {
        Route::get('client-dashboard', [UserDashboardController::class, 'index'])->name('client');
        Route::get('count-room', [UserDashboardController::class, 'countRooms'])->name('count-room');
        Route::get('count-reservation', [UserDashboardController::class, 'countReservations'])->name('count-reservation');
        Route::get('count-unpaid', [UserDashboardController::class, 'countUnpaid'])->name('count-unpaid');

        Route::get('/userdashboard', [UserReservationController::class, 'paidreservation']);
        Route::get('client-dashboard/{id}', [UserReservationController::class, 'paidreservation'])->name('paidreservation');
        Route::post('/paymentroom', [UserReservationController::class, 'paymentreservation']);

        Route::get('rooms', [UserReservationController::class, 'index'])->name('rooms');
        Route::post('/roomsdashboard', [UserReservationController::class, 'filter']);
        Route::get('/bookingrooms/{id}', [UserReservationController::class, 'reservation']);
        Route::post('/bookingrooms', [UserReservationController::class, 'booking']);

        Route::get('history', [UserReservationController::class, 'loghistory'])->name('history');
    });
});
