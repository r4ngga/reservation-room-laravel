<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $evnts = DB::table('events')->where('deleted_at', null)
        ->get();

        return view('admin.event.index', compact('evnts'));
    }

    public function add(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'enable' => 'in:0,1',
            'price' => 'required|numeric',
            'implement_with_promotion' => '',
            'start_date' => '',
            'end_date' => '',
        ]);

        $cekstatus = ($request->enable) ? 1 : 0;
        // if($cekstatus == )

        $add = DB::table('events')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable,
            'status' => $cekstatus,
            'price' =>  $request->price,
            'implement_with_promotion' => $request->implement,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->description = 'add data events';
        $logs->action = 'POST';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_decode($add);
        $logs->save();
        //create a logs

        return redirect()->back()->with('notify', 'Success add a new data events !');
    }

    public function show($id)
    {
        $auth = Auth::user();
        $evnt = DB::table('events')->where('id', $id)->first();

        if(!$evnt){
            return response()->json([
                'status' => false,
                'message' => 'Failed show a detail data event !',
            ], 404);
        }

        $data = array(
            'id' => $evnt->id,
            'name' => $evnt->name,
            'description' => $evnt->description,
            'enable' => $evnt->enable,
            'status' => $evnt->status,
            'implement_with_promotion' => $evnt->implement_with_promotion,
            'start_date' => $evnt->start_date,
            'created_at' => $evnt->created_at,
        );
            return response()->json($data);
    }
}
