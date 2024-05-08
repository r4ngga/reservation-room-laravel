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
}


