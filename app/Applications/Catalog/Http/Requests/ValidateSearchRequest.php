<?php

namespace App\Applications\Catalog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateSearchRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'search' => ['required', 'string']
        ];
    }
}