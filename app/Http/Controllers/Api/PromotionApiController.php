<?php

namespace App\Http\Controllers\Api;

use App\Promotions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionApiController extends Controller
{
    public function getAllPromotions(Request $request)
    {
        $keyword = $request->keyword ?? null;
        $limit = $request->limit ? (int)$request->limit : 10;
        $offset = $request->offset ? (int)$request->offset : 0;

        $promotions = Promotions::when($keyword, function($query) use ($keyword){
            $query->where('promotions.name', 'like', '%'. strtolower($keyword) . '%')
                  ->orWhere('promotions.status', $keyword);
        })
        ->where('promotions.enable', 1)
        ->take($limit)
        ->offset($offset)
        ->get();

        return response()->json([
            'status' => false,
            'code' => 200,
            'message' => 'Success show all promotions',
            'data' => $promotions,
        ], 200);
    }

    public function fetchDetailPromotions($id)
    {
        $find = Promotions::where('id', $id)->first();

        if(!$find)
        {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'Not Found a Promotions',
            ]);
        }

        $promotion = DB::table('promotions')
        ->where('id', $id)
        ->where('deleted_at', null)
        ->first();

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Success show a promotions',
            'data' => $promotion,
        ],200);
    }
}
