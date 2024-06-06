<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreTingkatanRequest extends FormRequest
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
            'nama_tingkatan' => 'required|string|max:255',
            'term_id' => 'required|exists:terms,id',
            'semester_id' => 'required|exists:semesters,id',
            'sekolah_id' => 'required|exists:sekolah,id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field cannot be more than :max characters.',
            'exists' => 'The selected :attribute field is invalid.',
        ];
    }
}
