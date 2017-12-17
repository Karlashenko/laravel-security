<?php

namespace Phrantiques\Security\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'         => 'required|string|min:3|regex:/^[a-z_]*$/|unique:roles',
            'display_name' => 'string',
            'description'  => 'string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Параметр ":attribute" является обязательным.',
            'string'   => 'Параметр ":attribute" должен быть строкой.',
            'min'      => 'Параметр ":attribute" должен состоять не менее чем из :min символов.',
            'regex'    => 'Параметр ":attribute" может собержать только латинские буквы и нижнее подчеркивание.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'         => 'Ключ',
            'display_name' => 'Название',
            'description'  => 'Описание',
        ];
    }
}
