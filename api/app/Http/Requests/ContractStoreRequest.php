<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractStoreRequest extends FormRequest
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
            'hirer_type' => 'required',
            'hirer_document' => 'required|regex:/^([0-9]*)$/',
            'hirer_email' => 'required|email',
            'hirer_name' => 'required',
            'property_id' => 'required|unique:contracts|exists:properties,id'
        ];
    }
}
