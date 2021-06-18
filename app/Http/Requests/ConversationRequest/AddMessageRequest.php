<?php

namespace App\Http\Requests\ConversationRequest;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddMessageRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // $conversation = $this->route('conversation');
        // return $conversation->id == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required'
        ];
    }
}
