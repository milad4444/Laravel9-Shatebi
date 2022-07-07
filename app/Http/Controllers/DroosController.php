<?php

namespace App\Http\Controllers;

use App\Models\Droos;
use Illuminate\Http\Request;
use jDate\Jalali\jDate;

class DroosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $droos = Droos::all();
        foreach($droos as $dars){
            $dars->date = jDate::forge($dars->created_at)->format('date');
        }
        return $droos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $a = new Droos;
        $a->title = $request->title;
        $a->user_id = $request->user()->id;
        $a->save();
        if ($a) {
            return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Droos  $droos
     * @return \Illuminate\Http\Response
     */
    public function show(Droos $droos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Droos  $droos
     * @return \Illuminate\Http\Response
     */
    public function edit(Droos $droos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Droos  $droos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $a = Droos::where('id', $id)->first();
        $a->title = $request->title;
        $a->save();
        if($a){
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Droos  $droos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Droos::where('id', $id)->first();
        $a->delete();
        if($a){
            return 1;
        }
    }
}
