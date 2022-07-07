<?php

namespace App\Http\Controllers;

use App\Models\Nomreh;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class importantClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::where('status', 'در حال تحصیل')->where('juz', '!=', null)->get();
        $noDorehs = [];
        foreach ($students as $student) {
            $id = 'id:'.$student->id;
            $ahkam_status = Nomreh::where('classname', 'احکام (طهارت و نماز)')->where('info', 'like', '%'.$id.'%')->first();
            $sout_status =  Nomreh::where('classname', 'صوت و لحن (نغمات ترتیل)')->where('info', 'like', '%'.$id.'%')->first();
            $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
            $student->sout = $sout_status;
            $student->tajvid = $tajvid_status;
            if ($ahkam_status == null || $sout_status == null || $tajvid_status == null) {
                array_push($noDorehs, $student);
            }
        }

        return count($noDorehs);
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
        $students = Student::where('status', 'در حال تحصیل')->where('course', 'حفظ شبانه روزی')->orderBy('juz', 'DESC')->paginate(21);
        $noDorehs = [];
        foreach ($students as $student) {
            $id = '"id":'.$student->id;
            $ahkam_status = Nomreh::where('classname', 'like', '%'.'احکام'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $sout_status = Nomreh::where('classname', 'like', '%'.'صوت و لحن'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
            $student->sout = $sout_status;
            $student->tajvid = $tajvid_status;
            if (!$ahkam_status || !$sout_status || !$tajvid_status) {
                array_push($noDorehs, $student);
            }
        }

        return $students;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter_nodorehs(Request $request, $name)
    {
        $students = Student::whereRaw("concat(fname, ' ', lname) like '%" .$name. "%' ")->where('status', 'در حال تحصیل')->where('course', 'حفظ شبانه روزی')->orderBy('juz', 'DESC')->paginate(21);
        $noDorehs = [];
        foreach ($students as $student) {
            $id = '"id":'.$student->id;
            $ahkam_status = Nomreh::where('classname', 'like', '%'.'احکام'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $sout_status = Nomreh::where('classname', 'like', '%'.'صوت و لحن'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
            $student->sout = $sout_status;
            $student->tajvid = $tajvid_status;
            if (!$ahkam_status || !$sout_status || !$tajvid_status) {
                array_push($noDorehs, $student);
            }
        }

        return $students;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter_nodorehs_doreh(Request $request)
    {
        $students = Student::where('status', 'در حال تحصیل')->where('course', 'حفظ شبانه روزی')->orderBy('juz', 'DESC')->get();
        $noDorehs = [];
        foreach ($students as $student) {
            $id = '"id":'.$student->id;
            $ahkam_contains = Str::contains($request->doreh, 'احکام');
            $sout_contains = Str::contains($request->doreh, 'صوت و لحن');
            $tajvid_contains = Str::contains($request->doreh, 'تجوید');
            if($ahkam_contains) {
                $ahkam_status = Nomreh::where('classname', 'like', '%'.'احکام'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
            if(!$ahkam_status) {
                array_push($noDorehs, $student->id);
            }
            }
            if($sout_contains) {
                $sout_status = Nomreh::where('classname', 'like', '%'.'صوت و لحن'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $student->sout = $sout_status;
            if(!$sout_status) {
                array_push($noDorehs, $student->id);
            }
            }
            if($tajvid_contains) {
                $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->tajvid = $tajvid_status;
            if(!$tajvid_status) {
                array_push($noDorehs, $student->id);
            }
        }
        if(!$ahkam_contains && !$sout_contains && !$tajvid_contains) {
            $ahkam_status = Nomreh::where('classname', 'like', '%'.'احکام'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $sout_status = Nomreh::where('classname', 'like', '%'.'صوت و لحن'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
        $student->sout = $sout_status;
        $student->tajvid = $tajvid_status;
        if (!$ahkam_status || !$sout_status || !$tajvid_status) {
            array_push($noDorehs, $student->id);
        }
        }

        }
        $result_students = Student::where('status', 'در حال تحصیل')->where('course', 'حفظ شبانه روزی')->whereIn('id', $noDorehs )->orderBy('juz', 'DESC')->paginate(21);
        foreach ($result_students as $student) {
            $id = '"id":'.$student->id;
            $ahkam_status = Nomreh::where('classname', 'like', '%'.'احکام'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $sout_status = Nomreh::where('classname', 'like', '%'.'صوت و لحن'.'%')->where('info', 'like', '%'.$id.'%')->first();
            $tajvid_status = Nomreh::where('classname', 'تجوید')->where('info', 'like', '%'.$id.'%')->first();
            $student->ahkam = $ahkam_status;
            $student->sout = $sout_status;
            $student->tajvid = $tajvid_status;
        }

        return $result_students;
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
