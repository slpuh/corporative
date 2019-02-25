<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenusRequest extends FormRequest
{
    
    public function authorize()
    {
        return \Auth::user()->canDo('EDIT_MENU');
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
        ];
    }
}
