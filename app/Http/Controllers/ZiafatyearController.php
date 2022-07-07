<?php

namespace App\Http\Controllers;

use App\Models\ziafatyear;
use Illuminate\Http\Request;

class ZiafatyearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = ziafatyear::orderBy('year', 'desc')->get();
        foreach ($a as $new) {
            $new->date = Verta()->format('Y/m/d');
        }

        return $a;
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
        $newYear = new ziafatyear();
        $newYear->year = $request->year;
        $newYear->save();

        return $newYear;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ziafatyear $ziafatyear)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ziafatyear $ziafatyear)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ziafatyear $ziafatyear)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = ziafatyear::where('id', $id)->first();
        $a->delete();

        return $a;
    }
}
