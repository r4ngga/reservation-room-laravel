<?php

namespace App\Http\Controllers\Admin;

use App\Room;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index()
    {
        // $rooms = Room::all();
        $rooms = Room::where('status', 'free')
                    ->orWhere('status', 'Free')->get();
        return view('room.index', compact('rooms'));
    }

    public function insert()
    {
        return view('room.add_room');
    }

    public function fetchRoom(Request $request)
    {
        $rooms = Room::where('status', 'free')
                    ->orWhere('status', 'Free')->get();
        // json_encode($rooms);
        $html = '<tr>';
        $html .= '<td scope="row">'. $rooms->number_room ?? '' .'</td>';
        $html .= '<td>'. $rooms->class ?? '' .'</td>';
        $html .= '<td>'. $rooms->capacity ?? '' .'</td>';
        $html .= '<td>'. $rooms->status ?? '' .'</td>';
        $html .= '<td>';
        $html .= '<a href="#" onclick="fetchShowRoom('.$rooms->number_room.')" data-toggle="modal" data-target="#ShowDetailRoom" class="btn btn-success">Detail</a>';
        $html .= '<a href="#" onclick="getEdtRoom('.$rooms->number_room.', '.$rooms->facility.', '.$rooms->class.', '.$rooms->capacity.', '.$rooms->price.', '.$rooms->status.')" data-toggle="modal" data-target="#editRoom" class="btn btn-info">Change</a>';
        $html .= '<a href="#" onclick="deleteRoom('.$rooms->number_room.')" data-toggle="modal" data-target="#DeleteRoom" class="btn btn-danger">Delete</a>';
        $html .= ' </td>';
        $html .= '</tr>';

        return response()->json(['html' => $html]);
        // return view('room.index', compact('rooms'));
    }

    public function fetchDetailRoom($id)
    {
        $getRoom = Room::where('number_room', $id)->first();

        $image = '';
        if($getRoom->image_room){
            $image =  '/images/'.$getRoom->image_room;
        }else{
            $image = '/images/default.jpeg';
        }
        // dd($getRoom);
        // return json_decode($getRoom, true);

        return response()->json(
            array(
                'number_room' => $getRoom->number_room,
                'facility' => $getRoom->facility,
                'class' => $getRoom->class,
                'capacity' => $getRoom->capacity,
                'price' => $getRoom->price,
                'status' => $getRoom->status,
                'image_room' => $image,
                'created_at' => $getRoom->created_at,
                'updated_at' => $getRoom->updated_at,
            )
        );
    }

    public function fetchEditRoom($id){
        // $room = Room::where('id', $id)->first();
        $room = Room::findOrFail($id);

        $imag = '';
        if($room->image_room){
            $imag = '/images/'.$room->image_room;
        }else{
            $imag = '/images/default.jpeg';
        }

        return response()->json( array(
            'number_room' => $room->number_room,
            'facility' => $room->facility,
            'class' => $room->class,
            'capacity' => $room->capacity,
            'price' => $room->price,
            'image_room' => $imag,
            'created_at' => $room->created_at,
            'updated_at' => $room->updated_at,
        ));
        //return json_encode($room);
    }

    public function show_all()
    {
        $rooms = Room::all();
        // return view('room.index', ['rooms' => $rooms]);
        return view('room.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'facility' => 'required',
            'class' => 'required|in:Vip,Premium,Reguler',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
            // 'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        if($request->image_room){
            $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
            $request->image_room->move(public_path('images'), $imgName);
        }

        dd($imgName);

        $room = new Room();
        $room->facility = $request->facility;
        $room->class = $request->class;
        $room->capacity = $request->capacity;
        $room->price = $request->price;
        $room->image_room = !empty($request->image_room) ? $imgName : null;
        $room->save();

        // Room::create([
        //     'facility' => $request->facility,
        //     'class' => $request->class,
        //     'capacity' => $request->capacity,
        //     'price' => $request->price,
        //     'image_room' => $imgName,
        // ]);

        //create a logs
        $logs = new Logs();
        $logs->user_id = $auth->user_id;
        $logs->action = 'POST';
        $logs->description = 'add a new room';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($room);
        $logs->save();

        return redirect('/rooms')->with('notify', 'Congratulations, success add a new room !');
    }

    public function edit(Room $room)
    {
        return view('room.change_room', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'facility' => 'required',
            'class' => 'required|in:Vip,Premium,Reguler',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
            // 'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $old_room = Room::where('number_room', $room->number_room)->first();
        $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
        $request->image_room->move(public_path('images'), $imgName);

        $oldImg = '';
        $room = Room::where('number_room', $room->number_room)->first();
        if($request->image_room){
            $oldImg = '/images/'.$room->image_room;
            // $oldImg = '/images/'.$book->image_book;
            unlink(public_path($oldImg));
        }
        dd($oldImg);

        // $room = Room::where('number_room', $id)->first();
        if(!empty($request->facility)){
            $room->facility = $request->facility;
        }
        if(!empty($request->class)){
            $room->class = $request->class;
        }
        if(!empty($request->capacity)){
            $room->capacity = $request->capacity;
        }
        if(!empty($request->price)){
            $room->price = $request->price;
        }
        $room->image_room = isset($request->image_room) ? $imgName : null;
        $room->save();

        //createa a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'PUT';
        $logs->description = 'change & update data room';
        $logs->role =  $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_room);
        $logs->data_new = json_encode($room);
        $logs->save();

        return redirect('/rooms')->with('notify', 'Success save changes update room data');
    }

    public function destroy(Room $room)
    {
        $delroom = Room::where('number_room', $room->number_room)->first();
        if($delroom->image_room){
            $img = '/images/'.$delroom->image_room;
            unlink(public_path($img));
        }
        Room::destroy($room->number_room);
        return redirect('/rooms')->with('notify', 'Data a Room successfully delete !');
    }
}
