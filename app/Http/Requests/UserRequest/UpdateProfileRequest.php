<?php

namespace App\Http\Requests\UserRequest;

use App\Http\Requests\APIRequest;

class UpdateProfileRequest extends APIRequest
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
            'sex' => 'required',
            'address' => 'required',
            'achievements' => 'nullable|array',
            'avatar' => 'required|image'
        ];
    }
}
