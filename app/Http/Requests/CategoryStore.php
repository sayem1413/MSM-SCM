<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest
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
        return [
            'active'            => 'required|integer',
            'name'              => 'required|string',
            'parent_id'         => 'nullable|sometimes|numeric',
            'description'       => 'nullable|string',
            'image_path'        => 'nullable|sometimes|image|max:500000|mimes:jpeg,jpg,png',
        ];
    }
}
