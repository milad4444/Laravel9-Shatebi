<?php

namespace App\Http\Controllers;

use App\Models\Nomreh;
use App\Models\Student;
use App\Models\Surah;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use jDate\Jalali\jDate;

class NomrehController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Nomreh::all();
        $test = 0;
        $otherdates = [];
        $dates = '2002-05-06';
        $now = Carbon::now()->format('Y-m-d');
        foreach ($a as $da) {
            if ($da->date === $now && $test === 0) {
                $test = 1;
                array_push($otherdates, ['date' => Verta::instance($da->date)->format('Y/m/d'), 'persian' => jDate::forge($da->date)->format('%A %d %B، %Y')]);
            }
            if ($da->date !== $now && $da->date > $dates) {
                $dates = $da->date;
            }
        }
        array_push($otherdates, ['date' => Verta::instance($dates)->format('Y/m/d'), 'persian' => jDate::forge($dates)->format('%A %d %B، %Y')]);
        foreach ($a as $nom) {
            $nom->date1 = Verta::instance($nom->date)->format('Y/m/d');
            $nom->persian = jDate::forge($nom->date)->format('%A %d %B، %Y');
            $nom->others = $otherdates;
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
        $now = Carbon::now()->format('Y-m-d');
        $ch = Nomreh::where('mellicode', $request->master)->where('classha_id', $request->classid)->where('persiandate', $request->date)->first();
        if ($ch === null) {
            $a = new Nomreh();
            $a->user_id = $request->user()->id;
            $a->classha_id = $request->classid;
            $a->classname = $request->classname;
            $a->mastername = $request->master;
            $a->mellicode = $request->master;
            $a->info = $request->info;
            foreach (json_decode($request->info) as $nom) {
                if (property_exists($nom, 'jadidendsurah') && $nom->jadidendsurah->label != null && $nom->jadidendayeh->value != null) {
                    $surah = Surah::where('index', $nom->jadidendsurah->value)->first();
                    foreach (json_decode($surah->juz) as $juz) {
                        $start = explode('_', $juz->verse->start);
                        $end = explode('_', $juz->verse->end);
                        if ($nom->jadidendayeh->value * 1 >= $start[1] * 1 && $nom->jadidendayeh->value * 1 <= $end[1] * 1) {
                            $pareh = $juz;
                        }
                    }
                    $updateStudent = Student::where('id', $nom->id)->first();
                    $updateStudent->juz = $pareh->index;
                    $updateStudent->save();
                }
            }
            if ($request->now1 === null) {
                $a->date = $request->now;
            } else {
                $a->date = Verta::parse($request->now1)->formatGregorian('Y-m-d');
            }
            $a->persiandate = $request->date;
            $a->status = $request->status;
            $a->save();
            if ($a) {
                return 1;
            }
        } else {
            if ($ch->info !== null) {
                $zarff = json_decode($ch->info);
                $new = [];
                $chch = 0;
                foreach ($zarff as $in) {
                    if ($in->name === json_decode($request->info)[0]->name) {
                        $chch = 1;
                        array_push($new, json_decode($request->info)[0]);
                    } else {
                        array_push($new, $in);
                    }
                }
                if ($chch === 0) {
                    array_push($new, json_decode($request->info)[0]);
                }
                foreach (json_decode($request->info) as $nom) {
                    if (property_exists($nom, 'jadidendsurah') && $nom->jadidendsurah->label != null && $nom->jadidendayeh->value != null) {
                        $surah = Surah::where('index', $nom->jadidendsurah->value)->first();
                        foreach (json_decode($surah->juz) as $juz) {
                            $start = explode('_', $juz->verse->start);
                            $end = explode('_', $juz->verse->end);
                            if ($nom->jadidendayeh->value * 1 >= $start[1] * 1 && $nom->jadidendayeh->value * 1 <= $end[1] * 1) {
                                $pareh = $juz;
                            }
                        }
                        $updateStudent = Student::where('id', $nom->id)->first();
                        $updateStudent->juz = $pareh->index;
                        $updateStudent->save();
                    }
                }
                $ch->info = json_encode($new);
                $ch->save();
                if ($ch) {
                    return 1;
                }
            } else {
                foreach (json_decode($request->info) as $nom) {
                    if (property_exists($nom, 'jadidendsurah') && $nom->jadidendsurah->label != null && $nom->jadidendayeh->value != null) {
                        $surah = Surah::where('index', $nom->jadidendsurah->value)->first();
                        foreach (json_decode($surah->juz) as $juz) {
                            $start = explode('_', $juz->verse->start);
                            $end = explode('_', $juz->verse->end);
                            if ($nom->jadidendayeh->value * 1 >= $start[1] * 1 && $nom->jadidendayeh->value * 1 <= $end[1] * 1) {
                                $pareh = $juz;
                            }
                        }
                        $updateStudent = Student::where('id', $nom->id)->first();
                        $updateStudent->juz = $pareh->index;
                        $updateStudent->save();
                    }
                }
                $ch->info = $request->info;
                $ch->save();
                if ($ch) {
                    return 1;
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Nomreh $nomreh)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomreh $nomreh)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomreh $nomreh)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomreh $nomreh)
    {
    }
}
