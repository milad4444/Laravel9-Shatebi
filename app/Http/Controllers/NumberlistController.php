<?php

namespace App\Http\Controllers;

use App\Models\Nomreh;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class NumberlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $a = Nomreh::all();
        foreach ($a as $all) {
            $v = verta($all->date);
            $all->persiandate = $v->format('Y/m/d');
        }

        return $a;
    }

    public function numbersByDate(Request $request) {
        $startDate = verta::parse($request->startDate)->formatGregorian('Y-m-d');
        $endDate = verta::parse($request->endDate)->formatGregorian('Y-m-d');
        $a = Nomreh::where('date', '>=', $startDate)->where('date', '<=', $endDate)->where('info','like', '%' . '"id":'.$request->student .'%')->get();
        foreach ($a as $all) {
            $v = verta($all->date);
            $all->persiandate = $v->format('Y/m/d');
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
