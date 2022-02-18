<?php

namespace App\Http\Resources\V1\Authentication;

use App\Http\Resources\V1\Core\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tokens' => PersonalAccessTokenResource::collection($this->tokens),
            'roles' => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($this->permissions),
//            'professional' => ProfessionalResource::make($this->professional),
            'user' => UserResource::make($this->resource),
        ];
    }
}
