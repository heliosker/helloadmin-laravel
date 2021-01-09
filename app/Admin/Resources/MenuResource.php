<?php

namespace App\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'title' => $this->title,
            'uri' => $this->uri,
            'icon' => $this->icon,
            'show' => $this->show,
            'updated_at' => (string)$this->updated_at,
            'created_at' => (string)$this->created_at
        ];
    }
}
