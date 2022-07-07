<?php

namespace App\Http\Controllers;

use App\Models\Enzebati;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class EnzebatiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Enzebati::orderBy('id', 'DESC')->get();

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
        $info = json_decode($request->info);
        $v = new Verta();
        foreach ($info as $inf) {
            $ch = Enzebati::where('student_id', $inf->value)->first();
            if ($ch === null) {
                $a = new Enzebati();
                $a->student_id = $inf->value;
                if (isset($inf->dalil)) {
                    $a->info = json_encode([['record_id' => uniqid(), 'name' => $inf->label, 'pos' => $inf->pos, 'dalil' => $inf->dalil, 'date' => $v->format('Y/m/d')]]);
                } else {
                    $a->info = json_encode([['record_id' => uniqid(), 'name' => $inf->label, 'pos' => $inf->pos, 'dalil' => null, 'date' => $v->format('Y/m/d')]]);
                }
                $a->save();
            // if($a->info)
            } else {
                $list = json_decode($ch->info);
                if (isset($inf->dalil)) {
                    array_push($list, ['record_id' => uniqid(), 'name' => $inf->label, 'pos' => $inf->pos, 'dalil' => $inf->dalil, 'date' => $v->format('Y/m/d')]);
                } else {
                    array_push($list, ['record_id' => uniqid(), 'name' => $inf->label, 'pos' => $inf->pos, 'dalil' => null, 'date' => $v->format('Y/m/d')]);
                }
                $ch->info = json_encode($list);
                $ch->save();
            }
        }
        if ($info) {
            return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Enzebati $enzebati)
    {
        $date = Carbon::now()->subDays(7);
        $a = Enzebati::where('updated_at', '>=', $date)->get();
        $weakly = [];
        foreach ($a as $enzbat) {
            foreach (json_decode($enzbat->info) as $record) {
                array_push($weakly, $record);
            }
        }

        return $weakly;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        strlen($id);
        $list = $request->list;
        foreach ($list as $rec) {
            $ch = Enzebati::where('id', $rec['id'])->first();
            $newlist = [];
            foreach (json_decode($ch->info) as $inf) {
                if ($rec['record_id'] !== $inf->record_id) {
                    array_push($newlist, $inf);
                }
            }
            $ch->info = json_encode($newlist);
            $ch->save();
        }
        if ($list) {
            return 1;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $record)
    {
        $ch = Enzebati::where('id', $id)->first();
        $list = [];
        foreach (json_decode($ch->info) as $inf) {
            if ($inf->record_id === $record) {
                // $inf->dalil = $request->dalil;
                // $ch->save();
                array_push($list, ['record_id' => $inf->record_id, 'name' => $inf->name, 'pos' => $inf->pos, 'dalil' => $request->dalil, 'date' => $inf->date]);
            } else {
                array_push($list, ['record_id' => $inf->record_id, 'name' => $inf->name, 'pos' => $inf->pos, 'dalil' => $inf->dalil, 'date' => $inf->date]);
            }
        }
        $ch->info = json_encode($list);
        $ch->save();
        if ($ch) {
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enzebati $enzebati)
    {
    }
}
