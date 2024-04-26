<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 2)->get();
        // return view('user.all_user', compact('users'));
        return view('admin.user.index', compact('users'));
    }

    public function fetch_all_user()
    {
        $users = User::where('role', 2)->get();
        json_encode($users);
        // return view('user.all_user', ['users' => $users]);
    }

    public function fetchDetailUser($id)
    {
        $user = User::findOrFail($id);

        $data = array(
            'id' => $user->id_user,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'gender' => $user->gender,
            'role' => $user->role,
            'created_at' => $user->created_at,
        );

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required|in:1,2',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt($request['password']);
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->role = 2;
        $user->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'POST';
        $logs->description = 'add a new user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($user);
        $logs->save();

        if ($validate) {
            return redirect('/register')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
        }
    }

    public function update($id, Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required|in:1,2',
        ]);

        $find = User::where('user_id', $id)->first();

        if(!$find)
        {
            return response()->json([
                'status' => false,
                'message' => 'Failed update data user because not found'
            ]);
        }

        $old_user = User::where('user_id', $id)->first();

        $update = User::where('user_id', $id)->first();
        $update->name = $request->name;
        $update->email = $request->email;
        $update->address = $request->address;
        $update->password = bcrypt($request->password) ;
        $update->phone_number = $request->phone_number;
        $update->gender = $request->gender ;
        $update->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'PUT';
        $logs->description = 'update a user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_user);
        $logs->data_new = json_encode($update);
        $logs->save();

        return response()->json(['notify' => 'Success update information user']);
    }

    public function delete($id)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $find = User::where('id_user', $id)->first();

        $old_data = User::where('id_user', $id)->first();
        dd($find);

        if(!$find)
        {
            return response()->json([
                'message' => 'Failed delete this users, because not found',
                'status' => false,
            ], 404);
        }

        User::destroy($id);

        //create logs
        $logs = new Log();
        $logs->user_id = $auth->user_id;
        $logs->action = 'delete';
        $logs->description = 'delete a user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = $old_data;
        $logs->data_new = '-';
        $logs->save();

        return response()->json([
            'message' => 'Success delete user',
            'status' => true,
        ]);
    }

}
