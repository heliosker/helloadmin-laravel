<?php

namespace App\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'http_method' => $this->http_method,
            'http_path' => $this->http_path,
            'updated_at' => (string)$this->updated_at,
            'created_at' => (string)$this->created_at
        ];
    }
}
