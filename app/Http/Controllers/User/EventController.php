<?php

namespace App\Http\Controllers\User;

use App\Event;
use App\Log;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display all available events for users
     */
    public function index()
    {
        $events = Event::where('status', 1)
            ->where('enable', 1)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.event.index', compact('events'));
    }

    /**
     * Show event booking page
     */
    public function booking($id)
    {
        $event = Event::findOrFail($id);
        $random_string = $this->generateRandomString(10);
        $set_value = Str::random(7);

        // Get available promotions
        $promotions = DB::table('promotions')
            ->where('status', 1)
            ->where('enable', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->get();

        return view('client.event.booking', compact('event', 'set_value', 'random_string', 'promotions'));
    }

    /**
     * Process event booking
     */
    public function bookEvent(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'code_booking' => 'required',
            'event_id' => 'required',
            'payment' => 'required|numeric',
        ]);

        // Insert booking into event_bookings table
        DB::table('event_bookings')->insert([
            'code_booking' => $request->code_booking,
            'user_id' => $auth->id_user,
            'event_id' => $request->event_id,
            'payment' => $request->payment,
            'status_payment' => 'unpaid',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create log
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'POST';
        $logs->description = 'book a new event';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($request->all());
        $logs->save();

        return redirect()->route('client')->with('notify', 'Success! You have booked an event. Please complete the payment.');
    }

    /**
     * Display unpaid event bookings
     */
    public function unpaidList()
    {
        $user = Auth::user();

        $bookings = DB::table('event_bookings')
            ->join('users', 'event_bookings.user_id', '=', 'users.id_user')
            ->join('events', 'event_bookings.event_id', '=', 'events.id')
            ->select('event_bookings.*', 'users.name', 'events.name as event_name', 'events.description')
            ->where('event_bookings.user_id', $user->id_user)
            ->where('event_bookings.status_payment', 'unpaid')
            ->orderBy('event_bookings.created_at', 'desc')
            ->get();

        return view('client.event.unpaid_list', compact('bookings'));
    }

    /**
     * Show payment page for event booking
     */
    public function payment($id)
    {
        $user = Auth::user();

        $booking = DB::table('event_bookings')
            ->join('users', 'event_bookings.user_id', '=', 'users.id_user')
            ->join('events', 'event_bookings.event_id', '=', 'events.id')
            ->select('event_bookings.*', 'users.name', 'users.email', 'events.name as event_name', 'events.description as event_description')
            ->where('event_bookings.id', $id)
            ->first();

        return view('client.event.payment', compact('booking'));
    }

    /**
     * Process event payment confirmation
     */
    public function confirmPayment(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'booking_id' => 'required',
            'photo_transfer' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $oldBooking = DB::table('event_bookings')->where('id', $request->booking_id)->first();

        if ($request->photo_transfer) {
            $imgName = $request->photo_transfer->getClientOriginalName() . '-' . time() . '.' . $request->photo_transfer->extension();
            $request->photo_transfer->move(public_path('images'), $imgName);
        }

        $check_img = isset($request->photo_transfer) ? $imgName : null;

        DB::table('event_bookings')->where('id', $request->booking_id)->update([
            'status_payment' => 'paid',
            'photo_transfer' => $check_img,
            'updated_at' => $now,
        ]);

        // Create log
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'confirm payment for event booking';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($oldBooking);
        $logs->data_new = json_encode(['status_payment' => 'paid']);
        $logs->save();

        return redirect()->route('client')->with('notify', 'Payment confirmed! Enjoy the event.');
    }

    /**
     * Display event booking history
     */
    public function history()
    {
        $auth = Auth::user();

        $bookings = DB::table('event_bookings')
            ->join('users', 'event_bookings.user_id', '=', 'users.id_user')
            ->join('events', 'event_bookings.event_id', '=', 'events.id')
            ->select('event_bookings.*', 'users.name', 'events.name as event_name', 'events.start_date', 'events.end_date')
            ->where('event_bookings.user_id', $auth->id_user)
            ->orderBy('event_bookings.created_at', 'desc')
            ->get();

        return view('client.event.history', compact('bookings'));
    }

    /**
     * Generate random string for booking code
     */
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
