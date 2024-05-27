<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
            'nama_lengkap' => 'required|min:3|max:100',
            'jenis_kelamin' => 'required|in:MALE,FEMALE',
            'jenis_pendaftaran' => 'required|in:1,2',
            'jenis_pendaftaran' => 'required|in:1,2',
            'semester_masuk' => 'required',

            'kelas_id' => 'required|exists:kelas,id',
            'nik' => 'unique:siswa',
            'nis' => 'required|numeric|digits_between:1,10|unique:siswa',
            'nisn' => 'nullable|numeric|digits:10|unique:siswa',
            'tempat_lahir' => 'required|min:3|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:1,2,3,4,5,6,7',
            'alamat' => 'required|min:3|max:255',
            'nomor_hp' => 'nullable|numeric|digits_between:11,13|unique:siswa',
            'pas_photo' => 'nullable|image|max:2048',
            'nama_ayah' => 'required|min:3|max:100',
            'nama_ibu' => 'required|min:3|max:100',
            'pekerjaan_ayah' => 'required|min:3|max:100',
            'pekerjaan_ibu' => 'required|min:3|max:100',
            'nama_wali' => 'nullable|min:3|max:100',
            'pekerjaan_wali' => 'nullable|min:3|max:100',
        ];
    }
}
