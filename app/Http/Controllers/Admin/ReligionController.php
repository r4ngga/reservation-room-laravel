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
        $religions = Religions::all();

        return view('admin.religion.index', compact('religions'));
    }

    public function fetchIndex()
    {
        $religions = Religions::all();
        $html = '';
        foreach($religions as $key => $rg){
            $html .= '<tr class="hover:bg-gray-50/50 transition-colors group">';
            $html .= '<td class="px-8 py-5"><span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded tracking-normal">#'. ($key + 1) .'</span></td>';
            $html .= '<td class="px-8 py-5"><span class="text-gray-800 font-bold">'. $rg->name .'</span></td>';
            $html .= '<td class="px-8 py-5"><span class="text-gray-500 text-sm">'. ($rg->description ?? '-') .'</span></td>';
            $html .= '<td class="px-8 py-5">';
            $html .= '<div class="flex items-center justify-center space-x-2">';
            $html .= '<button onclick="fetchShow('. $rg->id .')" @click="showDetail = true" class="p-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="View Detail"><i class="fas fa-eye"></i></button>';
            $html .= '<button onclick="fetchEdit('. $rg->id .')" @click="showEdit = true" class="p-2 text-cyan-600 bg-cyan-50 rounded-lg hover:bg-cyan-600 hover:text-white transition-all shadow-sm" title="Edit"><i class="fas fa-edit"></i></button>';
            $html .= '<button onclick="confirmDelete('. $rg->id .', `'. $rg->name .'`)" @click="showDelete = true" class="p-2 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Delete"><i class="fas fa-trash"></i></button>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        return response()->json(['html' => $html]);
    }

    public function fetchDetail($id)
    {
        $religion = Religions::findOrFail($id);
        return response()->json($religion);
    }

    public function fetchEdit($id)
    {
        $religion = Religions::findOrFail($id);
        return response()->json($religion);
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $religion = new Religions();
        $religion->name = $request->name;
        $religion->description = $request->description;
        $religion->save();

        //create a logs
        $log = new Log();
        $log->user_id = $auth->id_user; // Corrected from user_id if User model uses id_user
        $log->action = 'POST';
        $log->description = 'add a new data religions';
        $log->role = $auth->role;
        $log->log_time = $now;
        $log->data_old = '-';
        $log->data_new = json_encode($religion);
        $log->save();

        return redirect()->back()->with('notify', 'Success add data religions');
    }

    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $lastdata = Religions::findOrFail($id);
        $old_data = clone $lastdata;

        $rlg = Religions::findOrFail($id);
        $rlg->name = $request->name;
        $rlg->description = $request->description;
        $rlg->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'change & update data religion';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data);
        $logs->data_new = json_encode($rlg);
        $logs->save();

        return response()->json([
            'status' => true,
            'message' => 'Success update a data religion',
            'data' => $rlg,
        ]);
    }

    public function delete($id)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $find = Religions::findOrFail($id);

        $old_data = clone $find;
        $find->delete();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->description = 'delete data religion';
        $logs->action = 'DELETE';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data);
        $logs->data_new = '-';
        $logs->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Religion successfully deleted'
        ]);
    }
}


