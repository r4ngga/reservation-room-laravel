<?php

namespace App\Http\Controllers\Api;

use App\Reservation;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReservationApiController extends Controller
{

    public function getAllReservation()
    {
        $reservations = Reservation::all();

        $countrsvt = $reservations->count();

        if($countrsvt > 0){
            foreach($reservations as $rst){
                $reservation = array(
                    'number_reservation' => $rst->number_reservation,
                    'code_reservation' => $rst->code_reservation,
                    'user_id' => $rst->user_id,
                    'room_id' => $rst->room_id,
                    'time_booking' => $rst->time_booking,
                    'payment' => $rst->payment,
                    'status_payment' => $rst->status_payment,
                    'time_spend' => $rst->time_spend,
                    'photo_transfer' => $rst->photo_transfer,
                );

                $data = array(
                    'status' => true,
                    'code' => 200,
                    'message' => 'success get all reservation data',
                    'counts' => $countrsvt,
                    'data' => $reservation,
                );
            }
        }else{

        }

        return response()->json($data);
    }

}
