<?php

use App\Http\Controllers\V1\Authentication\AuthController;
use App\Models\Authentication\User;
use App\Models\Cecy\Course;
use Illuminate\Support\Facades\Route;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('login')->group(function () {
    Route::get('{driver}', [AuthController::class, 'redirectToProvider']);
    Route::get('{driver}/callback', [AuthController::class, 'handleProviderCallback']);
});

Route::get('generate-password/{password}',function ($password){
    return \Illuminate\Support\Facades\Hash::make($password);
});

Route::get('/case-report ', function () {

    $pdf = PDF::loadView('reports/report-needs');

    return $pdf->inline('Certificado-Estudiante.pdf');



});



