<?php

namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
            'first_name' => $this->type == 'individual' ? 'required|min:3' : 'nullable',
            'middle_name' => 'nullable',
            'last_name' => $this->type == 'individual' ? 'required|min:3' : 'nullable',
            'doc_type' => 'required',
            'email' => ['required', \Illuminate\Validation\Rule::unique('customers')->ignore($this->email)],
            'phone' => 'required|size:11|unique:customers',
            'alternative_phone' => 'required|size:11|unique:customers',
            'family_phone' => $this->type == 'individual' ? 'required|size:11|unique:customers' : 'nullable',
            'doc_nr' => ['required', \Illuminate\Validation\Rule::unique('customers')->ignore($this->doc_nr)],
            'nuit' => ['required', \Illuminate\Validation\Rule::unique('customers')->ignore($this->nuit)],
            'address' => 'required|min:3',
            'nationality' => 'required|min:3',
            'city' => 'required:min:4',
            // 'house_nr' => $this->type == 'individual' ? 'required|unique:customers' : 'nullable',
            'birthdate' => $this->type == 'individual' ? 'required|date' : 'nullable',
            'emission_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:emission_date',
            'activity' => $this->type == 'individual' ? 'required|in:own,employed' : 'nullable',
            'residence' => $this->type == 'individual' ? 'required|in:own, rent' : 'nullable',
            'type' => 'required|in:individual, company',
            'business_id' => 'required',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}