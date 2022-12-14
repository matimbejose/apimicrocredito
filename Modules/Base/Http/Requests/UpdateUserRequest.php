<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', \Illuminate\Validation\Rule::unique('users')->ignore($this->user)],
            'password_confirmation' => 'same:password',
            'surname' => 'required',
            'username' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name' => 'O campo senha e obrigatorio.',
            'password' => 'O campo senha e obrigatorio.',
            'password' => 'O campo senha e obrigatorio.',
            // 'description.min'  => 'description minimum length bla bla bla'
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}