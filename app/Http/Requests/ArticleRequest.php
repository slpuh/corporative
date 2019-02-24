<?php

namespace Corp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->canDo('ADD_ARTICLES');
    }

    protected function getValidatorInstance() {
        
        $validator = parent::getValidatorInstance();
        
        $validator->sometimes('alias','unique:articles|max:255',function($input) {
            
            if($this->route()->hasParameter('alias')) {
                $model = $this->route()->parameter('alias');
                return ($model->alias !== $input->alias) && !empty($input->alias);
            }
            
            return !empty($input->alias);
        });
        
        return $validator;
    }
    
    public function rules()
    {
        return [
            'title' =>'required|max:255',
            'text' =>'required',
            'category_id' =>'required|integer',
            
        ];
    }
}
