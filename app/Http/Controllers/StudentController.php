<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = Student::orderBy('Lname', 'asc')->get();

        return $a;
        // $a = Old::all();
        // $zz = array();
        // foreach ($a as $old) {
        //     $much = 1;

        //     $b = new Student;
        //     $b->Fname = $old->name;
        //     $b->Lname = $old->family_name;
        //     $b->Aks = $old->avatar_url;
        //     $b->Mellicode = $old->shenasnameh_code;
        //     $b->Birthplace = $old->mahalle_tavallod;
        //     $b->Phone = $old->mobile;
        //     $b->TelPhone = $old->phone;
        //     $b->ParentPhone = $old->father_mobile;
        //     $b->FatherName = $old->father_name;
        //     $b->FatherJob = $old->father_job;
        //     $b->Birthday = $old->birth_day;
        //     $b->Educating = $old->degree_of_education;
        //     if ($old->entry_date !== null) {
        //         $c = preg_match_all('!\d+!', $old->entry_date, $matches);
        //         foreach ($zz as $sal) {
        //             if ($sal["sal"] == $matches[0][0][2] . $matches[0][0][3]) {
        //                 $much++;
        //             }
        //         }
        //         if ($much == 1) {
        //             // echo json_encode($matches[0][0][2] . $matches[0][0][3] . '0' . $matches[0][1] . '001') . 'id:'.$old->id;
        //             $b->StudentCode = $matches[0][0][2] . $matches[0][0][3] . '0' . $matches[0][1] . '001';
        //         } else {
        //             // echo json_encode($matches[0][0][2] . $matches[0][0][3] . '0' . $matches[0][1] . '000' + $much) . '<br>';
        //             $b->StudentCode = $matches[0][0][2] . $matches[0][0][3] . '0' . $matches[0][1] . '000' + $much;
        //         }
        //         array_push($zz, ["sal" => $matches[0][0][2] . $matches[0][0][3]]);
        //     } else {
        //         $b->StudentCode = 0;
        //     }
        //     $b->Referer = $old->referrer;
        //     $b->EconomicStatus = $old->economic_status;
        //     $b->status = $old->education_status;
        //     $b->Health = $old->disease;
        //     $b->Ostan = $old->province;
        //     $b->City = $old->city_village;
        //     $b->Vilage = $old->village;
        //     $b->Adress = $old->address;
        //     $b->Description = $old->description;
        //     $b->Entryday = $old->entry_date;
        //     $b->save();
        // }
        // if ($a){
        //     return 'waooo';
        // }
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
        $a = Student::all();
        $ch = 0;
        $bodan = 0;
        foreach ($a as $st) {
            if ($st->Entryday == $request->entrydate) {
                ++$ch;
            }
            if ($st->Mellicode == $request->mellicode) {
                $bodan = 1;
            }
        }
        if ($bodan === 0) {
            $c = preg_match_all('!\d+!', $request->entrydate, $matches);
            $stcode = 0;
            if ($ch === 0) {
                if( $matches[0][0][2] !== '0') {
                    $stcode = $matches[0][0][2].$matches[0][0][3].'0'.$matches[0][1].'001';
                } else {
                    $stcode = $matches[0][0][1].$matches[0][0][2].$matches[0][0][3].'0'.$matches[0][1].'001';
                }
            } else {
                if( $matches[0][0][2] !== '0') {
                    $stcode = ($matches[0][0][2].$matches[0][0][3].'0'.$matches[0][1].'000') + ($ch);
                } else {
                    $stcode = ($matches[0][0][1].$matches[0][0][2].$matches[0][0][3].'0'.$matches[0][1].'000') + ($ch);
                }
            }
            $image = $request->aks;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = $stcode.uniqid().'.'.'jpeg';

            \File::put(public_path('storage/shatebi/uploads/avatars').'/'.$imageName, base64_decode($image));

            // return $imageName;
            $newst = new Student();
            $newst->Fname = $request->fname;
            $newst->Lname = $request->lname;
            if ($request->aks !== null) {
                $newst->Aks = '/shatebi/uploads/avatars/'.$imageName;
            } else {
                $newst->Aks = '';
            }
            $newst->FatherName = $request->faname;
            $newst->Mellicode = $request->mellicode;
            $newst->Birthday = $request->birthdate;
            $newst->Birthplace = $request->birthplace;
            $newst->Entryday = $request->entrydate;
            $newst->FatherJob = $request->fajob;
            $newst->Phone = $request->phone;
            $newst->TelPhone = $request->tel;
            $newst->ParentPhone = $request->paphone;
            $newst->Ostan = $request->ostan;
            $newst->City = $request->city;
            $newst->Vilage = $request->village;
            $newst->Adress = $request->adress;
            $newst->Educating = $request->educ;
            $newst->StudentCode = $stcode;
            $newst->Referer = $request->referrer;
            $newst->EconomicStatus = $request->economic;
            $newst->Status = $request->status;
            $newst->course = $request->course;
            $newst->Health = $request->health;
            $newst->Description = $request->explain;
            $newst->save();
            if ($newst) {
                return 1;
            }
        } else {
            return 2;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, $id)
    {
        $url = 'https://ippanel.com/services.jspd';

        $rcpt_nm = ['09'];
        $param = [
                        'uname' => 'shatebi',
                        'pass' => '300500mashreqi',
                        'from' => '9810009117300500',
                        'message' => 'تست',
                        'to' => json_encode($rcpt_nm),
                        'op' => 'send',
                    ];

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($handler);

        $response2 = json_decode($response2);
        $res_code = $response2[0];
        $res_data = $response2[1];

        echo $res_data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Student::where('id', $id)->first();
        $image = $request->aks;
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $update->StudentCode.uniqid().'new.'.'jpeg';

        if (strlen($request->aks) > 0) {
            if (strlen($update->Aks) > 0) {
                \File::delete(storage_path('app/public').$update->Aks);
                \File::put(public_path('storage/shatebi/uploads/avatars').'/'.$imageName, base64_decode($image));
                $update->Aks = '/shatebi/uploads/avatars/'.$imageName;
            } else {
                \File::put(public_path('storage/shatebi/uploads/avatars').'/'.$imageName, base64_decode($image));
                $update->Aks = '/shatebi/uploads/avatars/'.$imageName;
            }
        }
        // else {
        //     if (strlen($update->Aks) > 0) {
        //         $update->Aks = $request->aks;
        //     } else {
        //         $update->Aks = '';
        //     }
        // }
        $update->Fname = $request->fname;
        $update->Lname = $request->lname;
        $update->FatherName = $request->faname;
        $update->Mellicode = $request->mellicode;
        $update->Birthday = $request->birthdate;
        $update->Birthplace = $request->birthplace;
        $update->Entryday = $request->entrydate;
        $update->FatherJob = $request->fajob;
        $update->Phone = $request->phone;
        $update->TelPhone = $request->tel;
        $update->ParentPhone = $request->paphone;
        $update->Ostan = $request->ostan;
        $update->City = $request->city;
        $update->Vilage = $request->village;
        $update->Adress = $request->adress;
        $update->Educating = $request->educ;
        $update->Referer = $request->referrer;
        $update->EconomicStatus = $request->economic;
        $update->Status = $request->status;
        $update->course = $request->course;
        $update->Health = $request->health;
        $update->Description = $request->explain;
        $update->endDate = $request->endDate;
        $update->save();
        if ($update) {
            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
    }
}
