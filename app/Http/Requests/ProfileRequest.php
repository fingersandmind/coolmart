<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    protected $rules = [
        'POST' => [
            'title'     =>  'sometimes|min:2|max:20',
            'phone'     =>  'sometimes|between:1,15',
            'about'     =>  'sometimes|min:2|max:200',
            'image'     =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'facebook'  =>  'nullable',
            'twitter'   =>  'nullable',
            'instagram' =>  'nullable',
        ],
        'PUT' => [
            'title'     =>  'sometimes|min:2|max:20',
            'phone'     =>  'sometimes|between:1,15',
            'about'     =>  'sometimes|min:2|max:200',
            'image'     =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'facebook'  =>  'nullable',
            'twitter'   =>  'nullable',
            'instagram' =>  'nullable',
        ],
        'PATCH' => [
            'title'     =>  'sometimes|min:2|max:20',
            'phone'     =>  'sometimes|between:1,15',
            'about'     =>  'sometimes|min:2|max:200',
            'image'     =>  'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=50, min_height=50, max_width=1000, max_height=1000',
            'facebook'  =>  'nullable',
            'twitter'   =>  'nullable',
            'instagram' =>  'nullable',
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
        return $this->rules[$this->method()];
    }
}
