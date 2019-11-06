<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    protected $methods = [
        'POST'  =>  [
            'name'          =>  'required|unique:brands|min:2:max:30',
            'description'   =>  'required|min:2|max:100',
            'logo'          =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=500',
        ],
        'PUT'   =>  [
            // 'name'          =>  'required|unique:brands|min:2:max:30',
            'description'   =>  'required|min:2|max:100',
            'logo'          =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=500',
        ],
        'PATCH' =>  [
            'description'   =>  'required|min:2|max:100',
            'logo'          =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=500',
        ],
        'DELETE' => [],
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
        if($this->method() == 'PUT')
        {
            return [
                'name'          =>  'required|min:2:max:30|unique:brands,name,'. $this->brand->id,
            ];
        }
        
        return $this->methods[$this->method()];
    }
}
