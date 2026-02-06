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
        
        $paidReservations = Reservation::where('status_payment', '!=', '0')->where('status_payment', '!=', 'unpaid')->count();
        $unpaidReservations = Reservation::where('status_payment', '0')->orWhere('status_payment', 'unpaid')->count();
        
        $recentReservations = Reservation::join('users', 'reservations.user_id', '=', 'users.id_user')
                                        ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
                                        ->select('reservations.*', 'users.name', 'rooms.number_room', 'rooms.class')
                                        ->orderBy('reservations.created_at', 'desc')
                                        ->limit(5)
                                        ->get();

        return view('admin.dashboard', compact('rooms', 'reservations', 'users', 'userCount', 'paidReservations', 'unpaidReservations', 'recentReservations'));
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
