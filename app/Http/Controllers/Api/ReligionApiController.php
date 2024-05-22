<?php

namespace App\Http\Controllers\Api;

use App\Religions;
use App\Http\Controllers\Controller;

class ReligionApiController extends Controller
{
    public function index()
    {
        $religions = Religions::all();

        $rlg = array();
        foreach($religions as $key => $value)
        {
            $rlg[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'description' => $value->description
            );
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'success',
            'data' => $rlg,
        ]);
    }
}
