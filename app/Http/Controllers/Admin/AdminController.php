<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Room;
use App\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admindashboard()
    {
        $reservations = Reservation::count();
        $rooms = Room::count();
        $users = User::count();
        // return view('admin.dashboard', ['users' => $users, 'rooms' => $rooms, 'reservations' => $reservations]);
        return view('admin.dashboard', compact('rooms', 'reservations', 'users'));
    }
}
