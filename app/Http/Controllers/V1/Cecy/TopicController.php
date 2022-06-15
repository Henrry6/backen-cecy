<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Core\Files\DestroysFileRequest;
use App\Http\Requests\V1\Core\Files\IndexFileRequest;
use App\Http\Requests\V1\Core\Files\UpdateFileRequest;
use App\Http\Requests\V1\Core\Files\UploadFileRequest;
use App\Http\Resources\V1\Cecy\Courses\TopicsByCourseCollection;
use App\Http\Requests\V1\Cecy\Topics\CatalogueTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\DestroysTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\StoreTopicRequest;
use App\Http\Requests\V1\Cecy\Topics\UpdateTopicRequest;
use App\Http\Requests\V1\Cecy\ResponsibleCourseDetailPlanifications\GetDetailPlanificationsByResponsibleCourseRequest;
use App\Http\Resources\V1\Cecy\Courses\CourseCollection;
use App\Http\Resources\V1\Cecy\Instructors\InstructorResource;
use App\Http\Resources\V1\Cecy\Instructors\InstructorCollection;
use App\Http\Resources\V1\Cecy\Topics\TopicResource;
use App\Http\Resources\V1\Cecy\Topics\TopicCollection;
use App\Models\Core\File;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Topic;

class TopicController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:store-catalogues')->only(['store']);
    //     $this->middleware('permission:update-catalogues')->only(['update']);
    //     $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    // }

    public function catalogue(CatalogueTopicRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $topics =  Topic::customOrderBy($sorts)
            ->description($request->input('search'))
            ->limit(1000)
            ->get();

        return (new TopicCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function getTopics(Request $request, Course $course)
    {
        $sorts = explode(',', $request->sort);

        $topics = $course->topics()->where('level', 1)
            ->customOrderBy($sorts)
            ->description($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new TopicCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function getAllTopics()
    {
        $sorts = explode(',', $request->sort);

        $topics = Topic::customOrderBy($sorts)
            ->description($request->input('search'))
            ->paginate($request->input('perPage'));
        return (new TopicCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function show(Course $course, Topic $topic)
    {
        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Actualizado',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function getTopicsByCourse($request, Course $course)
    {
        $sorts = explode(',', $request->sort);

        $topics = $course->topics()
            ->customOrderBy($sorts)
            ->description($request->input('search'))
            ->paginate($request->input('perPage'));

        return (new TopicsByCourseCollection($topics))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])->response()->setStatusCode(200);
    }

    public function storesTopics(Request $request, Course $course)
    {
        $topics = $request->input('topics');
        foreach ($topics as $topic) {
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
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
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
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

    public function storeTopic(StoreTopicRequest $request, Course $course)
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
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }


    public function updateTopic(UpdateTopicRequest $request, Course $course, Topic $topic)
    {
        $topic->description = $request->input('description');
        $topic->save();

        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Actualizado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }



    public function destroyTopic(Course $course, Topic $topic)
    {
        $topicFilter = Topic::find($topic->id);
        if ($topicFilter->children) {
            $idsChildren = $topicFilter->children->map(function ($item, $key) {
                return $item->id;
            });
            Topic::destroy($idsChildren);
        }
        $topic->delete();

        return (new TopicResource($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Tema o subtema Eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }


    public function destroysTopics(DestroysTopicRequest $request)
    {
        $topic = Topic::whereIn('id', $request->input('ids'))->get();
        Topic::destroy($request->input('ids'));

        return (new TopicCollection($topic))
            ->additional([
                'msg' => [
                    'summary' => 'Temas o subtemas Eliminados',
                    'detail' => '',
                    'code' => '201'
                ]
            ])->response()->setStatusCode(201);
    }

    /*******************************************************************************************************************
     * FILES
     ******************************************************************************************************************/
    public function indexFiles(IndexFileRequest $request, Topic $topic)
    {
        return $topic->indexFiles($request);
    }

    public function uploadFile(UploadFileRequest $request, Topic $topic)
    {
        return $topic->uploadFile($request);
    }

    public function downloadFile(Topic $topic, File $file)
    {
        return $topic->downloadFile($file);
    }

    public function downloadFiles(Topic $topic)
    {
        return $topic->downloadFiles();
    }

    public function showFile(Topic $topic, File $file)
    {
        return $topic->showFile($file);
    }

    public function updateFile(UpdateFileRequest $request, Topic $topic, File $file)
    {
        return $topic->updateFile($request, $file);
    }

    public function destroyFile(Topic $topic, File $file)
    {
        return $topic->destroyFile($file);
    }

    public function destroyFiles(Topic $topic, DestroysFileRequest $request)
    {
        return $topic->destroyFiles($request);
    }
}
