<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Cache;

class AdjustmentResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $language = Cache::get('language');
        return parent::toArray($request);
    }
}
