<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Classha;
use App\Models\Master;
use App\Models\Student;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (stristr($request->user()->email, '1') || stristr($request->user()->email, '2')) {
            $a = Alert::where('users', '!=', null)->get();
            $aa = [];
            $max = 0;
            $max2 = 0;
            $maxname = null;
            $max2name = null;
            // find max date
            foreach ($a as $al) {
                $datedate = Verta::instance($al->created_at)->format('Y-m-d');
                if ($datedate > $max) {
                    $max = $datedate;
                    $maxname = $al->date;
                }
            }

            // find max2 date
            foreach ($a as $al) {
                $datedate = Verta::instance($al->created_at)->format('Y-m-d');
                if ($datedate < $max && $datedate > $max2 && $al->date !== $maxname) {
                    $max2 = $datedate;
                    $max2name = $al->date;
                }
            }

            // array two maxs date alerts
            foreach ($a as $al) {
                $ch = 0;
                foreach (json_decode($al->users) as $us) {
                    if (($us->id * 1) == $request->user()->id) {
                        $ch = 1;
                    }
                }
                if ($ch == 1 && $al->date === $maxname) {
                    array_push($aa, $al);
                }
            }

            foreach ($a as $al) {
                $ch = 0;
                foreach (json_decode($al->users) as $us) {
                    if (($us->id * 1) == $request->user()->id) {
                        $ch = 1;
                    }
                }
                if ($ch == 1 && $al->date === $max2name) {
                    array_push($aa, $al);
                }
            }

            foreach ($aa as $alert) {
                $alert->masterInfo = Master::where('mellicode', $alert->master)->first();
                $alert->classInfo = Classha::where('id', $alert->class)->first();
                $absents = [];
                if ($alert->absents !== null) {
                    foreach (json_decode($alert->absents) as $absent) {
                        array_push($absents, Student::where('id', $absent)->first());
                    }
                }
                $alert->absentsInfo = $absents;
            }

            return $aa;
        } elseif (stristr($request->user()->email, '3')) {
            $b = Alert::where('master', $request->user()->username)->where('status', '1')->get();
            $bb = [];
            $max = 0;
            $max2 = 0;
            $maxname = null;
            $max2name = null;
            // find max date
            foreach ($b as $al) {
                $datedate = Verta::instance($al->created_at)->format('Y-m-d');
                if ($datedate > $max) {
                    $max = $datedate;
                    $maxname = $al->date;
                }
            }

            // find max2 date
            foreach ($b as $al) {
                $datedate = Verta::instance($al->created_at)->format('Y-m-d');
                if ($datedate < $max && $datedate > $max2 && $al->date !== $maxname) {
                    $max2 = $datedate;
                    $max2name = $al->date;
                }
            }

            // array two maxs date alerts
            foreach ($b as $al) {
                $ch = 0;
                foreach (json_decode($al->users) as $us) {
                    if ($us->id == $request->user()->id) {
                        $ch = 1;
                    }
                }
                if ($ch == 1 && $al->date === $maxname) {
                    array_push($bb, $al);
                }
            }

            foreach ($b as $al) {
                $ch = 0;
                foreach (json_decode($al->users) as $us) {
                    if ($us->id == $request->user()->id) {
                        $ch = 1;
                    }
                }
                if ($ch == 1 && $al->date === $max2name) {
                    array_push($bb, $al);
                }
            }
            foreach ($bb as $alert) {
                $alert->masterInfo = Master::where('mellicode', $alert->master)->first();
                $alert->classInfo = Classha::where('id', $alert->class)->first();
                $absents = [];
                if ($alert->absents !== null) {
                    foreach (json_decode($alert->absents) as $absent) {
                        array_push($absents, Student::where('id', $absent)->first());
                    }
                }
                $alert->absentsInfo = $absents;
            }

            return $bb;
        }
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
        $a = Alert::where('class', $request->class)->where('date', $request->date)->get();
        if (count($a) === 0 && !$request->status) {
            $b = new Alert();
            $b->master = $request->master;
            $b->class = $request->class;
            $b->info = $request->info;
            if (strlen($request->absents) > 2) {
                $b->absents = $request->absents;
            }
            $b->date = $request->date;
            $b->status = '1';
            $allusers = [];
            $users = User::where('email', '1')->orWhere('email', 'like', '%'.'2'.'%')->get();
            foreach ($users as $us) {
                array_push($allusers, $us);
            }
            $user3 = User::where('email', 'like', '%'.'3'.'%')->where('username', $request->master)->first();
            if ($user3 !== null) {
                array_push($allusers, $user3);
            }
            $b->users = json_encode($allusers);

            $b->save();
            if ($b) {
                return 1;
            }
        } elseif (count($a) === 0 && $request->status) {
            return 1;
        } elseif (count($a) !== 0 && !$request->status) {
            $c = Alert::where('class', $request->class)->where('date', $request->date)->first();
            $c->info = $request->info;
            if (strlen($request->absents) > 2) {
                $c->absents = $request->absents;
            }
            $c->save();
            if ($c) {
                return 1;
            }
        } elseif (count($a) !== 0 && $request->status) {
            $d = Alert::where('class', $request->class)->where('date', $request->date)->first();
            $d->status = $request->status;
            if (strlen($request->absents) > 2) {
                $d->absents = $request->absents;
            }
            $d->save();
            if ($d) {
                return 1;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert, $id)
    {
        $a = Alert::all();

        foreach ($a as $al) {
            $b = [];
            if ($al->users !== null) {
                foreach (json_decode($al->users) as $us) {
                    if ($us->id * 1 !== $id * 1) {
                        array_push($b, $us);
                    }
                }
            }
            $c = Alert::where('id', $al->id)->first();
            $c->users = json_encode($b);
            $c->save();
        }
        // $a = User::where('id', 29)->first();
        // $a->password = Hash::make('9458');
        if ($a) {
            return 'ok';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $a = Alert::where('id', $id)->first();
        $users = json_decode($a->users);
        $setusers = [];
        foreach ($users as $user) {
            if ($request->user()->id !== $user->id) {
                array_push($setusers, $user);
            }
        }
        $a->users = json_encode($setusers);
        $a->save();
        if ($a) {
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
