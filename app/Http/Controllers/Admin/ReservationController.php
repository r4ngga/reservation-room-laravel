<?php

namespace App\Http\Controllers\Admin;

use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('reservation.index', ['rooms' => $rooms]);
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        if ($search == "cost_low_to_high") {
            $rooms = Room::query()->orderBy('price', 'asc')->get();
            $information = "Price Low to High";
            return view('reservation.index', ['rooms' => $rooms, 'information' => $information]);
        } else if ($search == "cost_high_to_low") {
            $rooms = Room::query()->orderBy('price', 'desc')->get();
            $information = "Price Low to High";
            return view('reservation.index', ['rooms' => $rooms, 'information' => $information]);
        } else if ($search == "free") {
            $rooms = Room::where('status', 'free')->get();
            if (count($rooms) == 0) {
                $information = "All Room has been booked, or full";
            } else {
                $information = "Status Room Free";
            }
            // $information = "Status Room Free";
            return view('reservation.index', ['rooms' => $rooms, 'information' => $information]);
        }
    }

    // public function reservation(Room $room)
    // {
    //     $set_value = Str::random(7);
    //     return view('reservation.booking', compact('room', 'set_value'));
    // }

    // public function booking(Request $request)
    // {
    //     $request->validate([
    //         'code_reservation' => 'required',
    //         'id_user' => 'required',
    //         'number_room' => 'required',
    //         'time_booking' => 'required',
    //         'payment' => 'required|numeric',
    //         'time_spend' => 'required|numeric',
    //     ]);
    //     Reservation::create([
    //         'code_reservation' => $request->code_reservation,
    //         'user_id' => $request->id_user,
    //         'room_id' => $request->number_room,
    //         'time_booking' => $request->time_booking,
    //         'payment' => $request->payment,
    //         'time_spend' => $request->time_spend,
    //     ]);

    //     Room::where('number_room', $request->number_room)->update([
    //         'status' => 'full',
    //     ]);

    //     return redirect('/roomsdashboard')->with('notify', 'Congratulation, you success booking a room');
    // }

    public function reservationlist()
    {
        $reservation = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id_user')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
            ->select('reservations.*', 'users.*', 'rooms.*')
            ->where('users.id_user', auth()->user()->id_user)
            ->where('reservations.status_payment', '=', 'unpaid')
            ->orderBy('reservations.number_reservation', 'desc')
            ->orderBy('reservations.status_payment', 'desc')
            ->get();

        return view('reservation.temporary_list', ['reservations' => $reservation]);
    }

    // public function paidreservation(Reservation $reservation)
    // {
    //     return view('reservation.payment_room', compact('reservation'));
    // }

    // public function paymentreservation(Request $request) //for action confrmation payment by user
    // {
    //     $request->validate([
    //         'status_payment' => 'required',
    //         'number_room' => 'required',
    //         'number_reservation' => 'required',
    //         'photo_transfer' => 'mimes:jpeg,png,jpg,gif,svg',
    //     ]);
    //     $imgName = $request->photo_transfer->getClientOriginalName() . '-' . time() . '.' . $request->photo_transfer->extension();
    //     $request->photo_transfer->move(public_path('images'), $imgName);
    //     Reservation::where('number_reservation', $request->number_reservation)->update([
    //         'status_payment' => $request->status_payment,
    //         'photo_transfer' => $imgName,
    //     ]);
    //     Room::where('number_room', $request->number_room)->update([
    //         'status' => 'full',
    //     ]);
    //     return redirect('/userdashboard')->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
    // }

    public function confirmpaymentreservation(Request $request) //for action confrmation payment by admin
    {
        $request->validate([
            'status_payment' => 'required',
            'number_room' => 'required',
            'number_reservation' => 'required',
        ]);
        Reservation::where('number_reservation', $request->number_reservation)->update([
            'status_payment' => $request->status_payment,
        ]);
        Room::where('number_room', $request->number_room)->update([
            'status' => 'full',
        ]);
        return redirect('/reservation')->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
    }

    public function confirmationbooking()
    {
        $reservation = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id_user')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
            ->select('reservations.*', 'users.*', 'rooms.*')
            ->orderBy('reservations.number_reservation', 'desc')
            // ->orderBy('reservations.status_payment', 'unpaid')
            ->get();
        return view('reservation.confirmationpayment', ['reservations' => $reservation]);
    }

    public function loghistory()
    {
        $auth = Auth::user();
        $reservation = DB::table('reservations')
            ->join('users', 'reservations.user_id', '=', 'users.id_user')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
            ->select('reservations.*', 'users.*', 'rooms.*')
            ->where('users.id_user', auth()->user()->id_user)
            ->orderBy('reservations.number_reservation', 'desc')
            ->orderBy('reservations.status_payment', 'desc')
            ->get();

        return view('reservation.history', ['reservations' => $reservation]);
    }
}
