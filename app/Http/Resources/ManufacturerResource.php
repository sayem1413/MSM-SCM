<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturerResource extends JsonResource
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
            'type'          => 'manufacturers',
            'id'            => (string) $this->id,
            'name'          => $this->name,
            'logo'          => $this->logo_path,
            'description'   => $this->description,
            'active'        => $this->active,
            'relationships' => [],
            'links' =>  [
                'self'  => route('manufacturers.show', ['manufacturer'=> $this->id])
            ]
        ];
    }
}
