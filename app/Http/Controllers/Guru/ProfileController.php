<?php

namespace App\Http\Controllers\Guru;

use App\Models\Guru;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateKaryawanRequest;

class ProfileController extends Controller
{
    public function update(UpdateKaryawanRequest $request, $id)
    {
        // Find the Karyawan instance by ID
        $karyawan = Karyawan::findOrFail($id);

        $user = User::findOrFail($karyawan->user_id);

        $user->username = $request->username;

        if ($request->password_baru && $request->password_lama) {
            $user->password = Hash::make($request->password_baru);
        }
        $user->save();

        // Mengupdate role
        if ($request->has('role')) {
            $roles = Role::whereIn('id', $request->role)->get();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]);
        }

        // Mengupdate status
        $karyawan->user->status = $request->status;
        $karyawan->user->save();

        // Update the Karyawan instance with the new request data
        $karyawan->update([
            'user_id' => $user->id,
            'status_karyawan_id' => $request->status_karyawan_id,
            'unit_karyawan_id' => $request->unit_karyawan_id,
            'position_karyawan_id' => $request->position_karyawan_id,
            'resign_date' => $request->resign_date,
            'join_date' => $request->join_date,
            'permanent_date' => $request->permanent_date,
            'kode_karyawan' => $request->kode_karyawan,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_akun' => $request->nomor_akun,
            'nomor_fingerprint' => $request->nomor_fingerprint,
            'nomor_taxpayer' => $request->nomor_taxpayer,
            'nama_taxpayer' => $request->nama_taxpayer,
            'nomor_bpjs_ketenagakerjaan' => $request->nomor_bpjs_ketenagakerjaan,
            'iuran_bpjs_ketenagakerjaan' => $request->iuran_bpjs_ketenagakerjaan,
            'nomor_bpjs_yayasan' => $request->nomor_bpjs_yayasan,
            'nomor_bpjs_pribadi' => $request->nomor_bpjs_pribadi,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'alamat_sekarang' => $request->alamat_sekarang,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'nomor_phone' => $request->nomor_phone,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'email_sekolah' => $request->email_sekolah,
            'warga_negara' => $request->warga_negara,
            'status_pernikahan' => $request->status_pernikahan,
            'nama_pasangan' => $request->nama_pasangan,
            'jumlah_anak' => $request->jumlah_anak,
            'keterangan' => $request->keterangan,
        ]);

        // Optionally, you can update and save any uploaded files to the model
        $this->updateUploadedFiles($request, $karyawan);

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' berhasil diperbarui');
    }

    private function updateUploadedFiles(Request $request, Karyawan $karyawan)
    {
        if ($request->hasFile('pas_photo')) {
            $this->deletePhoto($karyawan->pas_photo); // Hapus foto lama sebelum menyimpan yang baru
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $this->updatePhoto($pasPhoto, 'karyawan', $request->kode_karyawan, '.jpg');
            $karyawan->pas_photo = $pasPhotoPath;
        }

        $this->updatePhotoField('photo_kartu_identitas', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('photo_taxpayer', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('photo_kk', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('other_document', $request, $karyawan, $request->kode_karyawan, '.jpg');

        $karyawan->save();
    }

    private function deletePhoto($path)
    {
        // Hapus foto dari penyimpanan
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function updatePhoto($file, $field, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $kodeKaryawan . $extension;
        return $file->storeAs('karyawan', $filename, 'public');
    }

    private function updatePhotoField($inputName, Request $request, Karyawan $karyawan, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $kodeKaryawan, $extension);
            $karyawan->$inputName = $path;
        }
    }

    private function savePhoto($file, $field, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $kodeKaryawan . $extension;
        return $file->storeAs($field, $filename, 'public');
    }
}
