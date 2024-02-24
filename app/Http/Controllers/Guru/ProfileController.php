<?php

namespace App\Http\Controllers\Guru;

use App\Models\Guru;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
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
    //     $guru = Guru::findorfail($id);
    //     $validator = Validator::make($request->all(), [
    //         'nama_lengkap' => 'required|min:3|max:100',
    //         'gelar' => 'required|min:3|max:10',
    //         'nip' => 'nullable|digits:18|unique:guru,nip' . $guru->id,
    //         'jenis_kelamin' => 'required',
    //         'tempat_lahir' => 'required|min:3',
    //         'tanggal_lahir' => 'required',
    //         'nuptk' => 'nullable|digits:16|unique:guru,nuptk' . $guru->id,
    //         'alamat' => 'required|min:4|max:255',
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
    //                 'gelar' => $request->gelar,
    //                 'nip' => $request->nip,
    //                 'jenis_kelamin' => $request->jenis_kelamin,
    //                 'tempat_lahir' => $request->tempat_lahir,
    //                 'tanggal_lahir' => $request->tanggal_lahir,
    //                 'nuptk' => $request->nuptk,
    //                 'alamat' => $request->alamat,
    //                 'avatar' => $name_avatar,
    //             ];
    //         } else {
    //             $data = [
    //                 'nama_lengkap' => strtoupper($request->nama_lengkap),
    //                 'gelar' => $request->gelar,
    //                 'nip' => $request->nip,
    //                 'jenis_kelamin' => $request->jenis_kelamin,
    //                 'tempat_lahir' => $request->tempat_lahir,
    //                 'tanggal_lahir' => $request->tanggal_lahir,
    //                 'nuptk' => $request->nuptk,
    //                 'alamat' => $request->alamat,
    //             ];
    //         }
    //         $guru->update($data);
    //         return back()->with('toast_success', 'Profile anda berhasil diedit');
    //     }
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        // Find the Karyawan instance by ID
        $karyawan = Karyawan::findOrFail($id);

        if ($request->username != $karyawan->user->username) {
            // check username
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username,' . $karyawan->user->id,
                ]);
                if ($validator->fails()) {
                    return back()
                        ->with('toast_error', $validator->messages()->all()[0])
                        ->withInput();
                }

                $karyawan->user->update([
                    'username' => $request->username,
                ]);
            } else {
                return back()->with('toast_error', 'Username ' . $request->username . ' sudah ada, silahkan gunakan username lain');
            }
        }

        if ($request->old_password && $request->new_password) {
            $validator = Validator::make($request->all(), [
                'old_password' => ['required', new MatchOldPassword()],
                'new_password' => ['required', 'min:8'],
            ]);
            if ($validator->fails()) {
                return back()
                    ->with('toast_error', $validator->messages()->all()[0])
                    ->withInput();
            }
            $karyawan->user->update([
                'password' => bcrypt($request->new_password),
            ]);
        }

        // Update the Karyawan instance with the new request data
        $karyawan->update([
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

        // Save the Karyawan instance to the database
        $karyawan->save();

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' berhasil diperbarui');
    }

    private function updateUploadedFiles(Request $request, Karyawan $karyawan)
    {
        // Handle and update the uploaded files (if any) associated with the Karyawan model
        // Example: Assuming 'pas_photo' is the name of the file input for pas_photo
        $this->updatePhoto('pas_photo', $request, $karyawan, 'pas_photo');

        // Repeat the process for other uploaded files
        // Example: 'photo_kartu_identitas', 'photo_taxpayer', 'photo_kk', 'other_document', etc.

        $this->updatePhoto('photo_kartu_identitas', $request, $karyawan, 'photo_kartu_identitas');
        $this->updatePhoto('photo_taxpayer', $request, $karyawan, 'photo_taxpayer');
        $this->updatePhoto('photo_kk', $request, $karyawan, 'photo_kk');
        $this->updatePhoto('other_document', $request, $karyawan, 'other_document');
    }

    private function updatePhoto($inputName, Request $request, Karyawan $karyawan, $attributeName)
    {
        if ($request->hasFile($inputName)) {
            // Delete the existing file if it exists
            if ($karyawan->$attributeName) {
                Storage::disk('public')->delete($karyawan->$attributeName);
            }

            $photo = $request->file($inputName);
            $photoPath = $photo->store($attributeName, 'public'); // Assuming $attributeName is your storage disk

            // Update the file path to the model attribute
            $karyawan->$attributeName = $photoPath;
        }
    }
}
