<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function myaccount()
    {
        $account = Auth::user();
        // dd($account);
        return view('myaccount', compact('account'));
    }

    public function loginpage()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
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

        // if ($validate) {
            return redirect('/register')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
        // }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role == 2) { //role pengguna (user) 2
                return redirect('/userdashboard');
            } elseif (auth()->user()->role == 1) { //role admin 1
                return redirect('/admindashboard');
            } else {
                return redirect('/login')->with('notify', 'You don"t have role');
            }
        } else {
            return redirect('/login')->with('notify', 'Email or Password wrong');
        }
    }

    public function settingaccount()
    {
        $getUser = Auth::user();
        return view('setting', compact('getUser'));
    }

    public function updatesettingacc(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);

        $user = User::where('id_user', $request->id_user)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->save();

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
        $request->validate([
            'password' => 'required',
            'repeat_password' => 'required',
        ]);
        $repeat = $request->repeat_password;
        $passwrd = $request->password;

        if($repeat == $passwrd)
        {
            // return redirect()->back()->withErrors('Inputan Jumlah Siswa 0')->withInput();
            return redirect()->back()->withErrors('Password must match');
        }

        $user = User::where('id_user', $request->id_user)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // User::where('id_user', $request->id_user)->update([
        //     'password' => bcrypt($request['password']),
        // ]);
        return redirect('/userdashboard')->with('notify', 'Congratulation success changes password !!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('notify', 'Success Logout');
    }
}
