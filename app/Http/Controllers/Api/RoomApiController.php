<?php

namespace App\Http\Controllers\Api;

use App\Room;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    public function getAllRooms()
    {
        $rooms = Room::orderBy('created_at', 'desc')->get();
        $countrooms = count($rooms);

        $room = array();

        foreach($rooms as $rm){
            $room[] = array(
                'number_room' => $rm->number_room,
                'status' => $rm->status,
                'facility' => $rm->facility,
                'class' => $rm->class,
                'capacity' => $rm->capacity,
                'price' => $rm->status,
                'image_room' => $rm->image_room,
                'created_at' => $rm->created_at,
            );
        }

        if($countrooms > 0 ){
            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_rooms' => $countrooms,
                'data' => $room,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'rooms not found',
                'count_rooms' => 0,
            );
        }

        return response()->json($data);
    }

    public function getFetchRoom($id)
    {
        $room = Room::findOrfail($id);
        $rooms = Room::where('number_room', $id)->first()->get();
        $countrm = count($rooms);

        foreach( $rooms as $rm){
            $data [] = array(
                'number_room'=> $rm->number_room,
                'status' => $rm->status,
                'facility' => $rm->facility,
                'class' => $rm->class,
                'capacity' => $rm->capacity,
                'price' => $rm->price,
                'image_room' => $rm->image_room,
                'created_at' => $rm->created_at,
            );
        }

        if($countrm > 0)
        {
            $data_room = array(
                'status' => 200,
                'message' => 'success',
                'count_rooms' => $countrm,
                'data' => $data,
            );
        }else{
            $data_room = array(
                'status' => 404,
                'message' => 'rooms not found',
                'count_rooms' => 0,
            );
        }


        return response()->json($data_room);
    }

    public function getFreeRoom(Request $request)
    {
        $rooms = Room::where('status', 'free')->get();

        $countroom = count($rooms);

        $room = array();

        foreach($rooms as $rm){
            $room[] = array(
                'number_room' => $rm->number_room,
                'status' => $rm->status,
                'facility' => $rm->facility,
                'class' => $rm->class,
                'capacity' => $rm->capacity,
                'price' => $rm->status,
                'image_room' => $rm->image_room,
                'created_at' => $rm->created_at,
            );
        }

        if($rooms > 0)
        {
            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_rooms' => $countroom,
                'data' => $room,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'rooms not found',
                'count_rooms' => 0,
            );
        }

        return response()->json($data);
    }

    public function getBookedRoom(Request $request)
    {
        $rooms = Room::where('status', 'full')->get();

        $countrooms = count($rooms);

        foreach($rooms as $rm){
            $room[] = array(
                'number_room' => $rm->number_room,
                'status' => $rm->status,
                'facility' => $rm->facility,
                'class' => $rm->class,
                'capacity' => $rm->capacity,
                'price' => $rm->status,
                'image_room' => $rm->image_room,
                'created_at' => $rm->created_at,
            );
        }

        if($rooms > 0){
            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_rooms' => $countrooms,
                'data' => $room,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'rooms not found',
                'count_rooms' => 0,
            );
        }

        return response()->json($data);
    }

}
