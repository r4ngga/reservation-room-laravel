<?php

namespace App\Http\Controllers\User;

use App\Room;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::where('status', 'free')->get();
        return view('room.index', ['rooms' => $rooms]);

        // json_encode($rooms);
    }

    public function fetchShowRoom(Request $request)
    {
        $rooms = Room::where('status', 'free')->get();
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
