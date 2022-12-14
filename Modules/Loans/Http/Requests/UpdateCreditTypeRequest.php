<?php

namespace Modules\Loans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditTypeRequest extends FormRequest
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
            'name' => ['required', \Illuminate\Validation\Rule::unique('credit_types')->ignore($this->name)] ,
            'tax' => ['required', \Illuminate\Validation\Rule::unique('credit_types')->ignore($this->tax)]
    
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
