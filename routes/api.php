<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AbsentofclassController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\AlluserController;
use App\Http\Controllers\ClasshaController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\DalilController;
use App\Http\Controllers\DayliController;
use App\Http\Controllers\DeletecheckController;
use App\Http\Controllers\DisiplineController;
use App\Http\Controllers\DroosController;
use App\Http\Controllers\EnzebatiController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\HafezkolController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\importantClassController;
use App\Http\Controllers\ManageruserController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MasteruserController;
use App\Http\Controllers\Morakhasi_type2Controller;
use App\Http\Controllers\MorakhasiController;
use App\Http\Controllers\NewmasterController;
use App\Http\Controllers\NomrehController;
use App\Http\Controllers\NumberlistController;
use App\Http\Controllers\PersonallistController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\studentParehController;
use App\Http\Controllers\studentZiafatController;
use App\Http\Controllers\UpdateZiafatController;
use App\Http\Controllers\ZiafatyearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('Register', RegisterController::class);
Route::resource('image', ImageController::class);
Route::resource('date', DayliController::class);
// Route::get('students/{id}', 'StudentController@edit');
Route::middleware('auth:sanctum')->resource('students', StudentController::class);
Route::middleware('auth:sanctum')->post('numberslist-by-date', [NumberlistController::class,'numbersByDate']);
Route::middleware('auth:sanctum')->resource('numberslist', NumberlistController::class);
Route::middleware('auth:sanctum')->put('students/{id}', [StudentController::class, 'update']);
Route::middleware('auth:sanctum')->put('allusers/{id}', [AlluserController::class,'edit']);
Route::middleware('auth:sanctum')->resource('allusers', AlluserController::class);
Route::middleware('auth:sanctum')->post('adminuser/{id}', [AdminuserController::class, 'store']);
Route::middleware('auth:sanctum')->post('manageruser/{id}', [ManageruserController::class,'store']);
Route::middleware('auth:sanctum')->post('masteruser/{id}', [MasteruserController::class,'store']);
Route::middleware('auth:sanctum')->post('disciplineuser/{id}', [DisiplineController::class , 'store']);
Route::middleware('auth:sanctum')->post('guarduser/{id}', [GuardController::class, 'store']);
Route::middleware('auth:sanctum')->delete('adminuser/{id}', [AdminuserController::class, 'destroy']);
Route::middleware('auth:sanctum')->delete('masteruser/{id}', [MasteruserController::class, 'destroy']);
Route::middleware('auth:sanctum')->delete('manageruser/{id}', [ManageruserController::class,'destroy']);
Route::middleware('auth:sanctum')->delete('disciplineuser/{id}', [DisiplineController::class , 'destroy']);
Route::middleware('auth:sanctum')->delete('guarduser/{id}', [GuardController::class, 'destroy']);
Route::middleware('auth:sanctum')->resource('adminuser',  AdminuserController::class);
Route::get('alert/{id}', [AlertController::class, 'show']);
Route::middleware('auth:sanctum')->resource('alert', AlertController::class);
Route::middleware('auth:sanctum')->put('alert/{id}', [AlertController::class,'update']);
Route::middleware('auth:sanctum')->resource('count', CountController::class);
Route::middleware('auth:sanctum')->resource('droos', DroosController::class);
Route::middleware('auth:sanctum')->resource('master',  MasterController::class);
Route::middleware('auth:sanctum')->resource('classha', ClasshaController::class);
Route::middleware('auth:sanctum')->delete('classha/{id}', [ClasshaController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('classha/{id}', [ClasshaController::class, 'update']);
Route::middleware('auth:sanctum')->put('absentsofclass/{id}', [AbsentofclassController::class, 'update']);
Route::middleware('auth:sanctum')->delete('master/{id}', [MasterController::class, 'destroy']);
Route::middleware('auth:sanctum')->resource('newmaster', NewmasterController::class);
Route::middleware('auth:sanctum')->resource('nomreh', NomrehController::class);
Route::middleware('auth:sanctum')->put('personallist/{id}', [PersonallistController::class, 'update']);
Route::middleware('auth:sanctum')->delete('personallist/{id}', [PersonallistController::class, 'destroy']);
Route::middleware('auth:sanctum')->resource('personallist',  PersonallistController::class);
Route::middleware('auth:sanctum')->get('hozor_weakly', [AbsentController::class, 'show']);
Route::middleware('auth:sanctum')->resource('hozor', AbsentController::class);
Route::middleware('auth:sanctum')->put('enzebati/{id}', [EnzebatiController::class, 'edit']);
Route::middleware('auth:sanctum')->get('enzebati_weakly', [EnzebatiController::class, 'show']);
Route::middleware('auth:sanctum')->put('enzebati/{id}/{record}', [EnzebatiController::class, 'update']);
Route::middleware('auth:sanctum')->resource('enzebati', EnzebatiController::class);
Route::middleware('auth:sanctum')->resource('deletecheck', DeletecheckController::class);
Route::middleware('auth:sanctum')->put('dalil/{id}/{up}', [DalilController::class, 'update']);
Route::middleware('auth:sanctum')->put('dalil/{id}', [DalilController::class, 'edit']);
Route::middleware('auth:sanctum')->resource('dalil', DalilController::class);
Route::middleware('auth:sanctum')->post('morakhasi/{id}', [MorakhasiController::class, 'show']);
Route::middleware('auth:sanctum')->put('guardmorakhasi/{id}', [MorakhasiController::class, 'edit']);
Route::middleware('auth:sanctum')->resource('morakhasi', MorakhasiController::class);
Route::middleware('auth:sanctum')->resource('morakhasi_type2', Morakhasi_type2Controller::class);
Route::middleware('auth:sanctum')->put('droos/{id}', [DroosController::class, 'update']);
Route::middleware('auth:sanctum')->delete('droos/{id}', [DroosController::class, 'destroy']);
Route::middleware('auth:sanctum')->resource('studentpareh', studentParehController::class);
Route::middleware('auth:sanctum')->get('studentziafat/{id}/{date}', [studentZiafatController::class, 'show']);
Route::middleware('auth:sanctum')->resource('studentziafat', studentZiafatController::class);
Route::middleware('auth:sanctum')->resource('ziafatYears', ZiafatyearController::class);
Route::middleware('auth:sanctum')->resource('updateziafat', UpdateZiafatController::class);
Route::middleware('auth:sanctum')->resource('nodorehs', importantClassController::class);
Route::middleware('auth:sanctum')->post('filter-nodorehs/{name}', [importantClassController::class, 'filter_nodorehs']);
Route::middleware('auth:sanctum')->post('filter-nodorehs-doreh', [importantClassController::class, 'filter_nodorehs_doreh']);
Route::middleware('auth:sanctum')->resource('hafezkol', HafezkolController::class);
Route::middleware('auth:sanctum')->post('hafezkol-edit', [HafezkolController::class, 'edit']);
Route::middleware('auth:sanctum')->post('hafezkol-delete', [HafezkolController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('hafezkol-students', [HafezkolController::class, 'students']);
Route::middleware('auth:sanctum')->resource('activity', ActivityController::class);
