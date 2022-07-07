<?php

namespace App\Http\Controllers;

use App\Models\Dalil;
use Illuminate\Http\Request;

class DalilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Dalil::all();

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
        $a = new Dalil();
        $a->dalil = $request->dalil;
        $a->save();
        if ($a) {
            return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Dalil $dalil)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        strlen($id);
        $list = $request->list;
        foreach ($list as $li) {
            $ch = Dalil::where('id', $li['id'])->delete();
        }
        if ($list) {
            return 1;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $up)
    {
        strlen($up);
        $ch = Dalil::where('id', $id)->first();
        $ch->dalil = $request->dalil;
        $ch->save();
        if ($ch) {
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dalil $dalil)
    {
    }
}
