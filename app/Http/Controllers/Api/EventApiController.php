<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Https\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventApiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? null;
        $offset = $request->offset ? (int)$request->offset : 0;
        $limit = $request->limit ? (int)$request->limit : 10;

        $events = Event::when($keyword, function($query) use($keyword){
            $query->where('');
        });
    }
}
