<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Planifications\UpdateAssignResponsibleCecyRequest;
use App\Http\Resources\V1\Cecy\Planifications\PlanificationResource;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Planification;

class PlanificationController extends Controller
{
    /*
    * Asignar docente responsable de cecy de la planificación
    */
    // PlanificationController
    public function updateAssignResponsibleCecy(UpdateAssignResponsibleCecyRequest $request, Planification $planification)
    {
        $planification->responsibleCecy()->associate(Authority::find($request->input('responsibleCecy.id')));
        $planification->save();

        return (new PlanificationResource($planification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}
