<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Cecy\Authorities\DestroysAuthorityRequest;
use App\Http\Requests\V1\Cecy\Authorities\StoreAuthorityRequest;
use App\Http\Requests\V1\Cecy\Authorities\UpdateAuthorityRequest;
use App\Http\Resources\V1\Cecy\Authorities\AuthorityCollection;
use App\Http\Resources\V1\Cecy\Authorities\AuthorityResource;
use App\Models\Cecy\Authority;



class AuthorityController extends Controller
{
    public function index()
    {
        //return Authority::paginate();
        return (new AuthorityCollection(Authority::paginate()))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Authority' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function store(StoreAuthorityRequest $request)
    {
        $authority = new Authority();

        $authority->position_started_at = $request->input('position_started_at');
        $authority->position_ended_at = $request->input('position_ended_at');
        $authority->electronic_signature = $request->input('electronic_signature');
        $authority->save();

        return (new AuthorityResource($authority))
            ->additional([
                'msg' => [
                    'summary' => 'Autoridad Creada',
                    'Authority' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function show(Authority $authority)
    {
        return (new AuthorityResource($authority))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'Authority' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function update(UpdateAuthorityRequest $request, Authority $authority)
    {
        $authority->position_started_at = $request->input('position_started_at');
        $authority->position_ended_at = $request->input('position_ended_at');
        $authority->electronic_signature = $request->input('electronic_signature');
        $authority->save();
        return (new AuthorityResource($authority))
            ->additional([
                'msg' => [
                    'summary' => 'Autoridad Actualizada',
                    'Authority' => '',
                    'code' => '200'
                ]
            ]);
    }


    public function destroy(Authority $authority)
    {

        $authority->delete();

        return (new AuthorityResource($authority))
            ->additional([
                'msg' => [
                    'summary' => 'Autoridad Eliminada',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }



    public function destroys(DestroysAuthorityRequest $request)
    {
        $authority = Authority::whereIn('id', $request->input('ids'))->get();

        Authority::destroy($request->input('ids'));

        return (new AuthorityCollection($authority))
            ->additional([
                'msg' => [
                    'summary' => 'Autoridades Eliminadas',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}
