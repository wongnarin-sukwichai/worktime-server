<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Otin;
use App\Models\Otout;
use App\Models\Otrecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EditOtController extends Controller
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
        //
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

        $data = Otout::find($request['id']);

        $data->otherout = null;

        $data->update();
        
        $data->otherout = $request['otherout'] . ' : ' . Auth::user()->name . ' ' . Auth::user()->surname;

        $data->update();

        $res = new Otrecord();
        $res->ref_id = $request['id'];
        $res->type = 4;
        $res->created_by = Auth::user()->name . ' ' . Auth::user()->surname;
        $res->uid = $data->uid;
        $res->name = $request['name'];
        $res->surname = $request['surname'];
        $res->dat = $request['dat'];
        $res->d = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('d');
        $res->m = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('m');
        $res->y = Carbon::createFromFormat('Y-m-d', $request['dat'])->format('Y');
        $res->other = $request['otherout'];

        $res->save();

        return response()->json([
            'message' => 'แก้ไขข้อมูลเรียบร้อย'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
