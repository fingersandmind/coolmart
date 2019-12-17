<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'name'      =>  'required|min:2|max:50',
            'email'     =>  'required|unique:users',
            'password'  =>  'required|min:8|max:16'
        ],
        'PUT' => [
            'name'      =>  'required|min:2|max:50',
            'password'  =>  'required|min:8|max:16'
        ],
        'PATCH' => [
            'name'      =>  'required|min:2|max:50',
            'password'  =>  'required|min:8|max:16'
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
                'email'     =>  'required|unique:users,email,'.$this->user->id,
            ];
        }
        return $this->rules[$this->method()];
    }
}
