<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $masters = Master::all();
        // foreach($masters as $master) {
        //     $student = Student::where('Mellicode', $master->mellicode)->first();
        //     if($student) {

        //         $master->aks = $student->Aks;
        //         $master->save();
        //     }
        // }
        User::where('email', null)->update(['email' => 0]);
        return 'ok';
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
        $check = User::where('username', $request->us)->first();
        if ($check !== null) {
            return 2;
        } else {
            $a = new User();
            $a->username = $request->us;
            $a->password = Hash::make($request->pa);
            $a->fname = $request->fname;
            $a->lname = $request->lname;
            $a->phone = $request->phone;
            $a->email = '0';
            $a->save();
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
