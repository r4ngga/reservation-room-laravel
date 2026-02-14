<?php

namespace App\Http\Controllers\Admin;

use App\Room;
use App\Log;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(10);
        // return view('room.index', compact('rooms'));
        return view('admin.room.index', compact('rooms'));
    }

    public function insert()
    {
        //return view('room.add_room');

        return view('admin.room.add_room');
    }

    public function fetchRoom()
    {
        $rooms = Room::where('status', 0)
                    ->orWhere('status', '0')->get(); //0 free, 1 full, 2 booked
        // json_encode($room);
        $status = ['free', 'full', 'booking'];
        $class_type = ['', 'Vip', 'Premium', 'Reguler'];
        foreach($rooms as $room){
            $html = '<tr>';
            $html .= '<td scope="row">'. $room->number_room ?? '' .'</td>';
            $html .= '<td>'. $class_type[$room->class] ?? '' .'</td>';
            $html .= '<td>'. $room->capacity ?? '' .'</td>';
            $html .= '<td>'. $status[$room->status] ?? '' .'</td>';
            $html .= '<td>';
            $html .= '<a href="#" onclick="fetchShowRoom('.$room->number_room.')" data-toggle="modal" data-target="#ShowDetailRoom" class="btn btn-success">Detail</a>';
            $html .= '<a href="#" onclick="fetchEdit(`'.$room->number_room.'`)" data-toggle="modal" data-target="#editRoom" class="btn btn-info">Change</a>';
            $html .= '<a href="#" onclick="deleteRoom('.$room->number_room.')" data-toggle="modal" data-target="#DeleteRoom" class="btn btn-danger">Delete</a>';
            $html .= ' </td>';
            $html .= '</tr>';
        }

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

        $status = ['Free', 'Full', 'Booking'];
        $class_type = ['','Vip', 'Premium', 'Reguler'];
        return response()->json(
            array(
                'number_room' => $getRoom->number_room,
                'facility' => $getRoom->facility,
                'class' => $class_type[$getRoom->class],
                'capacity' => $getRoom->capacity,
                'price' => $getRoom->price,
                'status' => $status[$getRoom->status],
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
        $rooms = Room::paginate(10);
        // return view('room.index', ['rooms' => $room]);
        return view('admin.room.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        // dd($request->all());

        $request->validate([
            'facility' => 'required',
            'class' => 'required|in:1,2,3',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
            // 'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $imgName = '';
        if($request->image_room){
            $imgName = $request->image_room->getClientOriginalName() . '-' . time() . '.' . $request->image_room->extension();
            $request->image_room->move(public_path('images'), $imgName);
        }

        // dd($imgName);

        $room = new Room();
        $room->number_room = $request->number_room;
        $room->facility = $request->facility;
        $room->class = $request->class;
        $room->capacity = $request->capacity;
        $room->price = $request->price;
        $room->image_room = !empty($request->image_room) ? $imgName : null;
        $room->save();

        $last_room = Room::find($room->id);
        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'POST';
        $logs->description = 'add a new room';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($last_room);
        $logs->save();

        return redirect()->back()->with('notify', 'Congratulations, success add a new room !');
    }

    public function edit(Room $room)
    {
        return view('admin.room.change_room', compact('room'));
    }

    public function update(Request $request, $id)
    {
        try {
            $auth = Auth::user();
            $now = Carbon::now();

            $request->validate([
                'facility' => 'required',
                'class' => 'required|in:1,2,3',
                'capacity' => 'required|numeric',
                'price' => 'required|numeric',
                // 'image_room' => 'mimes:jpeg,png,jpg,gif,svg',
            ]);

            $room = Room::findOrFail($id);
            $old_room = clone $room;
            
            if ($request->hasFile('image_room')) {
                $file = $request->file('image_room');
                $imgName = $file->getClientOriginalName() . '-' . time() . '.' . $file->extension();
                $file->move(public_path('images'), $imgName);

                if ($room->image_room) {
                    $oldImagePath = public_path('images/' . $room->image_room);
                    if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $room->image_room = $imgName;
            }

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
            $room->save();

            //createa a logs
            $logs = new Log();
            $logs->user_id = $auth->id_user;
            $logs->action = 'PUT';
            $logs->description = 'change & update data room';
            $logs->role =  $auth->role;
            $logs->log_time = $now;
            $logs->data_old = json_encode($old_room);
            $logs->data_new = json_encode($room);
            $logs->save();

            return response()->json(['notify' => 'success', 'data' => 'Success save changes update room data ! ']);
        } catch (\Exception $e) {
            return response()->json(['notify' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Room $room)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $find = Room::where('number_room', $room->number_room)->first();
        if(!$find)
        {
            return redirect('/rooms')->with('notify', 'Failed delete data room !');
        }
        $delroom = Room::where('number_room', $room->number_room)->first();
        if($delroom->image_room){
            $img = '/images/'.$delroom->image_room;
            $path = public_path($img);
            if(file_exists($path)) {
                unlink($path);
            }
        }
        $room->delete();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->role = $auth->role;
        $logs->description = 'delete data room';
        $logs->action = 'delete';
        $logs->log_time = $now;
        $logs->data_old = json_encode($find);
        $logs->data_new = '-';
        $logs->save();
        //create a logs

        return redirect('/rooms')->with('notify', 'Data a Room successfully delete !');
    }
}
