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
        $events = DB::table('events')->where('deleted_at', null)
        ->paginate(10);

        return view('admin.event.index', compact('events'));
    }

    public function add(Request $request)
    {
        $auth = Auth::user();
        // dd($auth->id_user);
        $now = Carbon::now();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'enable' => 'in:0,1',
            // 'price' => 'required|numeric',
            'implement_with_promotion' => '',
            'start_date' => '',
            'end_date' => '',
        ]);

        $cekstatus = ($request->enable) ? 1 : 0;

        DB::table('events')->insert([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable,
            'status' => $cekstatus,
            // 'price' =>  $request->price,
            'implement_with_promotion' => $request->implement_with_promotion,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->description = 'add data events';
        $logs->action = 'POST';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($request->all());
        $logs->save();
        //create a logs

        return redirect()->back()->with('notify', 'Success add a new data events!');
    }

    public function show($id)
    {
        try {
            $evnt = DB::table('events')->where('id', $id)->first();

            if(!$evnt){
                return response()->json([
                    'status' => false,
                    'message' => 'Failed show a detail data event!',
                ], 404);
            }

            $data = array(
                'id' => $evnt->id ?? '',
                'name' => $evnt->name ?? 'No Name',
                'description' => $evnt->description ?? 'No Description',
                'enable' => $evnt->enable ?? 0,
                'status' => $evnt->enable ?? 0,
                'implement_with_promotion' => $evnt->implement_with_promotion ?? 0,
                'start_date' => $evnt->start_date ?? '-',
                'end_date' => $evnt->end_date ?? '-',
                'price' => $evnt->price ?? 0,
                'created_at' => $evnt->created_at ? Carbon::parse($evnt->created_at)->format('d M Y, H:i') : '-',
            );

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching event data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $evnt = DB::table('events')->where('id', $id)->first();

            if(!$evnt){
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch event data!',
                ], 404);
            }

            $data = array(
                'id' => $evnt->id ?? '',
                'name' => $evnt->name ?? '',
                'description' => $evnt->description ?? '',
                'enable' => $evnt->enable ?? 0,
                'status' => $evnt->enable ?? 0,
                'implement_with_promotion' => $evnt->implement_with_promotion ?? 0,
                'start_date' => $evnt->start_date ?? '',
                'end_date' => $evnt->end_date ?? '',
                'price' => $evnt->price ?? 0,
                'created_at' => $evnt->created_at ?? '',
            );

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching event data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
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

        $oldEvent = DB::table('events')->where('id', $id)->first();

        DB::table('events')->where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable,
            'status' => $cekstatus,
            'price' => $request->price,
            'implement_with_promotion' => $request->implement_with_promotion,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->description = 'update data events';
        $logs->action = 'PUT';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($oldEvent);
        $logs->data_new = json_encode($request->all());
        $logs->save();
        //create a logs

        return response()->json([
            'status' => true,
            'message' => 'Success update event data!'
        ]);
    }

    public function delete($id)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $oldEvent = DB::table('events')->where('id', $id)->first();

        DB::table('events')->where('id', $id)->update([
            'deleted_at' => $now
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->description = 'delete data events';
        $logs->action = 'DELETE';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($oldEvent);
        $logs->data_new = json_encode(['deleted' => true]);
        $logs->save();
        //create a logs

        return response()->json([
            'status' => true,
            'message' => 'Success delete event data!'
        ]);
    }
}
