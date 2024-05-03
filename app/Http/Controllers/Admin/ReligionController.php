<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Religions;

class ReligionController extends Controller
{
    public function index()
    {
        $religions = Religions::where('');

        //return view('', compact('religions'));
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => '',
        ]);

        $religion = new Religions();
        $religion->name = $request->name;
        $religion->description = $request->description;
        $religion->save();

        return redirect()->back()->with('notify', 'Success add data religions ');
    }
}


