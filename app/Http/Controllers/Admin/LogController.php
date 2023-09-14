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
        //$log = Log::findOrFail($id);
        //return json_decode($log, true);
    }

}
