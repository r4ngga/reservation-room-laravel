<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use App\Religions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReligionController extends Controller
{
    public function index()
    {
        $religions = Religions::where('');

        //return view('admin.religion.index', compact('religions'));
    }

    public function add(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $this->validate($request, [
            'name' => 'required',
            'description' => '',
        ]);

        $religion = new Religions();
        $religion->name = $request->name;
        $religion->description = $request->description;
        $religion->save();

        //create a logs
        $log = new Log();
        $log->user_id = $auth->user_id;
        $log->action = 'POST';
        $log->description = 'add a new data religions';
        $log->role = $auth->role;
        $log->log_time = $now;
        $log->data_old = '-';
        $log->data_new = json_encode($religion);
        $log->save();

        return redirect()->back()->with('notify', 'Success add data religions ');
    }

    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        $now = Carbn::now();

        $this->validate($request, [
            'name' => 'required',
            'description' => '',
        ]);

        $lastdata = Religions::where('id', $id)->first();

        $rlg = Religions::where('id', $id)->first();
        $rlg->name = $request->name;
        $rlg->description = $request->description ?? null;
        $rlg->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'PUT';
        $logs->description = 'change & update data religion';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($lastdata);
        $logs->data_new = json_encode($rlg);
        $logs->save();
        //create a logs

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success update a data religion',
            'data' => json_encode($rlg),
        ]);
    }
}


