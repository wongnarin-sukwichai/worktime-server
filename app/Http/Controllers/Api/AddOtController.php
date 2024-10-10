<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Models\Otin;
use App\Models\Otout;
use App\Models\Member;
use App\Models\Otrecord;

class AddOtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'uid' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'dat' => 'required',
        ]);

        if($request['code'] == 1) {

        $data = new Otin();

        $data->uid = $request['uid'];
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->dat = $request['dat'];
        $data->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $data->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $data->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $data->timein = $request['timein'];
        $data->otherin = $request['otherin'];
        $data->created = Auth::user()->name . ' ' . Auth::user()->surname;

        $data->save();

        } else { 

        $result = new Otout();

        $result->uid = $request['uid'];
        $result->name = $request['name'];
        $result->surname = $request['surname'];
        $result->dat = $request['dat'];
        $result->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $result->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $result->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $result->timeout = $request['timeout'];
        $result->otherout = $request['otherout'] . ' : ' . Auth::user()->name . ' ' . Auth::user()->surname;
        $result->created = Auth::user()->name . ' ' . Auth::user()->surname;

        $result->save();

        }

        $res = new Otrecord();

        $res->type = '3';
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $request['uid'] ;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->dat = $request['dat'];
        $res->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $res->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $res->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        if($request['code'] == 1) {
            $res->timenew = $request['timein'];
        } else {
            $res->timenew = $request['timeout'];
        } 
        $res->other = $request['otherout'] . ' : ' . Auth::user()->name . ' ' . Auth::user()->surname;

        $res->save();

        return response()->json([
            'message' => 'แก้ไขข้อมูลเรียบร้อย'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
