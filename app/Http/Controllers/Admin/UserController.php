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
            'gender' => 'required',
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
            'gender' => 'required',
        ]);

        $old_user = User::where('user_id', $id)->first();

        $update = User::where('user_Id', $id)->first();
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

}
