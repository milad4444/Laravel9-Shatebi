<?php

namespace App\Http\Controllers;

use App\Models\Nomreh;
use Illuminate\Http\Request;

class AbsentofclassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $a = Nomreh::where('classha_id', $id)->where('persiandate', $request->date)->first();
        if (strlen($a) > 0) {
            $a->absents = json_encode($request->absents);
            $a->save();
            if ($a) {
                return 1;
            }
        } else {
            $b = new Nomreh();
            $b->user_id = $request->user()->id;
            $b->classha_id = $id;
            $b->classname = $request->dars;
            $b->mastername = $request->master;
            $b->mellicode = $request->master;
            $b->status = '1';
            $b->absents = json_encode($request->absents);
            $b->persiandate = $request->date;
            $b->date = $request->now;
            $b->save();
            if ($b) {
                return 1;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
