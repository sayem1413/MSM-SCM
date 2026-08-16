<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerUpdate extends FormRequest
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
        $manufacturerId = $this->route()->parameters()['manufacturer']['id'];
        return [
            'active'    => 'required|integer',
            'name'      =>'required|string',
            'logo_path' => 'nullable|sometimes|image|mimes:jpeg,jpg,png|max:500000'
        ];
    }
}
