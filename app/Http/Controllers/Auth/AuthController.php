<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Log;
use Carbon\Carbon;

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

        $checkUseremail = User::where('email', $request->email)->first();

        if($checkUseremail){
            return redirect()->back()->withErrors('Email sudah terdaftar sebelumnya')->withInput();
        }

        $checkUserphone = User::where('phone_number', $request->phone_number)->first();

        if($checkUserphone){
            return redirect()->back()->withErrors('Nomor Telepon telah terdaftar');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt($request['password']);
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->role = 2;
        $user->save();

        $get_last_user = User::find($user->id_user);

        $now = Carbon::now();
        //create logs
        $logs = new Log();
        $logs->user_id = $user->id_user;
        $logs->action = 'POST';
        $logs->description = 'register a new user';
        $logs->role = $user->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($get_last_user);
        $logs->save();

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
        $now = Carbon::now();
        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth()->user()->role == 2) { //role pengguna (user) 2

                //create log
                // $user = Auth::user();
                // $log = new Log();
                // $log->user_id = $user->id_user;
                // $log->action = 'POST';
                // $log->description = 'login system';
                // $log->data_old = '-';
                // $log->data_new = '-';
                // $log->role = $user->role;
                // $log->log_time = $now;
                // $log->save();

                return redirect('/userdashboard');
            } elseif (auth()->user()->role == 1) { //role admin 1

                //create log
                $user = Auth::user();
                $log = new Log();
                $log->user_id = $user->id_user;
                $log->action = 'POST';
                $log->description = 'login system';
                $log->data_old = '-';
                $log->data_new = '-';
                $log->role = $user->role;
                $log->log_time = $now;
                $log->save();

                return redirect('admin-dashboard');
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
        $get_last_user = User::where('id_user', $request->id_user)->first();
        $repeat = $request->repeat_password;
        $passwrd = $request->password;

        if($repeat == $passwrd)
        {
            return redirect()->back()->withErrors('Password must match');
        }

        $user = User::where('id_user', $request->id_user)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $now = Carbon::new();

        //create log
        $log = new Log();
        $log->user_id = $user->id_user;
        $log->action = 'POST';
        $log->description = 'update a password';
        $log->data_old = json_encode($get_last_user);
        $log->data_new = json_encode($user);
        $log->role = $user->role;
        $log->log_time = $now;
        $log->save();

        // User::where('id_user', $request->id_user)->update([
        //     'password' => bcrypt($request['password']),
        // ]);
        return redirect('/userdashboard')->with('notify', 'Congratulation success changes password !!');
    }

    public function logout(Request $request)
    {
        $userAuth = Auth::user();
        $now = Carbon::now();

        //create log
        $log = new Log();
        $log->user_id = $userAuth->id_user;
        $log->action = 'POST';
        $log->description = 'logout from system';
        $log->data_old = '-';
        $log->data_new = '-';
        $log->role = $userAuth->role;
        $log->log_time = $now;
        $log->save();

        $request->session()->flush();
        Auth::logout();
        return redirect('/login')->with('notify', 'Success Logout');
    }

    public function forgotPassword()
    {
        return view('resetpassword');
    }

    public function validationPhoneNumber(Request $request)
    {
        $phone = $request->phone_number;
        $nomer_explode = $phone;

        if(substr($nomer_explode, 0, 2) === "62"){
            $nomerparse = explode('62', $nomer_explode)[1];
            $phone = '0'.$nomerparse;
        }
        $checkPhone = User::where('phone_number', $phone)->first();

        $status = array(
            'message' => 'valid',
            'status' => true,
        );

        if($checkPhone){
            $status = array(
                'message' => 'this number phone has been use',
                'status' => false,
            );
        }

        return response()->json($status);

    }

    public function validationEmail(Request $request)
    {
        $email = $request->email;

        $checkEmail = User::where('email', $email)->first();

        $status = array(
            'message' => 'valid',
            'status' => true,
        );

        if($checkEmail){
            $status = array(
                'message' => 'this email has been taken',
                'status' => false,
            );
        }
        return response()->json($status);

    }
}
