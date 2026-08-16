<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type'              => 'categories',
            'id'                => (string) $this->id,
            'name'              => $this->name,
            'parent_id'         => $this->parent_id,
            'description'       => $this->description,
            'image_path'        => $this->image_path,
            'active'            => $this->active,
            'relationships' => [],
            'links' =>  [
                'self' => route('categories.show', ['category'=> $this->id])
            ]
        ];
    }
}
