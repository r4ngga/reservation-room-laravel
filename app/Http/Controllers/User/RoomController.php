<?php

namespace App\Http\Controllers\User;

use App\Room;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::where('status', 0)->get();
        return view('room.index', compact('rooms'));

        // json_encode($rooms);
    }

    public function fetchShowRoom(Request $request)
    {
        $rooms = Room::where('status', 0)->get();
        // json_decode($rooms, true);

        return response()->json($rooms);
    }

    public function fetchFilterRoom(Request $request)
    {
        $filter = $request->filter;
        $filter_room = Room::where('status', $request->filter)
                        ->orwhere('capacity', $filter)
                        ->orwhere('price', $filter)
                        ->orwhere('class')->get();

        // json_encode($filter_room);

        return response()->json($filter_room);
    }

}
