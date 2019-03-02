<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends AbstractRequest
{
    protected $routeParametersToValidate = ['post_id' => 'postId'];
    protected $queryParametersToValidate = ['include' => 'include'];
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
            'post_id' => 'required|exists:posts,id',
            'include' => 'sometimes|numeric|nullable',
            'name' => 'required|string',
        ];
    }
}
