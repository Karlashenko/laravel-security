<?php

namespace Phrantiques\Security\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class PolicyFormRequest extends FormRequest
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
            'name'       => 'required',
            'subject'    => 'required',
            'resource'   => 'required',
            'properties' => 'required',
            'action'     => 'required',
            'algorithm'  => 'required',
            'rules'      => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'       => 'Название',
            'subject'    => 'Субъект',
            'resource'   => 'Ресурс',
            'properties' => 'Атрибуты',
            'action'     => 'Действие',
            'algorithm'  => 'Алгоритм',
            'rules'      => 'Правила',
        ];
    }
}
