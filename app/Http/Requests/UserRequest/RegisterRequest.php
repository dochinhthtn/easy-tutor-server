<?php

namespace App\Http\Requests\UserRequest;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends APIRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required',
            'password' => 'required',
            'passwordConfirmation' => 'required|same:password',
            'isTutor' => 'required'
        ];
    }
}
