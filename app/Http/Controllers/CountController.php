<?php

namespace App\Http\Controllers;

use App\Models\Absent;
use App\Models\Classha;
use App\Models\Enzebati;
use App\Models\Master;
use App\Models\Morakhasi;
use App\Models\Nomreh;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = Master::all();
        $d = Classha::all();
        $a = Student::where('course', 'حفظ شبانه روزی')->where('status', 'در حال تحصیل')->get();
        $aok = [];
        // تعدادحفظ شبانه روزی
        foreach ($a as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value === $aa->id) {
                        if (count($aok) === 0) {
                            array_push($aok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($aok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($aok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a1 = Student::where('course', 'حفظ روزانه')->where('status', 'در حال تحصیل')->get();
        $a1ok = [];
        // تعدادحفظ روزانه
        foreach ($a1 as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        // array_push($a1ok, $aa);
                        if (count($a1ok) === 0) {
                            array_push($a1ok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($a1ok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($a1ok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a2 = Student::where('course', 'مهد حفظ قرآن')->where('status', 'در حال تحصیل')->get();
        $a2ok = [];
        // تعداد  مهد حفظ قرآن
        foreach ($a2 as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        // array_push($a2ok, $aa);
                        if (count($a2ok) === 0) {
                            array_push($a2ok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($a2ok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($a2ok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a3 = Student::where('course', 'کلاس های روخوانی')->where('status', 'در حال تحصیل')->get();
        $a3ok = [];
        // تعداد    کلاس های روخوانی
        foreach ($a3 as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        // array_push($a3ok, $aa);
                        if (count($a3ok) === 0) {
                            array_push($a3ok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($a3ok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($a3ok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a4 = Student::where('course', 'کلاس های صوت و لحن')->where('status', 'در حال تحصیل')->get();
        $a4ok = [];
        // تعداد    کلاس های صوت و لحن
        foreach ($a4 as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        // array_push($a4ok, $aa);
                        if (count($a4ok) === 0) {
                            array_push($a4ok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($a4ok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($a4ok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a5 = Student::where('course', 'کلاس حفظ مجازی')->where('status', 'در حال تحصیل')->get();
        $a5ok = [];
        // تعداد    کلاس های حفظ مجازیه
        foreach ($a5 as $aa) {
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        // array_push($a5ok, $aa);
                        if (count($a5ok) === 0) {
                            array_push($a5ok, $aa);
                        } else {
                            $ch = 0;
                            foreach ($a5ok as $check) {
                                if ($check->id === $aa->id) {
                                    $ch = 1;
                                }
                            }
                            if ($ch === 0) {
                                array_push($a5ok, $aa);
                            }
                        }
                    }
                }
            }
        }
        $a6 = Student::where('status', 'در حال تحصیل')->get();
        $a6ok = [];
        // تعداد      بدون مربی ها
        foreach ($a6 as $aa) {
            $tess = 0;
            foreach ($d as $da) {
                foreach (json_decode($da->info) as $in) {
                    if ($in->value == $aa->id) {
                        $tess = 1;
                    }
                }
            }
            if ($tess == 0) {
                array_push($a6ok, $aa);
            }
        }
        $b = Student::where('status', 'فارغ التحصیل')->get();

        return ['a' => count($aok),
        'a1' => count($a1ok),
        'a2' => count($a2ok),
        'a3' => count($a3ok),
        'a4' => count($a4ok),
        'a5' => count($a5ok),
        'a6' => count($a6ok),
         'b' => count($b), 'c' => count($c),
        'comp' => $aok, ];
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
    public function show(Request $request, $id)
    {
        $course = $id === 'shabaneh' ? 'حفظ شبانه روزی' : ( $id === 'rozaneh' ? 'حفظ روزانه' : 'مهد حفظ قرآن');
        $b = [];
        $a = Nomreh::where('classname', 'احکام (طهارت و نماز)')->orWhere('classname', 'صوت و لحن (نغمات ترتیل)')->orWhere('classname', 'تجوید')
        ->get();
        foreach($a as $nomreh) {
            foreach(json_decode($nomreh->info) as $student) {
                array_push($b, $student->id);
            }
        }
        $classha = Classha::all();
        $students_have_class = [];
        foreach($classha as $class) {
            foreach(json_decode($class->info) as $student) {
                array_push($students_have_class, $student->value);
            }
        }
        $no_dorehs = Student::where('course', $course)->where('status', 'در حال تحصیل')->whereNotIn('id', $b)->count();
        $students_with_class = Student::where('course', $course)->where('status', 'در حال تحصیل')->whereIn('id', $students_have_class)->count();
        $students_without_class = Student::where('course', $course)->where('status', 'در حال تحصیل')->whereNotIn('id', $students_have_class)->count();
        $students_id = Student::where('course', $course)->where('status', 'در حال تحصیل')->pluck('id');
        $morakhasi = Morakhasi::orderBy('id', 'DESC')->where('status', '2')->count();
        $date = Carbon::now()->subDays(7);
        $enzebati = Enzebati::where('updated_at', '>=', $date)->whereIn('student_id', $students_id)->count();
        $ziafat = Student::where('ziafat', 1)->orWhere('ziafat', 2)->count();
        $searchDay = 'Friday';
        $searchDate = new Carbon(); //or whatever Carbon instance you're using
        $lastFriday = Carbon::createFromTimeStamp(strtotime("last $searchDay", $searchDate->timestamp));
        $hozor_weakly = Absent::where('created_at', '>=', $lastFriday)->first();
        if($hozor_weakly) {

            $weakly_hozor = Student::where('status', 'در حال تحصیل')->whereIn('id', json_decode($hozor_weakly->absents))->count();
        } else {
            $weakly_hozor = 0;
        }

        return [
            'students' => $students_with_class,
            'without_class' => $students_without_class,
            'no_dorehs' => $no_dorehs,
            'morakhasi' => $morakhasi,
            'enzebati' => $enzebati,
            'ziafat' => $ziafat,
            'weakly_hozor' => $weakly_hozor,
        ];

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
