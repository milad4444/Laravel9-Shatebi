<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now()->format('Y-m-d');

        // return $now->addDays(1)->format('Y-m-d');
        $a = Absent::where('date', '<=', $now)->latest('id')->first();

        // return Carbon::parse($a->date)->addDays(1)->format('Y-m-d');
        if (Carbon::parse($a->date)->addDays(6)->format('Y-m-d') > $now) {
            return $a;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');

        $b = Absent::where('date', '<=', $now)->latest('id')->first();
        if (Carbon::parse($b->date)->addDays(6)->format('Y-m-d') > $now) {
            $b->absents = json_encode($request->absents);
            $b->save();
            if ($b) {
                return '1';
            }
        } else {
            $a = new Absent();
            $a->absents = json_encode($request->absents);
            $a->date = Carbon::now()->format('Y-m-d');
            $a->save();
            if ($a) {
                return '1';
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Absent $absent)
    {
        $searchDay = 'Friday';
        $searchDate = new Carbon(); //or whatever Carbon instance you're using
        $lastFriday = Carbon::createFromTimeStamp(strtotime("last $searchDay", $searchDate->timestamp));

        $hozor_weakly = Absent::where('created_at', '>=', $lastFriday)->first();

        return $hozor_weakly;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Absent $absent)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absent $absent)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absent $absent)
    {
    }
}
