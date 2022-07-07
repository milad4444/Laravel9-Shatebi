<?php

namespace App\Http\Controllers;

use App\Models\Morakhasi;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class MorakhasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $a = null;
        $userMorakhasis = null;
        $allmorakhasis = null;
        $guardqueue = null;
        $guardReject = null;
        $guardExpired = null;
        if ($request->user()->email === 0) {
            $userMorakhasis = Morakhasi::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->paginate(20);
        } else {
            // in queue morakhasis
            $userMorakhasis = Morakhasi::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->paginate(20);
            $a = Morakhasi::where('status', 2)->orderBy('id', 'DESC')->get();
            $allmorakhasis = Morakhasi::orderBy('id', 'DESC')->paginate(20);

            // guard reject
            $guardReject = Morakhasi::where('status', 4)->orderBy('id', 'DESC')->paginate(20);

            // guard expired
            $guardExpired = Morakhasi::where('status', 3)->where('checked', 1)->orWhere('status', 5)->where('checked', 1)->orderBy('id', 'DESC')->paginate(20);

            //guard morakhasis queue
            $guardqueue = Morakhasi::where('status', '!=', 4)->where('checked', null)->orderBy('id', 'DESC')->get();
        }
        foreach ($a as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }

        foreach ($allmorakhasis as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }

        foreach ($guardqueue as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }

        foreach ($guardExpired as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }
        foreach ($guardReject as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }
        if ($userMorakhasis !== null) {
            foreach ($userMorakhasis as $mo) {
                $date = Carbon::parse($mo->created_at)->format('Y/m/d');
                $mo->subdate = Verta($date)->format('Y/m/d');
                $user = User::where('id', $mo->user_id)->first();
                $mo->user = $user;
                $student = Student::where('Mellicode', $user->username)->first();
                if ($student) {
                    $mo->image = $student->Aks;
                } else {
                    $mo->image = null;
                }
            }
        }

        // $nowtime = Verta()->formatTime();

        // return $nowtime;

        return ['userMorakhasis' => $userMorakhasis, 'queue' => $a, 'all' => $allmorakhasis, 'guardQueue' => $guardqueue, 'guardExpired' => $guardExpired, 'guardRejected' => $guardReject];
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
        $a = new Morakhasi();
        $a->user_id = $request->user()->id;
        $a->fullname = $request->user()->fname.' '.$request->user()->lname;
        $a->dalil = $request->dalil;
        $rcpt_nm = [];
        $masool = [];
        $timekam = false;
        if ($request->type === 'time') {
            $from_time_timestamp = verta::parse($request->dayli_date.' '.$request->fromtime)->formatGregorian('Y-m-d H:i:s');
            $to_time_timestamp = verta::parse($request->dayli_date.' '.$request->totime)->formatGregorian('Y-m-d H:i:s');
        } else {
            $from_time_timestamp = verta::parse($request->fromdate.' '.$request->fromtime)->formatGregorian('Y-m-d H:i:s');
            $to_time_timestamp = verta::parse($request->todate.' '.$request->totime)->formatGregorian('Y-m-d H:i:s');
        }

        if ($to_time_timestamp > $from_time_timestamp) {
            $diffMinutes = verta($from_time_timestamp)->diffMinutes(verta($to_time_timestamp));
            if ($diffMinutes <= 180) {
                $timekam = true;
            }
        }


            if ($timekam === false) {
                $rcpt_nm = ['09117300500'];
            } else {
                $rcpt_nm = ['09117290070'];
            }


        if ($request->type === 'time') {
            $dayli_date = verta::parse($request->dayli_date)->formatGregorian('Y-m-d H:i:s');
            $matn = ' برای تاریخ '.$request->dayli_date.' از ساعت : '.$request->fromtime.' لغایت ساعت : '.$request->totime;
            // $kam = Verta($request->fromtime)->diffMinutes(Verta($request->totime));
            $a->fromtime_1 = $from_time_timestamp;
            $a->totime_1 = $to_time_timestamp;
            $a->dayli_date = $dayli_date;
            $a->datetime = $matn;
            $b = User::where('id', $request->user()->id)->first();
            $user = $b->fname.' '.$b->lname;
            $url = 'https://ippanel.com/services.jspd';
            $param = [
                'uname' => 'shatebi',
                'pass' => '300500mashreqi',
                'from' => '+9810009117300500',
                'message' => 'قرآن آموز'.' '.$user.' '.$matn.' '.'در خواست مرخصی دارند',
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
            $a->type = 1;
        // echo $res_data;
        } elseif ($request->type === 'datetime') {
            $matn = ' از تاریخ '.$request->fromdate.'  ساعت : '.$request->fromtime.' لغایت تاریخ '.$request->todate.' ساعت : '.$request->totime;
            // $kam = Verta($request->todate)->diffDays(Verta($request->fromdate));
            $a->fromdate = verta::parse($request->fromdate)->formatGregorian('Y-m-d H:i:s');
            $a->fromtime_2 = $from_time_timestamp;
            $a->todate = verta::parse($request->todate)->formatGregorian('Y-m-d H:i:s');
            $a->totime_2 = $to_time_timestamp;
            $a->datetime = $matn;
            $b = User::where('id', $request->user()->id)->first();
            $user = $b->fname.' '.$b->lname;
            $url = 'https://ippanel.com/services.jspd';
            $param = [
                'uname' => 'shatebi',
                'pass' => '300500mashreqi',
                'from' => '+9810009117300500',
                'message' => 'قرآن آموز'.' '.$user.' '.$matn.' '.'در خواست مرخصی دارند',
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
            // echo $res_data;
            $a->type = 2;
        }
        $a->status = 2;
        $a->save();

        if ($a) {
            // $message = ['label' => 'new', 'value' => 'getinfo'];
            // event(new \App\Events\SendResopnse($message));
            return $a;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $text)
    {
        // $a = Morakhasi::all();
        // foreach ($a as $mo) {
        //     $user = User::where('id', $mo->user_id)->first();
        //     $update = Morakhasi::where('id', $mo->id)->first();
        //     $update->fullname = $user->fname . ' ' . $user->lname;
        //     $update->save();
        // }
        // return 'ok';

        // all morakhasis
        $all = Morakhasi::where('fullname', 'LIKE', '%'.$request->text.'%')->orWhere('dalil', 'LIKE', '%'.$request->text.'%')->orderBy('id', 'DESC')->paginate(20);
        foreach ($all as $mo) {
            $date = Carbon::parse($mo->created_at)->format('Y/m/d');
            $mo->subdate = Verta($date)->format('Y/m/d');
            $user = User::where('id', $mo->user_id)->first();
            $mo->user = $user;
            $student = Student::where('Mellicode', $user->username)->first();
            if ($student) {
                $mo->image = $student->Aks;
            } else {
                $mo->image = null;
            }
        }
        if ($request && $request->type === 'expired') {
            $Expired = Morakhasi::where('status', 3)->where('checked', 1)->where('fullname', 'LIKE', '%'.$request->text.'%')->orWhere('dalil', 'LIKE', '%'.$request->text.'%')->orWhere('status', 5)->where('checked', 1)->where('fullname', 'LIKE', '%'.$request->text.'%')->orWhere('dalil', 'LIKE', '%'.$request->text.'%')->orderBy('id', 'DESC')->paginate(20);
            foreach ($Expired as $mo) {
                $date = Carbon::parse($mo->created_at)->format('Y/m/d');
                $mo->subdate = Verta($date)->format('Y/m/d');
                $user = User::where('id', $mo->user_id)->first();
                $mo->user = $user;
                $student = Student::where('Mellicode', $user->username)->first();
                if ($student) {
                    $mo->image = $student->Aks;
                } else {
                    $mo->image = null;
                }
            }

            return $Expired;
        } elseif ($request && $request->type === 'rejected') {
            $Rejected = Morakhasi::where('status', 4)->where('fullname', 'LIKE', '%'.$request->text.'%')->orWhere('dalil', 'LIKE', '%'.$request->text.'%')->orderBy('id', 'DESC')->paginate(20);
            foreach ($Rejected as $mo) {
                $date = Carbon::parse($mo->created_at)->format('Y/m/d');
                $mo->subdate = Verta($date)->format('Y/m/d');
                $user = User::where('id', $mo->user_id)->first();
                $mo->user = $user;
                $student = Student::where('Mellicode', $user->username)->first();
                if ($student) {
                    $mo->image = $student->Aks;
                } else {
                    $mo->image = null;
                }
            }

            return $Rejected;
        } elseif ($request && $request->type === 'user') {
            $userMorakhasis = Morakhasi::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->where('dalil', 'LIKE', '%'.$request->text.'%')->orderBy('id', 'DESC')->paginate(20);
            foreach ($userMorakhasis as $mo) {
                $date = Carbon::parse($mo->created_at)->format('Y/m/d');
                $mo->subdate = Verta($date)->format('Y/m/d');
                $user = User::where('id', $mo->user_id)->first();
                $mo->user = $user;
                $student = Student::where('Mellicode', $user->username)->first();
                if ($student) {
                    $mo->image = $student->Aks;
                } else {
                    $mo->image = null;
                }
            }

            return $userMorakhasis;
        } else {
            return $all;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $check = $request->checked;
        $a = Morakhasi::where('id', $id)->first();
        if ($request->checked) {
            $a->checked = $check;
        }
        if ($request->status) {
            $a->status = $request->status;
            // $message = ['label' => 'status_1 to 5', 'value' => $id];
            // event(new \App\Events\SendResopnse($message));
        } elseif (!$request->status && $request->checked) {
            // $message = ['label' => 'status_3 to checked', 'value' => $id];
            // event(new \App\Events\SendResopnse($message));
        } elseif ($request->exit_ok) {
            $a->exit_ok = 1;
            // $message = ['label' => 'status_1 to exit', 'value' => $id];
            // event(new \App\Events\SendResopnse($message));
        }
        $a->save();
        if ($a) {
            return 1;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $a = Morakhasi::where('id', $id)->first();
        if ($request->status) {
            $status = $request->status;

            $a->status = $status;
            if ($status == 1) {
                $a->accepted_by = ' تأیید شده توسط '.$request->user()->fname.' '.$request->user()->lname;
            } else {
                $a->reject_dalil = $request->dalil;
                $a->accepted_by = ' رد شده توسط '.$request->user()->fname.' '.$request->user()->lname;
            }
            $a->save();
            if ($a && $status == 1) {
                // $message = ['label' => 'status_1', 'value' => $id, 'accepted_by' => ' تأیید شده توسط '.$request->user()->fname.' '.$request->user()->lname];
                // event(new \App\Events\SendResopnse($message));

                return 1;
            } else {
                // $message = ['label' => 'status_4', 'value' => $id, 'accepted_by' => ' رد شده توسط '.$request->user()->fname.' '.$request->user()->lname];
                // event(new \App\Events\SendResopnse($message));

                return 1;
            }
        } else {
            $a->guardmessage = $request->guard_message;
            $a->save();
            if ($a) {
                // $message = ['label' => 'get_messages', 'value' => 'ok'];
                // event(new \App\Events\SendResopnse($message));

                return 1;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Morakhasi $morakhasi)
    {
    }
}
