<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use App\Models\Cecy\Catalogue;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Resources\V1\Cecy\DetailPlanifications\DetailPlanificationResource;

class DetailPlanificationController extends Controller
{
    public function __construct()
    {
    }
    /*
        Obtener los horarios de cada paralelo dado un curso
    */
    // DetailController
    public function getDetailPlanificationsByCourse(Course $course)
    {
        $planification = $course->planifications()->get();
        $detailPlanification = $planification
            ->detailPlanifications();

        return (new DetailPlanificationResource($detailPlanification))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }
}
