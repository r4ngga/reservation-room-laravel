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
        $users = User::where('role', 2)->paginate(10);
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

    public function impersonate($id)
    {
        $admin = Auth::user();
        $now = Carbon::now();

        $targetUser = User::where('id_user', $id)->where('role', 2)->first();

        if (!$targetUser) {
            return redirect()->route('users')->with('notify', 'Failed to impersonate: user not found or is not a regular user.');
        }

        // Store original admin ID in session
        session()->put('impersonate.admin_id', $admin->id_user);
        session()->put('impersonate.user_id', $targetUser->id_user);

        // Log the impersonation action
        $logs = new Log();
        $logs->user_id = $admin->id_user;
        $logs->action = 'POST';
        $logs->description = 'impersonate user ' . $targetUser->name . ' (ID: ' . $targetUser->id_user . ')';
        $logs->role = $admin->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode(['admin_id' => $admin->id_user, 'target_user_id' => $targetUser->id_user]);
        $logs->save();

        // Switch auth to the target user
        if (!$targetUser->hasRole('user')) {
            $targetUser->assignRole('user');
        }
        Auth::loginUsingId($targetUser->id_user);

        return redirect()->route('client')->with('notify', 'You are now impersonating ' . $targetUser->name);
    }

    public function stopImpersonate()
    {
        $adminId = session('impersonate.admin_id');
        $userId = session('impersonate.user_id');
        $now = Carbon::now();

        if (!$adminId) {
            return redirect()->route('admin')->with('notify', 'No active impersonation session.');
        }

        $impersonatedUser = User::where('id_user', $userId)->first();

        // Log the stop impersonation action
        $logs = new Log();
        $logs->user_id = $adminId;
        $logs->action = 'POST';
        $logs->description = 'stop impersonate user' . ($impersonatedUser ? ' ' . $impersonatedUser->name : '') . ' (ID: ' . $userId . ')';
        $logs->role = 1;
        $logs->log_time = $now;
        $logs->data_old = json_encode(['admin_id' => $adminId, 'target_user_id' => $userId]);
        $logs->data_new = '-';
        $logs->save();

        // Clear impersonation session
        session()->forget(['impersonate.admin_id', 'impersonate.user_id']);

        // Restore admin session
        Auth::loginUsingId($adminId);

        return redirect()->route('admin')->with('notify', 'Impersonation ended. Welcome back, Admin.');
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
