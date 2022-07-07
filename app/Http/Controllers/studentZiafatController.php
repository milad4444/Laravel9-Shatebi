<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class studentZiafatController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $now = Carbon::now()->format('Y-m-d');
        $a = Student::where('id', $request->id)->first();
        $a->ziafat = $request->ziafat;
        $a->save();
        if ($a) {
            return $a;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $date)
    {
        if ($date != 0) {
            $a = Student::where('ziafat', $id)->where('ziafatdate', $date)->orderBy('ziafatdate', 'desc')->get();

            return $a;
        } else {
            $a = Student::where('ziafat', $id)->where('ziafatdate', null)->orderBy('ziafatdate', 'desc')->get();

            return $a;
        }
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
        $a = Student::where('id', $id)->first();
        if ($request->ziafat != null) {
            if ($request->ziafat == 1) {
                $a->ziafat = 1;
                // $a->ziafatdate = Verta::now()->format('Y');
                // $a->status = 'فارغ التحصیل';
                $a->save();
                if ($a) {
                    return $a;
                }
            } else {
                $a->ziafat = 2;
                $a->ziafatdate = null;
                // $a->status = 'فارغ التحصیل';
                $a->save();
                if ($a) {
                    return $a;
                }
            }
        } else {
            $a->ziafat = null;
            $a->ziafatdate = null;
            $a->status = 'در حال تحصیل';
            $a->save();
            if ($a) {
                return $a;
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
