<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 2)->get();
        return view('user.all_user', compact('users'));
    }

    public function fetch_all_user()
    {
        $users = User::where('role', 2)->get();
        json_encode($users);
        // return view('user.all_user', ['users' => $users]);
    }

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

    public function update(Request $request)
    {
        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        $update = new User();
        $update->name = $request->name;
        $update->email = $request->email;
        $update->address = $request->address;
        $update->password = bcrypt($request->password) ;
        $update->phone_number = $request->phone_number;
        $update->gender = $request->gender ;
        $update->save();
    }

    // public function changepassword()
    // {
    //     $getUserPassword = Auth::user();
    //     return view('change_password', compact('getUserPassword'));
    // }

    // public function updatechangepassword(Request $request)
    // {
    //     $request->validate([
    //         'password' => 'required',
    //         'repeat_password' => 'required'
    //     ]);
    //     $repeat = $request->repeat_password;
    //     $passwrd = $request->password;

    //     if($repeat == $passwrd){
    //         // return redirect()->back()->withErrors('Inputan Jumlah Siswa 0')->withInput();
    //         return redirect()->back()->withErrors('Password must match');
    //     }

    //     $user = User::wher('id_user', $request->id_user)->first();
    //     $user->password = bcrypt($request->password);
    //     $user->save();

    //     return redirect()->back()->with('notify', 'Success change a password');
    // }

    // public function userdashboard()
    // {
    //     return view('user.dashboard');
    // }
}