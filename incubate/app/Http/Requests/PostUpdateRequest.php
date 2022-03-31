<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostUpdateRequest extends Request
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
            'title'=>'required',
            'content'=>'required',
            'resume'=>'required',
            'title_en'=>'required',
            'content_en'=>'required',
            'resume_en'=>'required',
            'categories'=>'required|array',
            'image'=>'required'
        ];
    }
}