<?php

namespace App\Http\Controllers\Siswa;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(UpdateSiswaRequest $request, $id)
    {
        $siswa = Siswa::findorfail($id);

        $user = User::findOrFail($siswa->user_id);
        $user->username = $request->username;

        if ($request->password_baru && $request->password_baru != null && $request->password_lama) {
            if (Hash::check($request->password_lama, $user->password)) {
                $user->password = Hash::make($request->password_baru);
            } else {
                return redirect()->back()->with('error', 'Password lama tidak sesuai');
            }
        }
        $user->save();

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

        $siswa->update($data_siswa);
        // Optionally, you can update and save any uploaded files to the model
        $this->updateUploadedFiles($request, $siswa);

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Siswa ' . $request->nama_lengkap . ' berhasil diperbarui');
    }

    private function updateUploadedFiles(Request $request, Siswa $siswa)
    {
        if ($request->hasFile('pas_photo')) {
            $this->deletePhoto($siswa->pas_photo); // Hapus foto lama sebelum menyimpan yang baru
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $this->updatePhoto($pasPhoto, 'siswa', $request->nis, '.jpg');
            $siswa->pas_photo = $pasPhotoPath;
        }

        $this->updatePhotoField('file_document_kesehatan', $request, $siswa, $request->nis, '.jpg');
        $this->updatePhotoField('file_list_pertanyaan', $request, $siswa, $request->nis, '.jpg');
        $this->updatePhotoField('file_dokument_sekolah_lama', $request, $siswa, $request->nis, '.jpg');
        $siswa->save();
    }

    private function deletePhoto($path)
    {
        // Hapus foto dari penyimpanan
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function updatePhoto($file, $field, $nis, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $nis . $extension;
        return $file->storeAs('siswa', $filename, 'public');
    }

    private function updatePhotoField($inputName, Request $request, Siswa $siswa, $nis, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $nis, $extension);
            $siswa->$inputName = $path;
        }
    }

    private function savePhoto($file, $field, $nis, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $nis . $extension;
        return $file->storeAs($field, $filename, 'public');
    }
}
