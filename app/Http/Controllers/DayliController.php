<?php

namespace App\Http\Controllers;

use App\Models\Dayli;
use Carbon\Carbon;
use jDate\Jalali\jDate;
use Illuminate\Http\Request;

class DayliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $date = jDate::forge()->format('%A %d %B، %Y');
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dayli  $dayli
     * @return \Illuminate\Http\Response
     */
    public function show(Dayli $dayli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dayli  $dayli
     * @return \Illuminate\Http\Response
     */
    public function edit(Dayli $dayli)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dayli  $dayli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dayli $dayli)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dayli  $dayli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dayli $dayli)
    {
        //
    }
}
