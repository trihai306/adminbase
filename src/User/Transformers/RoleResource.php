<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'is_system' => (bool) $this->is_system,
            'permissions' => $this->whenLoaded('permissions', function () {
                return PermissionResource::collection($this->permissions);
            }),
            'permission_ids' => $this->whenLoaded('permission_ids', function () {
                return $this->permissions->pluck('id');
            }),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
