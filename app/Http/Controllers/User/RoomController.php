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
        // return view('client.room.index', compact('rooms'));
        return response()->json($rooms);

    }

    public function fetchShowRoom(Request $request)
    {
        $rooms = Room::where('status', 0)->get();

        return response()->json($rooms);
    }

    public function fetchFilterRoom(Request $request)
    {
        $filter = $request->filter;
        $filter_room = Room::where('status', $request->filter)
                        ->orwhere('capacity', $filter)
                        ->orwhere('price', $filter)
                        ->orwhere('class')->get();

        return response()->json($filter_room);
    }

}
