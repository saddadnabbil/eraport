<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthRequest extends FormRequest
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
            'password_lama' => ['required', new MatchOldPassword()],
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ];
    }
    
    // message in english 
    public function messages()
    {
        return [
            'password_lama.required' => 'The current password field is required.',
            'password_baru.required' => 'The new password field is required.',
            'konfirmasi_password.required' => 'The confirmation password field is required.',
            'password_baru.min' => 'The new password must be at least 6 characters.',
            'konfirmasi_password.same' => 'The confirmation password does not match.',
        ];
    }
}
