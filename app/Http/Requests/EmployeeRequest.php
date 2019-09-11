<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'string',
            'gender' => 'required|in:male,female',
            'wage' => 'integer|max:4294967295|min:0',
            'departments' => 'required|array',
            'departments.*' => 'integer|exists:departments,id'
        ];
    }
}
