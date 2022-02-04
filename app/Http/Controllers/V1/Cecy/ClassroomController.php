<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Classrooms\DestroysClassroomRequest;
use App\Http\Requests\V1\Cecy\Classrooms\IndexClassroomRequest;
use App\Http\Requests\V1\Cecy\Classrooms\StoreClassroomRequest;
use App\Http\Requests\V1\Cecy\Classrooms\UpdateClassroomRequest;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomCollection;
use App\Http\Resources\V1\Cecy\Classrooms\ClassroomResource;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Classroom;
use Illuminate\Support\Facades\Request;

class ClassroomController extends Controller
{
    /*DDRC-C: Obtiene todas las clases que hay*/
    public function index(IndexClassroomRequest $request)
    {
        $sorts = explode(',', $request->input('sort'));

        $classrooms = Classroom::customOrderBy($sorts)
            ->paginate($request->input('per_page'));

        return (new ClassroomCollection($classrooms))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /*DDRC-C: Obtiene una clase*/
    public function show(Classroom $classroom)
    {
        return (new ClassroomResource($classroom))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
    /*DDRC-C: Crea una clase*/
    public function store(StoreClassroomRequest $request)
    {        
        $classroom = new Classroom();
        $classroom->type()->associate(Catalogue::find($request->input('type.id')));
 
        $classroom->description = $request->input('description');
        $classroom->capacity = $request->input('capacity');
        $classroom->code = $request->input('code');
        $classroom->name = $request->input('name');
        
        $classroom->save();

        return (new ClassroomResource($classroom))
            ->additional([
                'msg' => [
                    'summary' => 'Clase creada',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    /*DDRC-C: Actualiza una clase*/
    public function update (UpdateClassroomRequest $request, Classroom $classroom)
    {
        $classroom->type()->associate(Catalogue::find($request->input('type.id')));
 
        $classroom->description = $request->input('description');
        $classroom->capacity = $request->input('capacity');
        $classroom->code = $request->input('code');
        $classroom->name = $request->input('name');
  
        $classroom->save();

        return (new ClassroomResource($classroom))
        ->additional([
            'msg' => [
                'summary' => 'Clase actualizada',
                'detail' => '',
                'code' => '200'
            ]
        ])
        ->response()->setStatusCode(201);
    }
    /*DDRC-C: Elimina una clase*/
    public function destroy ( Classroom $classroom)
    {
        
        $classroom->delete();

        return (new ClassroomResource($classroom))
            ->additional([
                'msg' => [
                    'summary' => 'Clase Eliminada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
    /*DDRC-C: Elimina varias clases*/
    public function destroys (DestroysClassroomRequest $request)
    {
        $classrooms = Classroom::whereIn('id', $request->input('ids'))->get();

        Classroom::destroy($request->input('ids'));

        return (new ClassroomCollection($classrooms))
            ->additional([
                'msg' => [
                    'summary' => 'Clases Eliminadas',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}
