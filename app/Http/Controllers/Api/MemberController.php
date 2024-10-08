<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Member::select('uid', 'name', 'surname', 'dep', 'created_by', 'created_at')->get();
        return response()->json($data);
    }

    public function otMember()
    {
        $data = Member::select('uid', 'name', 'surname', 'dep', 'created_by', 'created_at')->get();
        return response()->json($data);
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
            'uid' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'dep' => 'required',
        ]);

        $data = new Member();
        $data->uid = $request['uid'];
        $data->name = $request['name'];
        $data->surname = $request['surname'];
        $data->dep = $request['dep'];
        $data->level = 0;
        $data->created_by = Auth::user()->name . ' ' . Auth::user()->surname;

        $data->save();

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
        ///
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Member::find($id);

        if($data->overtime == null) {
            $data->overtime = 1;
        } else {
            $data->overtime = null;
        }

        $data->update();

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
