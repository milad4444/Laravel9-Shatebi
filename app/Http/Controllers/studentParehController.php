<?php

namespace App\Http\Controllers;

use App\Models\Nomreh;
use App\Models\Student;
use App\Models\Surah;
use Illuminate\Http\Request;

class studentParehController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $students;
        // return 'ok';
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
        $students = Student::where('status', 'در حال تحصیل')->orWhere('status', 'فارغ التحصیل')->get();
        // $classes = Classha::where('dars', 'حفظ')->where('info');

        foreach ($students as $student) {
            $lastNumber = null;
            $nomreh = Nomreh::where('classname', 'حفظ')->where('info', 'like', '%'.'"id":'.$student->id.'%')->get();

            foreach ($nomreh as $noms) {
                if ($lastNumber != null) {
                    if ($noms->info != null) {
                        foreach (json_decode($noms->info) as $nom) {
                            if ($nom->id == $student->id && property_exists($nom, 'jadidendsurah')) {
                                if ($noms->date > $lastNumber['date'] && $nom->jadidendsurah != null && $nom->jadidendsurah->label != null && $nom->jadidendayeh != null && $nom->jadidendayeh->value != null) {
                                    $lastNumber = ['nomreh' => $nom, 'date' => $noms->date];
                                }
                            }
                        }
                    }
                } else {
                    if ($noms->info != null) {
                        foreach (json_decode($noms->info) as $nom) {
                            if ($nom->id == $student->id && property_exists($nom, 'jadidendsurah') && $nom->jadidendsurah != null && $nom->jadidendsurah->label != null && $nom->jadidendayeh != null && $nom->jadidendayeh->value != null) {
                                $lastNumber = ['nomreh' => $nom, 'date' => $noms->date];
                            }
                        }
                    }
                }
            }
            // $student->pareh = $lastNumber;
            if ($lastNumber != null) {
                $pareh = null;
                $surah = Surah::where('index', $lastNumber['nomreh']->jadidendsurah->value)->first();
                foreach (json_decode($surah->juz) as $juz) {
                    $start = explode('_', $juz->verse->start);
                    $end = explode('_', $juz->verse->end);
                    if ($lastNumber['nomreh']->jadidendayeh->value * 1 >= $start[1] * 1 && $lastNumber['nomreh']->jadidendayeh->value * 1 <= $end[1] * 1) {
                        $pareh = $juz;
                    }
                }

                // return json_encode($pareh);
                $updateStudent = Student::where('id', $student->id)->first();
                $updateStudent->juz = $pareh->index;
                $updateStudent->save();
            }
        }

        $a = Student::where('juz', '!=', null)->where('juz', '!=', 30)->where('ziafat', null)->orderBy('juz', 'desc')->get();

        return $a;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        if ($request->type === 'all') {
            $a = Student::where('juz', '!=', null)->where('juz', '!=', 30)->where('ziafat', null)->orderBy('juz', 'desc')->get();

            return $a;
        } elseif ($request->type == 15) {
            $a = Student::where('juz', '!=', null)->where('juz', '>=', 1)->where('juz', '<=', 5)->where('ziafat', null)->orderBy('juz', 'desc')->get();

            return $a;
        } elseif ($request->type == 610) {
            $a = Student::where('juz', '!=', null)->where('juz', '>=', 6)->where('juz', '<=', 10)->where('ziafat', null)->orderBy('juz', 'desc')->get();

            return $a;
        } elseif ($request->type == 1120) {
            $a = Student::where('juz', '!=', null)->where('juz', '>=', 11)->where('juz', '<=', 20)->where('ziafat', null)->orderBy('juz', 'desc')->get();

            return $a;
        } elseif ($request->type == 2129) {
            $a = Student::where('juz', '!=', null)->where('juz', '>=', 21)->where('juz', '<=', 29)->where('ziafat', null)->orderBy('juz', 'desc')->get();

            return $a;
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
