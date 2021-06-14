<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class APIRequest extends FormRequest {

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(new Response($validator->errors(), 400));
    }

    protected function failedAuthorization() {
        throw new HttpResponseException(new Response([
            'message' => "You don't have permission to do this"
        ], 403));
    }
}
