<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'title' =>  'required|min:3|max:30|unique:faqs',
            'body'  =>  'required|min:2|max:100'
        ],
        'PUT' => [
            'body'  =>  'required|min:2|max:100'
        ],
        'PATCH' => [
            'body'  =>  'required|min:2|max:100'
        ],
        
    ];
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
        if($this->method() == 'PUT' || $this->method() == 'PATCH')
        {
            return [
                'title' => 'required|min:3|max:30|unique:faqs,title,'.$this->faq->id
            ];
        }
        return $this->rules[$this->method()];
    }
}
