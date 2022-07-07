<?php

namespace App\Http\Controllers;

use App\Models\Hafezkol;
use App\Models\Student;
use Illuminate\Http\Request;

class HafezkolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hafezkols = Hafezkol::orderBy('id', 'asc')->get();
        foreach($hafezkols as $hafezkol) {
            $hafezkol->info = Student::where('id', $hafezkol->student_id)->first(['id','Fname', 'Lname', 'Aks']);
        }
        return $hafezkols;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function students()
    {
        return Student::orderBy('id', 'asc')->get(['id','Fname', 'Lname', 'FatherName']);
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
        foreach(json_decode($request->students) as $student) {
            $new_hafez_kol = new Hafezkol();
            $new_hafez_kol->student_id = $student;
            $new_hafez_kol->save();
        }
        $hafezkols = Hafezkol::orderBy('id', 'asc')->get();
        foreach($hafezkols as $hafezkol) {
            $hafezkol->info = Student::where('id', $hafezkol->student_id)->first(['id','Fname', 'Lname', 'Aks']);
        }
        return $hafezkols;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hafezkol  $hafezkol
     * @return \Illuminate\Http\Response
     */
    public function show(Hafezkol $hafezkol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hafezkol  $hafezkol
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $hafezkols = json_decode($request->ids);
        $editedHafezkol = [];
        foreach($hafezkols as $hafezkol) {
            $hafezkolRecord = Hafezkol::find($hafezkol);
            $hafezkolRecord->ziafat = $request->ziafat;
            $hafezkolRecord->ziafat_year = $request->ziafat_year;
            $hafezkolRecord->activity_id = $request->activities;
            $hafezkolRecord->save();
            array_push($editedHafezkol, $hafezkolRecord);
        }
        foreach($editedHafezkol as $hafezkol) {
            $hafezkol->info = Student::where('id', $hafezkol->student_id)->first(['id','Fname', 'Lname', 'Aks']);
        }
        return $editedHafezkol;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hafezkol  $hafezkol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hafezkol $hafezkol)
    {
        $validated = $request->validate([
            'ziafat' => 'required|integer|max:1',
        ]);
        $hafezkol->ziafat = $validated['ziafat'];
        $hafezkol->save();
        return $hafezkol;
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hafezkol  $hafezkol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = json_decode($request->ids);
        foreach($ids as $st) {
            $hafezkol = Hafezkol::find($st);
            if($hafezkol) {
                $hafezkol->delete();
            }

        }
        return $ids;
    }
}
