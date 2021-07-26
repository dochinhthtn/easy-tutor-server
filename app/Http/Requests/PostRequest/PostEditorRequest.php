<?php

namespace App\Http\Requests\PostRequest;

use App\Http\Requests\APIRequest;

class PostEditorRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = $this->route();
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
            'subjectId' => 'required|exists:subjects,id',
            'description' => 'required',
            'address' => 'required',
            'offer' => 'required|numeric',
            'grade' => 'required|numeric'
        ];
    }
}
