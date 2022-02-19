<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Topics\DestroysTopicRequest;
use Illuminate\Http\Request;
use App\Models\Cecy\Topic;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorCollection;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Resources\V1\Cecy\Courses\TopicsByCourseCollection;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByResponsibleCourseRequest;


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
        $topics = $course->topics()->Where('level', 1)->get();
        return (new TopicCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function getInstructors(Request $request, Course $course)
    {
        // $responsibleCourse = Instructor::where('user_id', $request->user()->id)->get();
        // $detailPlanifications = $responsibleCourse
        //     ->detailPlanifications()
        //     ->paginate($request->input('per_page'));
        // return $detailPlanifications;
        return (new InstructorCollection(Instructor::paginate(100)))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function getAllTopics(Course $course)
    {
        return (new TopicCollection(Topic::paginate(200)))
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
    public function storesTopics(Request $request, Course $course )
    {
        $topics = $request->input('topics');
        foreach ($topics as $topic) {
            // $instructor = Instructor::find($topic['instructor']['id'])
            // return $instructor;
            $newTopic = new Topic();
            $newTopic->course()->associate($course);
            $newTopic->level = 1;
            $newTopic->description = $topic['description'];
            $newTopic->save();

            foreach ($topic['children'] as $subTopic) {
                
                $newSubTopic = new Topic();
                $newSubTopic->course()->associate($course);
                $newSubTopic->parent()->associate($newTopic);
                $newSubTopic->level = 2;
                $newSubTopic->description = $subTopic['description'];
                $newSubTopic->save();
            }
        }
        return (new TopicCollection([]))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function updateTopics(Request $request, Course $course)
    {
        $topics = $request->input('topics');
        foreach ($topics as $topic) {
            $newTopic = Topic::find($topic['id']);
            $newTopic->description = $topic['description'];
            $newTopic->save();

            foreach ($topic['children'] as $subTopic) {
                
                $newSubTopic = Topic::find($subTopic['id']);
                $newSubTopic->description = $subTopic['description'];
                $newSubTopic->save();
            }
        }
        return (new TopicCollection([]))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Creado',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function storeTopic(StoreTopicRequest $request, Course $course )
    {
        $topic = new Topic();
        $topic->course()->associate($course);
        $topic->level = $request->input('level');
        $topic->parent()->associate($request->input('parent.id'));
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
    public function destroyTopic(Course $course, Topic $topic)
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
