<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyUpdateRequest extends FormRequest
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
            'email' => 'required|email',
            'street' => 'required',
            'neighborhood' => 'required',
            'state_id' => 'required|required_with_all:city_id|exists:states,id',
            'city_id' => 'required|exists:cities,id,state_id,'.request('state_id'),
        ];
    }
}
