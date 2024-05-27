<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
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
            'role' => 'required|array',
            'role*' => 'required|exists:roles,id',
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
            'pas_photo' => 'nullable|image|max:2048', // Maksimum 2 MB
            'photo_kartu_identitas' => 'nullable|image|max:2048',
            'photo_taxpayer' => 'nullable|image|max:2048',
            'photo_kk' => 'nullable|image|max:2048',
            'other_document' => 'nullable|image|max:2048',
        ];
    }

    // message in english
    public function messages()
    {
        return [
            'role.*' => 'Role is required',
            'status_karyawan_id.*' => 'Status karyawan is required',
            'unit_karyawan_id.*' => 'Unit karyawan is required',
            'position_karyawan_id.*' => 'Position karyawan is required',
            'resign_date.*' => 'Resign date is required',
            'join_date.*' => 'Join date is required',
            'permanent_date.*' => 'Permanent date is required',
            'kode_karyawan.*' => 'Kode karyawan is required',
            'nik.*' => 'NIK is required',
            'nomor_bpjs_ketenagakerjaan.*' => 'Nomor BPJS Ketenagakerjaan is required',
            'iuran_bpjs_ketenagakerjaan.*' => 'Iuran BPJS Ketenagakerjaan is required',
            'nomor_bpjs_yayasan.*' => 'Nomor BPJS Yayasan is required',
            'nomor_bpjs_pribadi.*' => 'Nomor BPJS Pribadi is required',
            'tempat_lahir.*' => 'Tempat lahir is required',
            'tanggal_lahir.*' => 'Tanggal lahir is required',
            'nomor_phone.*' => 'Nomor phone is required',
            'nomor_hp.*' => 'Nomor hp is required',
            'email.*' => 'Email is required',
            'email_sekolah.*' => 'Email sekolah is required',
            'warga_negara.*' => 'Warga negara is required',
            'status_pernikahan.*' => 'Status pernikahan is required',
            'photo_kartu_identitas.*' => 'Photo kartu identitas is required',
            'photo_taxpayer.*' => 'Photo taxpayer is required',
            'photo_kk.*' => 'Photo kk is required',
            'other_document.*' => 'Other document is required',
        ];
    }
}
