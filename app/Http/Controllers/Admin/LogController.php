<?php

namespace App\Http\Controllers\Admin;

use App\Log;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LogController extends Controller
{

    public function index()
    {
        $logs = Log::orderBy('created_at','desc')->get();
        $countlogs = count($logs);

        return view('logs.index', compact('logs', 'countlogs'));
    }

    public function fetchDetail($id)
    {
        $log = Log::findOrFail($id);
        // dd($log->user->name);
        $role = ($log->role == 1)? 'admin' : 'user';
        $parselogtime = Carbon::parse($log->log_time)->locale('id');
        $parselogtime->settings(['formatFunction' => 'translatedFormat']);
        $log_time = $parselogtime->format('l, j F Y ; h:i');
        $data = array(
            'id' => $log->id,
            'user_id' => $log->user_id,
            'name' => $log->user->name,
            'description' => $log->description,
            'action' => $log->action,
            'log_time' => $log_time,
            'role' => $role,
            'data_new' => json_decode($log->data_new),
            'data_old' => json_decode($log->data_old),
            'created_at' => $log->created_at,
        );
        // dd($data);
        return json_encode($data, true);
    }

}
