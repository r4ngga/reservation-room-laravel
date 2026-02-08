<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Log;
use App\Religions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 2)->get();
        $religions = Religions::all();
        // return view('user.all_user', compact('users'));
        return view('admin.user.index', compact('users', 'religions'));
    }

    public function fetchIndex()
    {
        $users = User::where('role', 2)->get();
        $html = '';
        foreach($users as $user){
            $html .= '<tr>';
            $html .= '<td>'.$user->id_user ?? ''.'</td>';
            $html .= '<td>'.$user->name ?? '-' .'</td>';
            $html .= '<td>'.$user->email ?? ''.'</td>';
            $html .= '<td>'.$user->phone_number ?? '' .'</td>';
            // $html .= '<td>'.$user->publisher ?? '' .'</td>';
            $html .= '<td>'; //act
                $html .= '<button onclick="getEdit(`'. $user->id_user .'`, `'. $user->name .'`, `'. $user->email .'`, `'.$user->phone_number.'`, `'.$user->address.'`, `'. $user->gender .'`)" data-toggle="modal" data-target="#edit-user" class="btn btn-sm btn-info">Edit</button>';

                $html .= '<a href="#" onclick="confirmDeleteUser('.$user->id_user .')" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ConfirmDeleteUser">Delete</a>';

                $html .= '<button onclick="fetchShowUser('. $user->id_user .')" data-toggle="modal" data-target="#ShowUserModal" class="btn btn-sm btn-warning">Show</button>';

            $html .= '</td>';
            $html .= '</tr>';
        }

        return response()->json(['html' => $html]);
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
            'religions' => $user->religions->name,
            'photo_profile' => $user->photo_profile,
            'created_at' => $user->created_at,
        );

        return response()->json($data);
    }

    public function fetchEditUser($id)
    {
        $user = User::findOrFail($id);

        $pp = '';
        if($user->photo_profile){
            $pp = '/images/photo_profile/' . $user->photo_profile;
        }else{
            $pp = '/images/photo_profile/default.png';
        }

        return response()->json(
            array(
                'id_user' => $user->id_user,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'phone_number' => $user->phone_number,
                'gender' => $user->gender,
                'role' => $user->role,
                'religions_id' => $user->religions_id,
                'photo_profile' => $pp,
            )
        );
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

        $imgName = '';
        if($request->photo_profile)
        {
            $imgName = $request->photo_profile->getClientOriginalName() . '-' . time() . '.' . $request->photo_profile->extension();
            $request->photo_profile->move(public_path('images/photo_profile'), $imgName);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt($request['password']);
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->role = 2;
        $user->religions_id = $request->religion_id;
        //$user->photo_profile = $request->photo_profile;
        $user->save();

        $user->assignRole('user');

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
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

        if ($validate) {
            return redirect('/rooms')->with('notify', 'Congratulations, your account successfully created, let "enjoy !');
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

        $find = User::where('id_user', $id)->first();

        $lastUser = DB::table('users')->where('id_user', $id)->first();
        $lastUserPassword = $lastUser->password;

        if(!$find)
        {
            return response()->json([
                'status' => false,
                'message' => 'Failed update data user because not found'
            ]);
        }

        $old_user = User::where('id_user', $id)->first();

        $update = User::where('id_user', $id)->first();
        $update->name = $request->name;
        $update->email = $request->email;
        $update->address = $request->address;
        $update->password = !empty($request->password) ? bcrypt($request['password']) : $lastUserPassword;
        $update->phone_number = $request->phone_number;
        $update->gender = $request->gender ;
        $update->religion_id = $request->religion_id;
        //$update->photo_progile = $imgName;
        $update->save();

        //create a logs
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'update a user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_user);
        $logs->data_new = json_encode($update);
        $logs->save();

        return response()->json(['notify' => 'success', 'data' => ' Success update information user !']);
    }

    public function delete($id)
    {
        $auth = Auth::user();
        $now = Carbon::now();
        $find = User::where('id_user', $id)->first();

        $old_data = User::where('id_user', $id)->first();

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
        $logs->user_id = $auth->id_user;
        $logs->action = 'delete';
        $logs->description = 'delete a user';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($old_data);
        $logs->data_new = '-';
        $logs->save();

        return response()->json([
            'message' => 'Success delete user',
            'status' => true,
        ]);
    }

}
