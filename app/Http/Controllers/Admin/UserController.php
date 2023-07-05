<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('user.all_user', compact('users'));
    }

    // public function show_all_user()
    // {
    //     $users = User::all();
    //     return view('user.all_user', ['users' => $users]);
    // }

    public function store(Request $request)
    {
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
        $user->save();

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request['password']),
        //     'address' => $request->address,
        //     'phone_number' => $request->phone_number,
        //     'gender' => $request->gender,
        // ]);

        if ($validate) {
            return redirect('/register')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
        }
    }

    public function userdashboard()
    {
        return view('user.dashboard');
    }
}
