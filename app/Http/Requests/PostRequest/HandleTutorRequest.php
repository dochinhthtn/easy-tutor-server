<?php

namespace App\Http\Requests\PostRequest;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class HandleTutorRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = $this->route('post');
        return $post->user_id == auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => 'required',
            'userId' => 'nullable|exists:users,id'
        ];
    }
}
