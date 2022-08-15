<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Attendances\SaveDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\DetailAttendance\CatalogueDetailAttendanceRequest;
use App\Http\Requests\V1\Cecy\DetailAttendance\GetDetailAttendancesByParticipantRequest;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceCollection;
use App\Http\Resources\V1\Cecy\Attendances\AttendanceResource;
use App\Http\Resources\V1\Cecy\Attendances\SaveDetailAttendanceResource;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceByAttendanceCollection;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceCollection;
use App\Http\Resources\V1\Cecy\DetailAttendances\DetailAttendanceResource;
use App\Models\Cecy\Attendance;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailAttendance;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Participant;
use App\Models\Cecy\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class  DetailAttendanceController extends Controller
{
    public function catalogue(CatalogueDetailAttendanceRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->limit(1000)
            ->get();

        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function changeType(DetailAttendance $detailAttendance,Catalogue $type)
    {
        $detailAttendance->type()->associate($type);
        $detailAttendance->save();

        return (new DetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Asistencia Guardada',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function updateType(SaveDetailAttendanceRequest $request, DetailAttendance $detailAttendance)
    {
        
        $duration = $detailAttendance->attendance->duration;

        //return $duration;

        //fecha del sistema actual
        $date = Carbon:: now();
        //hora inicio de la hora
        $time = $this->getstartendtime($request)->started_time;
     
        //hora finalizacion
        $hourend =  $this->getstartendtime($request)->ended_time;

       // $detailPlanification = $this->getstartendtime($request->input('registration.id'));
       $hour = Carbon::parse($time);
       $hour2 = Carbon::parse($hourend);
       $absent = Catalogue::where('type', 'ATTENDANCE')
            ->where('code', 'ABSENT')
            ->first();
       $present = Catalogue::where('type', 'ATTENDANCE')
            ->where('code', 'PRESENT')
            ->first();
       $backwardness = Catalogue::where('type', 'ATTENDANCE')
            ->where('code', 'BACKWARDNESS')
            ->first();

        //return $detailAttendance->attendance->duration_student = $duration/2;

        $attendance = Attendance::firstWhere('id', $detailAttendance->attendance_id);  
        //return var_dump($date->lte($hour2->toDateTimeString()));
        if($hour->diffInMinutes($date)>=15 && $date->lt($hour2->toDateTimeString())){
            $attendance->duration_student = ceil($duration/2);
            $detailAttendance->type()->associate($backwardness->id);
        }elseif($hour->diffInMinutes($date)<15 && $date->lt($hour2) ){
            $attendance->duration_student = $duration;
            $detailAttendance->type()->associate($present->id);
        }else{
            $detailAttendance->type()->associate($absent->id);
            $attendance->duration_student = 0;
        }
        $detailAttendance->registration_id = $request->input('registration.id');  
        $attendance->save();
        $detailAttendance->save();
        return (new SaveDetailAttendanceResource($detailAttendance))
            ->additional([
                'msg' => [
                    'summary' => 'asistencia guardada',
                    'detail' => 'Asistencia guardada correctamente',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getDetailAttendancesByParticipant(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $sorts = explode(',', $request->input('sort'));

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $registration = Registration::where(
            [
                'detail_planification_id' => $detailPlanification->id,
                'participant_id' => $participant->id
            ]
        )->first();

          $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->registration($registration)
           ->whereHas('attendance', function ($registration){
                $registration->whereDate('registered_at','< ',now()->toDateString());
            });
            
            $atendance = $detailPlanification->attendances()->whereDate('registered_at','<=',now()->toDateString())->with(['detailAttendances'=>function ($q)use($registration){
                $q->Where('registration_id',$registration->id);
            }])->paginate($request->input('per_page'));
            //return $atendance;


        return (new AttendanceCollection($atendance))
            ->additional([
                'msg' => [
                    'summary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    // loadDetailAttendancesWithOutPaginate getByRegistration en el metodo y ruta
    public function getByRegistration(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $sorts = explode(',', $request->input('sort'));

        $participant = Participant::where('user_id', $request->user()->id)->first();

        $registration = Registration::where(
            [
                'detail_planification_id' => $detailPlanification->id,
                'participant_id' => $participant->id
            ]
        )->first();

        $detailAttendances = DetailAttendance::customOrderBy($sorts)
            ->registration($registration)
            ->get();

        return (new DetailAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'summary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getByAttendance(Attendance $attendance)
    {
        $detailAttendances = $attendance->detailAttendances()->get();

        return (new DetailAttendanceByAttendanceCollection($detailAttendances))
            ->additional([
                'msg' => [
                    'sumary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    public function getCurrentDateDetailAttendance(GetDetailAttendancesByParticipantRequest $request, DetailPlanification $detailPlanification)
    {

        $dateToday = Date('Y-m-d');

        

       // echo($detailPlanification['id']);
       //return $attendance;

        $attendance = Attendance::where(

        [
            ['detail_planification_id' ,'=', $detailPlanification->id],
            [    'registered_at' ,'=', $dateToday]
            ]

        )->first();
        

        //echo($attendance);

        return (new AttendanceResource($attendance))
            ->additional([
                'msg' => [
                    'summary' => 'consulta exitosa',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    public function getstartendtime(Request $request){
     return Registration::
         firstWhere('id' ,'=', $request->input('registration.id'))->detailPlanification()->
         select('started_time','ended_time')->first();
    }
}

