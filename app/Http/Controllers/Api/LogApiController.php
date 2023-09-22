<?php

namespace App\Http\Controllers\Api;

use App\Log;
use App\Room;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LogApiController extends Controller
{
    public function getLogs()
    {
        $logs = Log::orderBy('created_at','desc')->get();
        $countlogs = count($logs);

        $log = array();

        foreach($logs as $lg){
            $role = ($lg->role == 1)? 'admin' : 'user';
            $log = array(
                'id' => $lg->id,
                'user_id' => $lg->user_id,
                'name' => $lg->user->name,
                'description' => $lg->description,
                'action' => $lg->action,
                'log_time' => $lg->log_time,
                'role' => $role,
                'data_new' => $lg->data_new,
                'data_old' => $lg->data_old,
                'created_at' => $lg->created_at,
            );
        }

        if($logs > 0){
            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_logs' => $countlogs,
                'data' => $log,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'logs not found',
                'count_logs' => 0,
            );
        }
        dd($data);

        return response()->json($data);
    }
}
