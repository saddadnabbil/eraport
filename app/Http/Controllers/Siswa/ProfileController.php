<?php

namespace App\Http\Controllers\Siswa;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $siswa = Siswa::findorfail($id);
    //     $validator = Validator::make($request->all(), [
    //         'nama_lengkap' => 'required|min:3|max:100',
    //         'jenis_kelamin' => 'required',
    //         'tempat_lahir' => 'required|min:3|max:50',
    //         'tanggal_lahir' => 'required',
    //         'agama' => 'required',
    //         'anak_ke' => 'required|numeric|digits_between:1,2',
    //         'status_dalam_keluarga' => 'required',
    //         'alamat' => 'required|min:3|max:255',
    //         'nomor_hp' => 'nullable|numeric|digits_between:11,13|unique:siswa,nomor_hp,' . $siswa->id,

    //         'nama_ayah' => 'required|min:3|max:100',
    //         'nama_ibu' => 'required|min:3|max:100',
    //         'pekerjaan_ayah' => 'required|min:3|max:100',
    //         'pekerjaan_ibu' => 'required|min:3|max:100',
    //         'nama_wali' => 'nullable|min:3|max:100',
    //         'pekerjaan_wali' => 'nullable|min:3|max:100',
    //     ]);
    //     if ($validator->fails()) {
    //         return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    //     } else {
    //         if ($request->has('avatar')) {
    //             $avatar_file = $request->file('avatar');
    //             $name_avatar = 'profile_' . strtolower($request->nama_lengkap) . '.' . $avatar_file->getClientOriginalExtension();
    //             $avatar_file->move('assets/dist/img/avatar/', $name_avatar);

    //             $data = [
    //                 'nama_lengkap' => strtoupper($request->nama_lengkap),
    //                 'tempat_lahir' => $request->tempat_lahir,
    //                 'tanggal_lahir' => $request->tanggal_lahir,
    //                 'jenis_kelamin' => $request->jenis_kelamin,
    //                 'agama' => $request->agama,
    //                 'status_dalam_keluarga' => $request->status_dalam_keluarga,
    //                 'anak_ke' => $request->anak_ke,
    //                 'alamat' => $request->alamat,
    //                 'nomor_hp' => $request->nomor_hp,
    //                 'nama_ayah' => $request->nama_ayah,
    //                 'nama_ibu' => $request->nama_ibu,
    //                 'pekerjaan_ayah' => $request->pekerjaan_ayah,
    //                 'pekerjaan_ibu' => $request->pekerjaan_ibu,
    //                 'nama_wali' => $request->nama_wali,
    //                 'pekerjaan_wali' => $request->pekerjaan_wali,
    //                 'avatar' => $name_avatar,
    //             ];
    //         } else {
    //             $data = [
    //                 'nama_lengkap' => strtoupper($request->nama_lengkap),
    //                 'tempat_lahir' => $request->tempat_lahir,
    //                 'tanggal_lahir' => $request->tanggal_lahir,
    //                 'jenis_kelamin' => $request->jenis_kelamin,
    //                 'agama' => $request->agama,
    //                 'status_dalam_keluarga' => $request->status_dalam_keluarga,
    //                 'anak_ke' => $request->anak_ke,
    //                 'alamat' => $request->alamat,
    //                 'nomor_hp' => $request->nomor_hp,
    //                 'nama_ayah' => $request->nama_ayah,
    //                 'nama_ibu' => $request->nama_ibu,
    //                 'pekerjaan_ayah' => $request->pekerjaan_ayah,
    //                 'pekerjaan_ibu' => $request->pekerjaan_ibu,
    //                 'nama_wali' => $request->nama_wali,
    //                 'pekerjaan_wali' => $request->pekerjaan_wali,
    //             ];
    //         }
    //         $siswa->update($data);
    //         return back()->with('toast_success', 'Profile anda berhasil diedit');
    //     }
    // }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findorfail($id);
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|min:3|max:100|unique:user,username,' . ($siswa->user->id ?? '') . ',id',
            'password' => 'nullable|min:8|max:255',

            'nama_lengkap' => 'required|min:3|max:100',
            'jenis_kelamin' => 'required|in:MALE,FEMALE',

            'nik' => 'unique:siswa,nik,' . $siswa->id,
            'tempat_lahir' => 'required|min:3|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:1,2,3,4,5,6,7',
            'alamat' => 'required|min:3|max:255',
            'nomor_hp' => 'nullable|numeric',
            'pas_photo' => 'nullable|image|max:2048', // Adjust the allowed file types and size as needed

            'nama_ayah' => 'required|min:3|max:100',
            'nama_ibu' => 'required|min:3|max:100',
            'pekerjaan_ayah' => 'required|min:3|max:100',
            'pekerjaan_ibu' => 'required|min:3|max:100',
            'nama_wali' => 'nullable|min:3|max:100',
            'pekerjaan_wali' => 'nullable|min:3|max:100',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            $password_baru = bcrypt($request->password_baru);
            $password_lama = bcrypt($request->password_lama);

            if (($password_baru != $siswa->user->password && $request->password_baru != null) || $request->username != null) {
                if ($password_lama != $siswa->user->password && $request->password_lama != null) {
                    return back()->with('toast_error', 'Password lama tidak sesuai');
                } else {
                    $user = User::findOrFail($siswa->user_id);

                    $user->password = $password_baru;
                    $user->username = $request->username;
                    $user->save();
                }
            }

            $data_siswa = [
                // information student
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'nama_panggilan' => $request->nama_panggilan,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'blood_type' => $request->blood_type,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'anak_ke' => $request->anak_ke,
                'jml_saudara_kandung' => $request->jml_saudara_kandung,
                'warga_negara' => $request->warga_negara,
                'pas_photo' => $request->pas_photo,

                // student medical condition information
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'spesial_treatment' => $request->spesial_treatment,
                'note_kesehatan' => $request->note_kesehatan,
                'file_document_kesehatan' => $request->file_document_kesehatan,
                'file_list_pertanyaan' => $request->file_list_pertanyaan,

                // domicile information
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'kode_pos' => $request->kode_pos,
                'jarak_rumah_ke_sekolah' => $request->jarak_rumah_ke_sekolah,
                'email' => $request->email,
                'email_parent' => $request->email_parent,
                'nomor_hp' => $request->nomor_hp,
                'tinggal_bersama' => $request->tinggal_bersama,
                'transportasi' => $request->transportasi,

                // parent information father
                'nik_ayah' => $request->nik_ayah,
                'nama_ayah' => $request->nama_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'nomor_hp_ayah' => $request->nomor_hp_ayah,
                'agama_ayah' => $request->agama_ayah,
                'kota_ayah' => $request->kota_ayah,
                'pendidikan_terakhir_ayah' => $request->pendidikan_terakhir_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'penghasil_ayah' => $request->penghasil_ayah,

                // parent information mother
                'nik_ibu' => $request->nik_ibu,
                'nama_ibu' => $request->nama_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'nomor_hp_ibu' => $request->nomor_hp_ibu,
                'agama_ibu' => $request->agama_ibu,
                'kota_ibu' => $request->kota_ibu,
                'pendidikan_terakhir_ibu' => $request->pendidikan_terakhir_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'penghasil_ibu' => $request->penghasil_ibu,

                // parent information guardian
                'nik_wali' => $request->nik_wali,
                'nama_wali' => $request->nama_wali,
                'tempat_lahir_wali' => $request->tempat_lahir_wali,
                'tanggal_lahir_wali' => $request->tanggal_lahir_wali,
                'alamat_wali' => $request->alamat_wali,
                'nomor_hp_wali' => $request->nomor_hp_wali,
                'agama_wali' => $request->agama_wali,
                'kota_wali' => $request->kota_wali,
                'pendidikan_terakhir_wali' => $request->pendidikan_terakhir_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,
                'penghasil_wali' => $request->penghasil_wali,

                'avatar' => 'default.png',
                'status' => 1,
            ];

            // Define the file fields and their corresponding subdirectories
            $fileFields = [
                'pas_photo' => 'pas_photo_siswa',
                'file_document_kesehatan' => 'documents_siswa',
                'file_list_pertanyaan' => 'documents_siswa',
                'file_dokument_sekolah_lama' => 'documents_siswa',
            ];

            // Handle file uploads using a loop
            foreach ($fileFields as $field => $subdirectory) {
                $data_siswa[$field] = $this->handleFileUpload($request, $siswa, $field, $subdirectory);
            }
            $siswa->update($data_siswa);

            return back()->with('toast_success', 'Siswa berhasil diedit');
        }
    }
    private function handleFileUpload($request, $model, $fileField, $subdirectory)
    {
        if ($request->hasFile($fileField)) {
            // Delete the old file
            if ($model->$fileField) {
                Storage::disk('public')->delete($model->$fileField);
            }

            // Store the new file
            $file = $request->file($fileField);
            return $file->store($subdirectory, 'public'); // Adjust the storage path as needed
        }

        return $model->$fileField; // Return the existing file path if no new file is uploaded
    }
}
