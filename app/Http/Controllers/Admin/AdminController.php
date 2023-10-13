<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Room;
use App\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function admindashboard()
    {
        $reservations = Reservation::count();
        $rooms = Room::count();
        $users = User::where('role', 2)->get();
        $userCount = count($users);
        // return view('admin.dashboard', ['users' => $users, 'rooms' => $rooms, 'reservations' => $reservations]);
        return view('admin.dashboard', compact('rooms', 'reservations', 'users', 'userCount'));
    }

    public function countRoom()
    {
        $rooms = Room::all();

        $countroom = $rooms->count();

        return response()->json($countroom);
    }

    public function countUser()
    {
        $users = User::where('role', 2)->get();

        // $countuser = $users->count();
        $countuser = count($users);

        return response()->json($countuser);
    }

    public function countReservation()
    {
        $reservation = Reservation::count();

        return response()->json($reservation);
    }
}
