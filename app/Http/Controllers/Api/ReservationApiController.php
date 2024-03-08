<?php

namespace App\Http\Controllers\Api;

use App\Reservation;
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
            $data = array(
                'status' => false,
                'code' => 404,
                'message' => 'failed, not found data reservation',
                'counts' => 0,
            );
        }

        return response()->json($data);
    }

    public function fetchDetailReservation($number_reservation)
    {
        $reservation = Reservation::where('number_reservation', $number_reservation)->first();

        $countrsvt = count($reservation);

        if($countrsvt > 0){

            foreach($reservation as $rst ){
                $reservaton = array(
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
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success get detail reservation',
                'counts' => $countrsvt,
                'data' => $reservaton,
            );
        }else{
            $data = array(
                'status' => false,
                'code' => 404,
                'message' => 'failed get detail reservation',
                'counts' => 0,
            );
        }

        return response()->json($data);

    }

    public function fetchStatusReservation(Request $request)
    {
        $status_payment = $request->status;

        $reservt = Reservation::where('status_payment', $status_payment)->first();

        $countrsvt = count($reservt);

        if($countrsvt > 0 ){
            foreach($reservt as $rst){
                $reservation = array(
                    'number_reservation' => $rst->number_reservation,
                    'code_reservation' => $rst->code_reservation,
                    'user_id' => $rst->user_id,
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success get status by reservation',
                'counts' => $countrsvt,
                'data' => $reservation,
            );
        }

        return response()->json($data);
    }

}
