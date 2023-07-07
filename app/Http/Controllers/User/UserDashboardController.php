<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('myaccount');
    }



    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);
    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         if (auth()->user()->role == 2) { //role pengguna (user) 2
    //             return redirect('/userdashboard');
    //         } elseif (auth()->user()->role == 1) { //role admin 1
    //             return redirect('/admindashboard');
    //         } else {
    //             return redirect('/login')->with('notify', 'You don"t have role');
    //         }
    //     } else {
    //         return redirect('/login')->with('notify', 'Email or Password wrong');
    //     }
    // }

    public function settingaccount()
    {
        return view('setting');
    }

    public function updatesettingacc(Request $request, User $user)
    {
        $validate =  $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        $user_update = User::where('id_user', $request->id_user)->get();
        $user_update->name = $request->name;
        $user_update->email = $request->email;
        $user_update->address = $request->address;
        $user_update->phone_number = $request->phone_number;
        $user_update->gender = $request->gender;
        $user_update->save();

        // User::where('id_user', $request->id_user)->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'address' => $request->address,
        //     'phone_number' => $request->phone_number,
        //     'gender' => $request->gender,
        // ]);

        return redirect('/userdashboard')->with('notify', 'Congratulation success changes setting account !!');
    }

    public function changepassword()
    {
        $getUserPassword = Auth::user();
        return view('change_password', compact('getUserPassword'));
    }

    public function updatechangepassword(Request $request, User $user)
    {
        $validate =  $request->validate([
            'password' => 'required',
            'repeat_password' => 'required',
        ]);
        User::where('id_user', $request->id_user)->update([
            'password' => bcrypt($request['password']),
        ]);
        return redirect('/userdashboard')->with('notify', 'Congratulation success changes password !!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('notify', 'Success Logout');
    }
}
