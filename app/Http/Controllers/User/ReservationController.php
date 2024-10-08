<?php

namespace App\Http\Controllers\User;

use App\Log;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        // return view('reservation.index', ['rooms' => $rooms]);
        return view('client.reservation.index', compact('rooms'));
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        if ($search == "cost_low_to_high") {
            $rooms = Room::orderBy('price', 'asc')->get();
            $information = "Price Low to High";
            return view('client.reservation.index', compact('rooms', 'information'));
        } else if ($search == "cost_high_to_low") {
            $rooms = Room::orderBy('price', 'desc')->get();
            $information = "Price Low to High";
            return view('client.reservation.index', compact('rooms', 'information'));
        } else if ($search == "free") {
            $rooms = Room::where('status', 0)->get();
            if (count($rooms) == 0) {
                $information = "All Room has been booked, or full";
            } else {
                $information = "Status Room Free";
            }
            return view('client.reservation.index', compact('rooms', 'information'));
        }
    }

    public function reservation($id)
    {
        $room = Room::findOrFaill($id);
        $random_string = $this->generateRandomString(10);
        $set_value = Str::random(7);
        $promotions = DB::table('promotions')
        ->where('status', 1)
        ->where('enable', 1)
        ->get();
        return view('client.reservation.booking', compact('room', 'set_value', 'random_string', 'promotions'));
    }

    public function booking(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'code_reservation' => 'required',
            'id_user' => 'required',
            'number_room' => 'required',
            'time_booking' => 'required',
            'payment' => 'required|numeric',
            'time_spend' => 'required|numeric',
        ]);

        $reservation_create = Reservation::create([
            'code_reservation' => $request->code_reservation,
            'user_id' => $request->id_user,
            'room_id' => $request->number_room,
            'time_booking' => $request->time_booking,
            'payment' => $request->payment,
            'time_spend' => $request->time_spend,
        ]);

        Room::where('number_room', $request->number_room)->update([
            'status' => 2,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'POST';
        $logs->description = 'add a new booking room';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($reservation_create);
        $logs->save();

        //return redirect('/roomsdashboard')->with('notify', 'Congratulation, you success booking a room');
        return redirect()->route('client-dashboard')->with('notify', 'Congratulation, you success booking a room');
    }

    public function reservationlist()
    {
        $user = Auth::user();

        $reservations = Reservation::join('users', 'reservations.user_id', '=', 'users.id_user')
            ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
            ->select('reservations.*', 'users.*', 'rooms.*')
            ->where('users.id_user', $user->id)
            ->where('reservations.status_payment', '=', 'unpaid')
            ->orderBy('reservations.number_reservation', 'desc')
            ->orderBy('reservations.status_payment', 'desc')
            ->get();

        return view('client.reservation.temporary_list', compact('reservations'));
    }

    public function paidreservation($id)
    {
        $user = Auth::user();
        $reservation = Reservation::join('users', 'reservations.user_id', '=', 'users.id_user')
        ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
        ->where('reservations.id', $id)
        ->select('reservations.id as id',
        'resevations.code_reservation as code',
        'reservations.user_id as user_id',
        'reservations.room_id as room_id',
        'reservations.time_booking as time_booking',
        'reservations.payment as payment',
        'reservations.status_payment as status_payment',
        'reservations.time_spend as time_spend',
        'reservations.photo_transfer as photo_transfer',
        'users.name as name',
        'users.email as email',
        'rooms.number_room as number_room',
        'rooms.facility as facility',
        'rooms.class as class_room',
        'rooms.capacity as capacity',
        'rooms.price as price',
        'rooms.status as status_room')
        ->orderBy('reservations.created_at', 'desc')
        ->get();
        return view('client.reservation.payment_room', compact('reservation'));
    }

    public function paymentreservation(Request $request) //for action confrmation payment by user
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'status_payment' => 'required',
            'number_room' => 'required',
            'number_reservation' => 'required',
            'photo_transfer' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $old_data_rsvt = Reservation::where('number_reservation', $request->number_reservation)->first();

        if($request->photo_transfer)
        {
            $imgName = $request->photo_transfer->getClientOriginalName() . '-' . time() . '.' . $request->photo_transfer->extension();
            $request->photo_transfer->move(public_path('images'), $imgName);
        }
        $check_img = isset($request->photo_transfer) ? $imgName : null;

        $rsvt = Reservation::where('number_reservation', $request->number_reservation)->update([
            'status_payment' => $request->status_payment,
            'photo_transfer' => $check_img,
        ]);
        Room::where('number_room', $request->number_room)->update([
            'status' => 1,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update confirmation payment reservation';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data_rsvt);
        $logs->data_new = json_encode($rsvt);
        $logs->save();
        //create a logs

        //return redirect('/userdashboard')->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
        return redirect()->route('client-dashboard')->with('notify', 'Congratulation your bill now paid off, let`s enjoy your holiday!!');
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
        return view('client.reservation.confirmationpayment', compact('reservations'));
    }

    public function loghistory()
    {
        $auth = Auth::user();

        $reservations = Reservation::join('users', 'reservations.user_id', '=', 'users.id_user')
                    ->join('rooms', 'reservations.room_id', '=', 'rooms.number_room')
                    ->select('reservations.*', 'users.*', 'rooms.*')
                    ->where('users.id_user', $auth)
                    ->orderBy('reservations.number_reservation', 'desc')
                    ->orderBy('reservations.status_payment', 'desc')
                    ->get();


        return view('client.reservation.history', compact('reservations'));
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
