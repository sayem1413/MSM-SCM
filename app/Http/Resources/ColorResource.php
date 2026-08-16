<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
            'type'          => 'colors',
            'id'            => (string) $this->id,
            'name'          => $this->name,
            'hex_code'      => $this->hex_code,
            'relationships' => [],
            'links' =>  [
                'self' => route('colors.show', ['color'=> $this->id])
            ]
        ];
    }
}
