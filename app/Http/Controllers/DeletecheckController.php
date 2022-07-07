<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Nomreh;
use App\Models\Student;
use Illuminate\Http\Request;

class DeletecheckController extends Controller
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
        $id = $request->id;
        $type = $request->type;
        if ($type === 'check') {
            $user = Student::where('id', $id)->first();
            $master = Master::where('mellicode', $user->Mellicode)->first();
            $nomreh = [];
            $nomrehreponse = [];
            $nomrehs = Nomreh::all();
            foreach ($nomrehs as $nom) {
                if ($nom->info != null) {

                    foreach (json_decode($nom->info) as $st) {
                        if ($st->id * 1 === $id * 1) {
                            array_push($nomreh, ['class' => $nom->classname]);
                        }
                    }
                }
            }
            foreach ($nomreh as $no) {
                if (count($nomrehreponse) === 0) {
                    array_push($nomrehreponse, ['class' => $no['class'], 'mach' => 1]);
                } else {
                    $ch = 0;
                    foreach ($nomrehreponse as $noms) {
                        if ($noms['class'] === $no['class']) {
                            $ch = 1;
                        }
                    }
                    if ($ch === 0) {
                        array_push($nomrehreponse, ['class' => $no['class'], 'mach' => 1]);
                    }
                }
            }

            return ['master' => $master, 'nomreh' => $nomrehreponse];
        } else {
            $a = Student::where('id', $id)->delete();
            if ($a) {
                return 1;
            }
        }
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
