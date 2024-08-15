<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;
use App\Log;
use App\Promotions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = DB::table('promotions')
        ->where('deleted_at', null)
        ->get();

        return view('admin.promotion.index', compact('promotions'));
    }

    public function fetchIndex(){
        $promotions = DB::table('promotions')
        ->where('deleted_at', null)
        ->get();

        $html = '';
        foreach($promotions as $promotion){
            $html .= '<tr>';
            $html .= '<td>'.$promotion->id ?? ''.'</td>';
            $html .= '<td>'.$promotion->name ?? '' . '</td>';
            $html .= '<td>'. $promotion->enable ?? ''. '</td>';
            $html .= '<td>'.$promotion->start_date ?? '' .'</td>';
            $html .= '<td>'.$promotion->end_date ?? '' .'</td>';
            $html .= '<td>';
            // $html .= '<a href="#" onclick="fetchEditPromot(`'.$promotion->id. '`, {{ $pr->name ?? '' }}, {{ $pr->description ?? '' }}, {{ $pr->start_date ?? ''}}, {{ $pr->end_date ?? ''}} )" href="#" data-toggle="modal" data-name="{{$pr->name}}" data-description="{{$pr->description ?? ''}}" data-target="#editPromotion" class="btn btn-info">Change</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
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
            'start_date' => '',
            'end_date' => '',
        ]);

        $promotion = new Promotions();
        $promotion->name = $request->name;
        $promotion->description = $request->description;
        $promotion->enable = $request->enable ?? 0;
        $promotion->price = $request->price ?? 0;
        $promotion->start_date = $request->start_date ?? Carbon::now();
        $promotion->end_date = $request->end_date;
        $promotion->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->description = 'add data description';
        $logs->action = 'POST';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_decode($promotion);
        $logs->save();
        //create a logs

        return redirect()->back()->with('notify', 'Success add a new data promotion !');
    }

    public function show($id)
    {
        $promotion_id = $id;

        $check = DB::table('promotions')->where('id', $id)->first();

        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'Not Found Data Promotion'
            ]);
        }

        $promotion = DB::table('promotions')->where('id', $promotion_id)->first();
        $data = array(
            'id' => $promotion->id,
            'name' => $promotion->name,
            'status' => $promotion->status,
            'enable' => $promotion->enable,
            'price' => $promotion->price,
            'start_date' => $promotion->start_date,
            'end_date' => $promotion->end_date
        );

        return response()->json([
            'status' => true,
            'message' => 'Success show data promotion',
            'data' => $data,
        ],200);
    }

    public function update($id, Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'enable' => 'required|in:0,1',
            'price' => 'required|numeric',
        ]);

        $check = DB::table('promotions')->where('id', $id)->first();
        if(!$check)
        {
            return response()->json([
                'status' => false,
                'message' => 'Data Promotion Not Found'
            ], 404);
        }

        $status = ($request->enable == 1) ? 1 : 0;
        $promotion = DB::table('promotions')->where('id',$id)
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable,
            'status' => $status,
            'price' =>  $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->description = 'change & update promotion data';
        $logs->action = 'PUT';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($check);
        $logs->data_new = json_encode($promotion);
        $logs->save();
        //create a logs

        return redirect('/promotions')->with('notify', 'Success save changes update promotion data');

    }

    public function delete($id)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $old_data = DB::table('promotions')->where('id', $id)->first();

        if(!$old_data)
        {
            return response()->json([
                'status' => false,
                'message' => 'Can`t Delete, Promotion Not Found'
            ], 404);
        }

        $delete = DB::table('promotions')->where('id', $id)->delete();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->role = $auth->role;
        $logs->description = 'delete a promotion';
        $logs->action = 'delete';
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data);
        $logs->data_new = '-';
        $logs->save();
        //create a logs

        return redirect('/promotions')->with('notify', 'Success delete a promotions');
    }
}
