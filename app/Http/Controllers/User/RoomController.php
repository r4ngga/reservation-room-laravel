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
        json_encode($rooms);
    }

    public function fetchFilterRoom(Request $request)
    {
        $filter = $request->filter;
        $filter_room = Room::where('status', $request->filter)
                        ->orwhere('capacity', $filter)
                        ->orwhere('price', $filter)
                        ->orwhere('class')->get();

        json_encode($filter_room);
    }

    // public function store(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'facility' => 'required',
    //         'class' => 'required|in:Vip,Premium,Reguler',
    //         'capacity' => 'required|numeric',
    //         'price' => 'required|numeric',
    //         'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
    //     ]);
    //     $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
    //     $request->image_room->move(public_path('images'), $imgName);
    //     Room::create([
    //         'facility' => $request->facility,
    //         'class' => $request->class,
    //         'capacity' => $request->capacity,
    //         'price' => $request->price,
    //         'image_room' => $imgName,
    //     ]);
    //     return redirect('/rooms')->with('notify', 'Congratulations, success add a new room !');
    // }

    // public function update(Request $request, Room $room)
    // {
    //     $request->validate([
    //         'facility' => 'required',
    //         'class' => 'required|in:Vip,Premium,Reguler',
    //         'capacity' => 'required|numeric',
    //         'price' => 'required|numeric',
    //         'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
    //     ]);
    //     $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
    //     $request->image_room->move(public_path('images'), $imgName);
    //     Room::where('number_room', $room->number_room)->update([
    //         'facility' => $request->facility,
    //         'class' => $request->class,
    //         'capacity' => $request->capacity,
    //         'price' => $request->price,
    //         'image_room' => $imgName,
    //     ]);
    //     return redirect('/rooms')->with('notify', 'Success save changes update room data');
    // }

    // public function destroy(Room $room)
    // {
    //     Room::destroy($room->number_room);
    //     return redirect('/rooms')->with('notify', 'Data a Room successfully delete !');
    // }
}
