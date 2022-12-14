<?php

namespace Modules\Managers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateManagerRequest extends FormRequest
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
            'first_name' => 'required|min:3', 
            'middle_name' => 'nullable',
            'last_name' => 'required|min:3', 
            'email' => 'required|email|unique:managers', 
            'phone' => 'required|size:11|unique:managers',
            'address' => 'required|min:3',
            'city' => 'required:min:4',
            'business_id' => 'required',
    
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
