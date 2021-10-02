<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FixedFoodUpdateRequest extends FormRequest
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
            'name' => 'required|max:255|string',
            'menu_category_id' => 'required|exists:menu_categories,id',
            'divnumber' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|max:1024',
        ];
    }
}
