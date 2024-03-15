<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Room;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    public function myaccount()
    {
        $getUser = User::auth();
        return view('myaccount', compact('getUser'));
    }

    public function countRooms()
    {
        $rooms = Room::where('status', 0)->get();
        $countrm = count($rooms);

        return response()->json(['countroom' => $countrm]);
    }

    public function countReservations()
    {
        $auth = Auth::user();
        $reservation = Reservation::where('user_id', $auth->id_user)
                       ->get();

        $countrsv = count($reservation);
        return response()->json(['countreservation' => $countrsv]);
    }

    public function countUnpaid()
    {
        $auth = Auth::user();
        $reservation_unpaid = Reservation::where('user_id', $auth->id_user)
        ->where('status_payment', 0)
        ->get();

        $countunpaid = count($reservation_unpaid);
        return response()->json(['countunpaid' => $countunpaid]);
    }

}
