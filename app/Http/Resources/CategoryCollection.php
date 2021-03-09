<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => CategoryResource::collection($this->collection),
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'first_page' => $this->onFirstPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                "next_page_url" => $this->nextPageUrl(),
                "prev_page_url" => $this->previousPageUrl(),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' =>  [
                'self' => route('categories.index')
            ]
        ];
    }
}
