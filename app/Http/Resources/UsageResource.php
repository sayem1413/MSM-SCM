<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsageResource extends JsonResource
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
            'type'          => 'usages',
            'id'            => (string) $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'relationships' => [],
            'links' =>  [
                'self'  => route('usages.show', ['usage'=> $this->id])
            ]
        ];
    }
}
