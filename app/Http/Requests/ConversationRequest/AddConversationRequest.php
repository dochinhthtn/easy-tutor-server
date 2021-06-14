<?php

namespace App\Http\Requests\ConversationRequest;

use App\Http\Requests\APIRequest;

class AddConversationRequest extends APIRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'nullable',
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ];
    }
}
