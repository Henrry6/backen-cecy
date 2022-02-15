<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Topics\DestroysTopicRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Resources\V1\Cecy\Courses\TopicsByCourseCollection;

class TopicController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    // Devuelve los cursos que le fueron asignados al docente responsable
    // InstructorCotroller

    // Devuelve los temas y subtemas de un curso
    // TopicController
    public function getTopics(Course $course)
    {
        $topics = $course->topics()->get();
        return (new TopicCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Crea un nuevo tema o subtema para un curso
    // TopicController
    public function storeTopic(StoreTopicRequest $request, Course $course )
    {
        $topic = new Topic();
        $topic->course()->associate($course);
        $topic->level = $request->input('level');
        $topic->children()->associate($request->input('parent.id'));
        $topic->description = $request->input('description');
        $topic->save();
        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Actualiza el tema o subtema de un curso
    // TopicController
    public function updateTopic(UpdateTopicRequest $request, Course $course, Topic $topic)
    {
        $topic->description = $request->input('description');
        $topic->save();
        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Elimina un tema o subtema de un curso
    // TopicCotroller
    public function destroyTopic(Topic $topic)
    {
        $topic->delete();
        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Eliminado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    // Elimina varios temas o subtemas de un curso
    // TopicController
    public function destroysTopics(DestroysTopicRequest $request)
    {
        $topic = Topic::whereIn('id', $request->input('ids'))->get();
        Topic::destroy($request->input('ids'));

        return (new TopicCollection($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Temas o subtemas Eliminados',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
    /*
        Obtener los topicos  dado un curso
    */
    // TopicsController
    public function getTopicsByCourse(Course $course)
    {
        $topics = $course->topics()->get();

        return (new TopicsByCourseCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
}
