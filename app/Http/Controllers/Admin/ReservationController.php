<?php

namespace App\Http\Controllers\Admin;

use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.reservation.index', ['rooms' => $rooms]);
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        if ($search == "cost_low_to_high") {
            $rooms = Room::orderBy('price', 'asc')->get();
            $information = "Price Low to High";
            return view('admin.reservation.index', compact('rooms', 'information'));
        } else if ($search == "cost_high_to_low") {
            $rooms = Room::orderBy('price', 'desc')->get();
            $information = "Price Low to High";
            return view('admin.reservation.index', compact('rooms', 'information'));
        } else if ($search == "free") {
            $rooms = Room::where('status', 0)->get();
            if (count($rooms) == 0) {
                $information = "All Room has been booked, or full";
            } else {
                $information = "Status Room Free";
            }
            // $information = "Status Room Free";
            return view('admin.reservation.index', compact('rooms', 'information'));
        }
    }

    public function confirmpaymentreservation(Request $request) //for action confrmation payment by admin
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'status_payment' => 'required',
            'number_room' => 'required',
            'number_reservation' => 'required',
        ]);

        $old_rsvt = Reservation::where('number_reservation', $request->number_reservation)->first();

        $new_resvt = Reservation::where('number_reservation', $request->number_reservation)->update([
            'status_payment' => $request->status_payment,
        ]);
        Room::where('number_room', $request->number_room)->update([
            'status' => 1,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'PUT';
        $logs->description = 'update confirmation payment reservation';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_rsvt);
        $logs->data_new = json_encode($new_resvt);
        $logs->save();

        return redirect('/reservation')->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
        //return  redirect()->back()->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
    }

    public function confirmationbooking()
    {
        $reservations = Reservation::join('users', 'reservations.user_id', '=', 'users.id_user')
                    ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
                    ->select('reservations.*', 'users.name', 'users.email', 'rooms.number_room', 'rooms.class') // Selecting specific columns to avoid conflicts if any, but name/email are important
                    ->orderBy('reservations.id', 'desc')
                    ->paginate(10);

        // return view('reservation.confirmationpayment', ['reservations' => $reservation]);
        return view('admin.reservation.confirmationpayment', compact('reservations'));
    }

    public function getImagePayment($id)
    {}

}
