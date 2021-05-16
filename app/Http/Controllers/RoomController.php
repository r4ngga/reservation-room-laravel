<?php

namespace App\Http\Controllers;

use App\Room;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class RoomController extends Controller
{
    public function index()
    {
    }

    public function insert()
    {
        return view('room.add_room');
    }

    public function show_all()
    {
        $rooms = Room::all();
        return view('room.index', ['rooms' => $rooms]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'facility' => 'required',
            'class' => 'required|in:Vip,Premium,Reguler',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
            'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
        $request->image_room->move(public_path('images'), $imgName);
        Room::create([
            'facility' => $request->facility,
            'class' => $request->class,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'image_room' => $imgName,
        ]);
        return redirect('/rooms')->with('notify', 'Congratulations, success add a new room !');
    }

    public function edit(Room $room)
    {
        return view('room.change_room', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'facility' => 'required',
            'class' => 'required|in:Vip,Premium,Reguler',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
            'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
        $request->image_room->move(public_path('images'), $imgName);
        Room::where('number_room', $room->number_room)->update([
            'facility' => $request->facility,
            'class' => $request->class,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'image_room' => $imgName,
        ]);
        return redirect('/rooms')->with('notify', 'Success save changes update room data');
    }

    public function destroy(Room $room)
    {
        Room::destroy($room->number_room);
        return redirect('/rooms')->with('notify', 'Data a Room successfully delete !');
    }
}
