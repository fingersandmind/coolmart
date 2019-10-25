<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'name'          =>  'required|min:2,max:25|unique:categories',
            'slug'          =>  'unique:categories',
            'description'   =>  ''
        ],
        'PUT' => [
            'description'   =>  ''
        ],
        'PATCH' => [
            'description'   =>  ''
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
        $this->request->add(['slug' => str_slug($this->name)]);
        if($this->method() == 'PUT' || $this->method() == 'PATCH')
        {
            return [
                'name'          =>  'unique:categories,name,' . $this->category->id,
            ];
        }
        return $this->rules[$this->method()];
    }
}
