<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryawanRequest extends FormRequest
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
            'password_lama' => ['nullable', new MatchOldPassword()],
            'password_baru' => ['nullable', Password::min(8)->numbers()],
            'status_karyawan_id' => 'required|exists:status_karyawans,id',
            'unit_karyawan_id' => 'required|exists:unit_karyawans,id',
            'position_karyawan_id' => 'required|exists:position_karyawans,id',
            'resign_date' => 'nullable|date',
            'join_date' => 'required|date',
            'permanent_date' => 'nullable|date',
            'kode_karyawan' => 'required|string|max:25',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'nomor_akun' => 'nullable|string|max:255',
            'nomor_fingerprint' => 'required|integer',
            'nomor_taxpayer' => 'nullable|string|max:255',
            'nama_taxpayer' => 'nullable|string|max:255',
            'nomor_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'iuran_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'nomor_bpjs_yayasan' => 'nullable|string|max:255',
            'nomor_bpjs_pribadi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:MALE,FEMALE',
            'agama' => 'required|in:1,2,3,4,5,6,7',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'alamat_sekarang' => 'nullable|string',
            'kota' => 'nullable|string',
            'kode_pos' => 'nullable|integer',
            'nomor_phone' => 'nullable|string',
            'nomor_hp' => 'required|string',
            'email' => 'required|email',
            'email_sekolah' => 'nullable|email',
            'warga_negara' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'nama_pasangan' => 'nullable|string|max:255',
            'jumlah_anak' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_taxpayer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    // message english

    public function messages()
    {
        return [
            'password_lama.required' => 'The current password field is required.',
            'password_lama.match_old_password' => 'The current password is incorrect.',
            'password_baru.required' => 'The new password field is required.',
            'password_baru.min' => 'The new password must be at least 8 characters.',
            'password_baru.numeric' => 'The new password must be numeric.',
            'status_karyawan_id.required' => 'The status karyawan field is required.',
            'unit_karyawan_id.required' => 'The unit karyawan field is required.',
            'position_karyawan_id.required' => 'The position karyawan field is required.',
            'resign_date.date' => 'The resign date must be a valid date.',
            'join_date.required' => 'The join date field is required.',
            'permanent_date.date' => 'The permanent date must be a valid date.',
            'kode_karyawan.required' => 'The employee code field is required.',
            'kode_karyawan.max' => 'The employee code may not be greater than 25 characters.',
            'nik.required' => 'The nik field is required.',
            'nik.size' => 'The nik must be 16 characters.',
            'nomor_bpjs_ketenagakerjaan.max' => 'The nomor bpjs ketenagakerjaan may not be greater than 255 characters.',
            'nomor_bpjs_yayasan.max' => 'The nomor bpjs yayasan may not be greater than 255 characters.',
            'nomor_bpjs_pribadi.max' => 'The nomor bpjs pribadi may not be greater than 255 characters.',
            'tempat_lahir.required' => 'The tempat lahir field is required.',
            'tempat_lahir.max' => 'The tempat lahir may not be greater than 50 characters.',
            'tanggal_lahir.required' => 'The field is required.',
            'nomor_phone.max' => 'The nomor phone may not be greater than 255 characters.',
            'nomor_hp.required' => 'The nomor hp field is required.',
            'nomor_hp.max' => 'The nomor hp may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email_sekolah.email' => 'The email sekolah must be a valid email address.',
            'email_sekolah.max' => 'The email sekolah may not be greater than 255 characters.',
            'warga_negara.max' => 'The warga negara may not be greater than 255 characters.',
            'status_pernikahan.max' => 'The status pernikahan may not be greater than 255 characters.',
            'nama_pasangan.max' => 'The nama pasangan may not be greater than 255 characters.',
            'jumlah_anak.max' => 'The jumlah anak may not be greater than 255 characters.', 
            'keterangan.max' => 'The keterangan may not be greater than 255 characters.',
            'other_document.max' => 'The other document may not be greater than 255 characters.',
            'photo_kartu_identitas.image' => 'The photo kartu identitas must be an image.',
            'photo_taxpayer.image' => 'The photo taxpayer must be an image.',
            'photo_kk.image' => 'The photo kk must be an image.',
            'other_document.image' => 'The other document must be an image.',
        ];
    }
    
}
