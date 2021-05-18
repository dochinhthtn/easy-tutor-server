<?php

namespace App\Http\Requests\RateRequest;

use Illuminate\Foundation\Http\FormRequest;

class RateEditorRequest extends FormRequest
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
            'assessorId' => 'required|exists:users,id',
            'tutorId' => 'required|exists:users,id',
            'star' => 'required|numeric',
            'comment' => 'required'
        ];
    }
}
