<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'company'       =>  'required|min:2|max:100',
            'ref_no'        =>  'nullable',
            'supplier'      =>  'required|min:2|max:255',
            'term'          =>  'nullable',
            'delivery_date' =>  'nullable',
            'po_valid'      =>  'nullable',
            'ship_to'       =>  'required|min:5|max:191',
            'location'      =>  'required|min:5|max:191',
            'preparedBy'    =>  'required|min:2|max:191',
            'notedBy'       =>  'required|min:2|max:191'
        ];
    }
}
