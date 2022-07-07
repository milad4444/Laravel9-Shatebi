<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Student;
use Illuminate\Http\Request;


class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Master::orderBy('fullname', 'asc')->get();
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
        $a = Student::where('id', $request->id)->first();
        $check = Master::where('mellicode', $a->Mellicode)->first();
        if ($check !== null) {
            $dars = json_decode($check->dars);
            foreach ($dars as $ds){
                if($ds->name === $request->dars){
                    return 3;
                }
            }
                array_push($dars, ["name" => $request->dars]);
            $check->dars = json_encode($dars);
            $check->save();
            if ($check) {
                return 1;
            }
        } else {
            $b = new Master;
            $da = array(["name" => $request->dars]);
            $b->user_id = $request->user()->id;
            $b->mellicode = $a->Mellicode;
            $b->fullname = $a->Fname . ' ' . $a->Lname;
            $b->aks = $a->Aks;
            $b->phone = $a->Phone;
            $b->dars = json_encode($da);
            $b->save();
            if ($b) {
                return 1;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Master $master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Master $master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Master::where('id', $id)->first();
        $a->delete();
        if($a){
            return 1;
        }
    }
}
