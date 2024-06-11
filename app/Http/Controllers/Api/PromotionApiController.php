<?php

namespace App\Http\Controllers\Api;

use App\Promotions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
