<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'name'      =>  'required|min:2|max:60:unique:terms',
            'content'   =>  'required|min:2'
        ],
        'PUT' => [
            'content'   =>  'required|min:2'
        ],
        'PATCH' => [
            'content'   =>  'required|min:2'
        ],
        'DELETE' => []
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
                'name'  =>  'required|min:2|max:60:unique:terms,name,'.$this->term->id
            ];
        }
        return $this->rules[$this->method()];
    }
}
