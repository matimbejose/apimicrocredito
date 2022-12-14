<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => ['required', \Illuminate\Validation\Rule::unique('roles')->ignore($this->role)]
        ];
    }

    public function messages()
    {
        return [
            'name' => 'O campo senha e obrigatorio.',
           // 'description.min'  => 'description minimum length bla bla bla'
        ];
    }

    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}
