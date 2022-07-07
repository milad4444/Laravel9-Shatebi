<?php

namespace App\Http\Controllers;

use App\Models\Personallist;
use Illuminate\Http\Request;

class PersonallistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Personallist::all();
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
        $check = Personallist::where('title', $request->title)->first();
        if ($check !== null) {
            return 2;
        } else {
            $a = new Personallist();
            $a->title = $request->title;
            $a->info = $request->info;
            $a->save();
            if ($a) {
                return 1;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Personallist $personallist)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Personallist $personallist)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $new = $request->newlist;
        $milad = $id;
        $listname = $request->listname;
        $a = Personallist::where('title', $listname)->first();
        $a->info = $new;
        $a->save();
        if ($a) {
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personallist $personallist, $id)
    {
       $a = Personallist::where('title', $id)->delete();
       if($a){
           return 1;
       }
    }
}
