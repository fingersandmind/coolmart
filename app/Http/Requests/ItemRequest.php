<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'brand'         =>  'required',
            'type'          =>  'required',
            'category'      =>  'required',
            'name'          =>  'required|min:4|max:50',
            'slug'          =>  'unique:items,slug',
            'description'   =>  '',
            'srp'           =>  'required|numeric|min:2',
            'cost'          =>  'required|numeric|min:2',
            'qty'           =>  'required|numeric',
            'images.*'      =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'names.*'       =>  'required',
            'description.*' =>  'required'
        ],
        'PUT' => [
            'brand'         =>  'required',
            'type'          =>  'required',
            'category'      =>  'required',
            'name'          =>  'required|min:4|max:50',
            'description'   =>  '',
            'srp'           =>  'required|numeric|min:2',
            'cost'          =>  'required|numeric|min:2',
            'qty'           =>  'required|numeric',
            'images.*'      =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'names.*'       =>  'required',
            'description.*' =>  'required'
        ],
        'PATCH' => [
            'brand'         =>  'required',
            'type'          =>  'required',
            'category'      =>  'required',
            'name'          =>  'required|min:4|max:50',
            'description'   =>  '',
            'srp'           =>  'required|numeric|min:2',
            'cost'          =>  'required|numeric|min:2',
            'qty'           =>  'required|numeric',
            'images.*'      =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'names.*'       =>  'required',
            'description.*' =>  'required'
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

        if($this->method() == 'PATCH' || $this->method() == 'PUT')
        {
            return [
                'slug' => 'unique:items,slug,'.$this->route('model')
            ];
        }

        return $this->rules[$this->method()];
    }
}
