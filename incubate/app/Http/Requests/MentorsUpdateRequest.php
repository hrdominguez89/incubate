<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MentorsUpdateRequest extends Request
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
            'name_mentor'=>'required',
            'content'=>'required',
            'content_en'=>'required',
            'categories'=>'required|array',
            'image'=>'required'
        ];
    }
}