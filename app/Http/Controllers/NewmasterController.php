<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;

class NewmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (strlen($request->aks) > 4) {
            $image = $request->aks;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $request->mellicode . '.' . 'jpeg';

            \File::put(public_path('storage/shatebi/uploads/masters') . '/' . $imageName, base64_decode($image));
        }
        $check = Master::where('mellicode', $request->mellicode)->first();
        if ($check !== null) {
            $dars = json_decode($check->dars);
            foreach ($dars as $ds) {
                if ($ds->name === $request->dars) {
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
            $a = new Master;
            $da = array(["name" => $request->dars]);
            $a->user_id = $request->user()->id;
            if (strlen($request->aks) > 4) {
                $a->aks = '/shatebi/uploads/masters/' . $imageName;
            } else {
                $a->aks = null;
            }
            $a->fullname = $request->name;
            $a->phone = $request->phone;
            $a->mellicode = $request->mellicode;
            $a->dars =  json_encode($da);
            $a->save();
            if ($a) {
                return 1;
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
