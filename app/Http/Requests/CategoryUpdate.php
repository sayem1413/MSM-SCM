<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryId = $this->route()->parameters()['category']['id'];
        return [
            'id'                => 'required|numeric',
            'active'            => 'required|integer',
            'name'              => 'required|string',
            'parent_id'         => 'nullable|sometimes|numeric',
            'description'       => 'nullable|string',
            'image_path'        => 'nullable|sometimes|image|mimes:jpeg,jpg,png|max:500000',
        ];
    }
}
