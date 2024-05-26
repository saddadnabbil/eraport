<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
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
            'username' => 'required|exists:user,username',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'exists' => 'The selected :attribute field is invalid.',
        ];
    }
}
