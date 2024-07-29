<?php

namespace App\Http\Controllers\Api;

use App\Room;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getAllUsers()
    {
        $users = User::where('role', 2)->get();
        $countusers = count($users);

        foreach($users as $usr)
        {
            $user[] = array(
                'id_user' => $usr->id_user,
                'name' => $usr->name,
                'email' => $usr->email,
                'address' => $usr->address,
                'phone_number' => $usr->phone_number,
                'gender' => $usr->gender,
                'role' => $usr->role,
                'religions_id' => $usr->religions_id,
            );
        }

        if($countusers > 0){
            $data = array(
                'status' => 200,
                'message' => 'success',
                'count_users' => $countusers,
                'data' => $user,
            );
        }else{
            $data = array(
                'status' => 404,
                'message' => 'users not found',
                'count_users' => 0,
            );
        }

        return response()->json($data);
    }

    public function getFetchUsers($id)
    {
        $user = User::findOrFail($id);
        $user = User::where('id_user',  $id)->get();
        $countusr = count($user);

        if($countusr > 0){
            foreach($user as $usr){
                $userData = array(
                    'id_user' => $usr->id_user,
                    'name' => $usr->name,
                    'email' => $usr->email,
                    'address' => $usr->address,
                    'phone_number' => $usr->phone_number,
                    'gender' => $usr->gender,
                    'role' => $usr->role,
                    'religions_id' => $usr->religions_id,
                    'created_at' => $usr->created_at,
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success',
                'counts' => $countusr,
                'data' => $userData,
            );
        }else{
            $data = array(
                'status' => false,
                'code' => 404,
                'message' => 'failed, not found',
                'counts' => 0,
            );
        }

        return response()->json($data);
    }

    public function fetchUsersByGender(Request $request)
    {
        $gender = $request->gender;

        $users = User::where('gender', $gender)->get();

        $countgenders = count($users);

        if($countgenders > 0){

            foreach($users as $usr ){
                $user = array(
                    'user_id' => $usr->user_id,
                    'name' => $usr->name,
                    'email' => $usr->email,
                    'address' => $usr->address,
                    'phone_number' => $usr->phone_number,
                    'gender' => $usr->gender,
                    'role' => $usr->role,
                    'religions_id' => $usr->religions_id,
                    'created_at' => $usr->created_at,
                );
            }

            $data = array(
                'status' => true,
                'code' => 200,
                'message' => 'success',
            );
        }
    }
}
