<?php

namespace App\Http\Controllers;

use App\Models\Classha;
use Illuminate\Http\Request;

class ClasshaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Classha::all();
        return $a;
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
        $check = Classha::where('master_id', $request->master)->where('dars', $request->dars)->first();
        if ($check !== null) {
            return 2;
        } else {
            $a = new Classha;
            $a->user_id = $request->user()->id;
            $a->master_id = $request->master;
            $a->dars = $request->dars;
            $a->info = json_encode($request->info);
            $a->save();
            if ($a) {
                return 1;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classha  $classha
     * @return \Illuminate\Http\Response
     */
    public function show(Classha $classha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classha  $classha
     * @return \Illuminate\Http\Response
     */
    public function edit(Classha $classha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classha  $classha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $a = Classha::where('id', $id)->first();
        $a->master_id = $request->master;
            $a->dars = $request->dars;
            $a->info = json_encode($request->info);
            $a->save();
            if ($a) {
                return 1;
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classha  $classha
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Classha::where('id', $id)->first();
        $a->delete();
        if ($a) {
            return 1;
        }
    }
}
