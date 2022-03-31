<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InformationCreateRequest extends Request
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
            'title'=>'required|unique:informations',
            'content'=>'required',
            'title_en'=>'required',
            'content_en'=>'required',
            'boton_name_en'=>'required',
            'boton_name'=>'required',
        ];
    }
}