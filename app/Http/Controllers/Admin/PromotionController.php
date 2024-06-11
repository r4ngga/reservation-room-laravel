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

    public function update()
    {}
}
