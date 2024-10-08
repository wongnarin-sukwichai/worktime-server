<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Checkin;
use App\Models\Checkout;
use Carbon\Carbon;
use App\Models\Member;

use App\Models\Otin;
use App\Models\Otout;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function reportDay(Request $request)
    {
        $request->validate([
            'selected' => 'required',
        ]);

        $d = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("d");
        $m = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("m");
        $y = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("Y");

        $i = 0;
        $arr = [];

        $member = Member::select('uid', 'name', 'surname', 'dep')
            ->orderBy('dep', 'ASC')
            ->get();

        $cin = Checkin::where('dat', $request['selected'])->get();
        $cout = Checkout::where('dat', $request['selected'])->get();

        foreach ($member as $r) {
            $arr[$i]['uid'] = $r->uid;
            $arr[$i]['name'] = $r->name;
            $arr[$i]['surname'] = $r->surname;
            $arr[$i]['dep'] = $r->dep;
            $arr[$i]['dat'] = $request['selected'];
            $arr[$i]['d'] = $d;
            $arr[$i]['m'] = $m;
            $arr[$i]['y'] = $y;

            foreach ($cin as $j) {

                if ($r->uid == $j->uid) {
                    $arr[$i]['idin'] = $j->id;
                    $arr[$i]['picin'] = $j->pic;
                    $arr[$i]['timein'] = $j->timein;
                    $arr[$i]['otherin'] = $j->otherin;

                    foreach ($cout as $j) {

                        if ($r->uid == $j->uid) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                } else {

                    foreach ($cout as $j) {

                        if ($r->uid == $j->uid) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                }
            }

            $i++;
        }

        return response()->json($arr);
    }

    public function member()
    {
        $data = Member::all();
        dd($data);
        return response()->json($data);
    }

    public function reportMember(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'selected' => 'required',
        ]);

        $m = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("m");
        $y = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("Y");

        // ตั้งค่าจำนวนวันของแต่ละเดือน
        switch ($m) {
            case '1':
            case '3':
            case '5':
            case '7':
            case '8':
            case '10':
            case '12':
                $total = 31;
                break;
            case '4':
            case '6':
            case '9':
            case '11':
                $total = 30;
                break;
            case '2':
                $total = 28;
                break;
        }

        $i = 1;
        $arr = [];

        $member = Member::where('uid', $request['uid'])->first();

        $cin = Checkin::where('uid', $request['uid'])
            ->where('m', $m)
            ->where('y', $y)->get();
        $cout = Checkout::where('uid', $request['uid'])
            ->where('m', $m)
            ->where('y', $y)
            ->get();

        for ($i; $i <= $total; $i++) {

            if($i < 10) {
                $k = sprintf("%02d", $i);
            } else {
                $k = $i;
            }

            $arr[$i]['name'] = $member->name;
            $arr[$i]['surname'] = $member->surname;
            $arr[$i]['dat'] = $y . '-' . $m . '-' . $k;
            $arr[$i]['m'] = $m;
            $arr[$i]['y'] = $y;

            foreach ($cin as $r) {
                if ($k == $r->d) {
                    $arr[$i]['idin'] = $r->id;
                    $arr[$i]['picin'] = $r->pic;
                    $arr[$i]['din'] = $r->d;
                    $arr[$i]['timein'] = $r->timein;
                    $arr[$i]['otherin'] = $r->otherin;

                    foreach ($cout as $j) {
                        if ($i == $j->d) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['dout'] = $j->d;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                } else {

                    foreach ($cout as $j) {
                        if ($i == $j->d) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['dout'] = $j->d;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                }
            }
        }
        return response()->json($arr);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reportDayOt(Request $request)
    {
        $request->validate([
            'selected' => 'required',
        ]);

        $d = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("d");
        $m = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("m");
        $y = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("Y");

        $i = 0;
        $arr = [];

        // $member = Member::select('uid', 'name', 'surname', 'dep')
        //     ->where('overtime', 1)
        //     ->orderBy('dep', 'ASC')
        //     ->get();

        $cin = Otin::where('dat', $request['selected'])->orderBy('otherin', 'ASC')->get();
        $cout = Otout::where('dat', $request['selected'])->get();

        foreach ($cin as $r) {
            $arr[$i]['idin'] = $r->id;
            $arr[$i]['uid'] = $r->uid;
            $arr[$i]['picin'] = $r->pic;
            $arr[$i]['name'] = $r->name;
            $arr[$i]['surname'] = $r->surname;
            $arr[$i]['local'] = $r->local;
            $arr[$i]['dat'] = $request['selected'];
            $arr[$i]['d'] = $d;
            $arr[$i]['m'] = $m;
            $arr[$i]['y'] = $y;
            $arr[$i]['timein'] = $r->timein;
            $arr[$i]['otherin'] = $r->otherin;

            if($r->otherin == '1') {
                $arr[0]['head'] = $r->name . ' ' . $r->surname;
            }

            foreach ($cout as $j) {

                if ($r->uid == $j->uid) {
                    $arr[$i]['idout'] = $j->id;
                    $arr[$i]['picout'] = $j->pic;
                    $arr[$i]['timeout'] = $j->timeout;
                    $arr[$i]['otherout'] = $j->otherout;                
                }
            }
            $i++;
        }

        // $arr[0]['count'] = $i;

        return response()->json($arr);
    }

    public function reportOtMember(Request $request)
    {

        $request->validate([
            'uid' => 'required',
            'selected' => 'required',
        ]);

        $m = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("m");
        $y = Carbon::createFromFormat('Y-m-d', $request['selected'])->format("Y");

        // ตั้งค่าจำนวนวันของแต่ละเดือน
        switch ($m) {
            case '1':
            case '3':
            case '5':
            case '7':
            case '8':
            case '10':
            case '12':
                $total = 31;
                break;
            case '4':
            case '6':
            case '9':
            case '11':
                $total = 30;
                break;
            case '2':
                $total = 28;
                break;
        }

        $i = 1;
        $arr = [];

        $member = Member::where('uid', $request['uid'])->first();

        $cin = Otin::where('uid', $request['uid'])
            ->where('m', $m)
            ->where('y', $y)->get();
        $cout = Otout::where('uid', $request['uid'])
            ->where('m', $m)
            ->where('y', $y)
            ->get();

        for ($i=1; $i <= $total; $i++) {

            if($i < 10) {
                $k = sprintf("%02d", $i);
            } else {
                $k = $i;
            }

            $arr[$i]['name'] = $member->name;
            $arr[$i]['surname'] = $member->surname;
            $arr[$i]['dat'] = $y . '-' . $m . '-' . $k;
            $arr[$i]['m'] = $m;
            $arr[$i]['y'] = $y;

            foreach ($cin as $r) {

                if ($k == $r->d) {
                    $arr[$i]['idin'] = $r->id;
                    $arr[$i]['picin'] = $r->pic;
                    $arr[$i]['din'] = $r->d;
                    $arr[$i]['timein'] = $r->timein;
                    $arr[$i]['otherin'] = $r->otherin;

                    foreach ($cout as $j) {
                        if ($i == $j->d) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['dout'] = $j->d;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                } else {

                    foreach ($cout as $j) {
                        if ($i == $j->d) {
                            $arr[$i]['idout'] = $j->id;
                            $arr[$i]['picout'] = $j->pic;
                            $arr[$i]['dout'] = $j->d;
                            $arr[$i]['timeout'] = $j->timeout;
                            $arr[$i]['otherout'] = $j->otherout;
                        }
                    }
                }
            }
        }
        return response()->json($arr);
    }
}
