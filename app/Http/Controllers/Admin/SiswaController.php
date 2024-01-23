<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\User;
use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\SiswaKeluar;
use App\AnggotaKelas;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\AnggotaEkstrakulikuler;
use App\Http\Controllers\Controller;
use App\Tingkatan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $jumlah_kelas = Kelas::where('tapel_id', $tapel->id)->count();

        if ($jumlah_kelas == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {

            $jumlah_kelas_play_group = Kelas::where('tapel_id', $tapel->id)
                ->where('tingkatan_id', '1')
                ->count();
            $jumlah_kelas_kinder_garten = Kelas::where('tapel_id', $tapel->id)
                ->where('tingkatan_id', '2')
                ->count();
            $jumlah_kelas_primary_school = Kelas::where('tapel_id', $tapel->id)
                ->where('tingkatan_id', '3')
                ->count();
            $jumlah_kelas_junior_high_school = Kelas::where('tapel_id', $tapel->id)
                ->where('tingkatan_id', '4')
                ->count();
            $jumlah_kelas_senior_high_school = Kelas::where('tapel_id', $tapel->id)
                ->where('tingkatan_id', '5')
                ->count();

            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();

            $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');
            $data_kelas_terendah = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', $tingkatan_terendah)->orderBy('tingkatan_id', 'ASC')->get();
            $data_kelas_all = Kelas::where('tapel_id', $tapel->id)->orderBy('tingkatan_id', 'ASC')->get();
            // $data_siswa = Siswa::where('status', 1)->orderBy('nis', 'ASC')->get();
            $data_siswa = Siswa::orderBy('kelas_id', 'DESC')->orderBy('status', 'DESC')->get();
            return view('admin.siswa.index', compact('title', 'data_kelas_all', 'data_kelas_terendah', 'data_siswa', 'tingkatan_akhir', 'jumlah_kelas', 'jumlah_kelas_play_group', 'jumlah_kelas_kinder_garten', 'jumlah_kelas_primary_school', 'jumlah_kelas_junior_high_school', 'jumlah_kelas_senior_high_school', 'data_tingkatan'));
        }
    }

    public function show($id)
    {
        $siswa = Siswa::findorfail($id);
        $title = 'Detail Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();

        $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
        $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');
        $data_kelas_terendah = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', $tingkatan_terendah)->orderBy('tingkatan_id', 'ASC')->get();
        $data_kelas_all = Kelas::where('tapel_id', $tapel->id)->orderBy('tingkatan_id', 'ASC')->get();

        return view('admin.siswa.show', compact('title', 'siswa', 'tingkatan_akhir', 'data_kelas_all', 'data_kelas_terendah', 'data_tingkatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lengkap' => 'required|min:3|max:100',
                'jenis_kelamin' => 'required|in:Male,Female',
                'jenis_pendaftaran' => 'required|in:1,2',
                'kelas_id' => 'required|exists:kelas,id',
                'nis' => 'required|numeric|digits_between:1,10|unique:siswa',
                'nisn' => 'nullable|numeric|digits:10|unique:siswa',
                'tempat_lahir' => 'required|min:3|max:50',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|in:1,2,3,4,5,6,7',
                'alamat' => 'required|min:3|max:255',
                'nomor_hp' => 'nullable|numeric|digits_between:11,13|unique:siswa',
                'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed file types and size as needed

                'nama_ayah' => 'required|min:3|max:100',
                'nama_ibu' => 'required|min:3|max:100',
                'pekerjaan_ayah' => 'required|min:3|max:100',
                'pekerjaan_ibu' => 'required|min:3|max:100',
                'nama_wali' => 'nullable|min:3|max:100',
                'pekerjaan_wali' => 'nullable|min:3|max:100',
            ]
        );
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            try {
                $user = new User([
                    'username' => strtolower(str_replace(' ', '', $request->nama_lengkap . $request->nis)),
                    'password' => bcrypt('123456'),
                    'role' => 3,
                    'status' => true
                ]);
                $user->save();
            } catch (\Throwable $th) {
                return back()->with('toast_error', 'Username telah digunakan');
            }

            $siswa = new Siswa([
                'user_id' => $user->id,
                'tingkatan_id' => $request->kelas_id,
                'jurusan_id' => $request->kelas_id,
                'kelas_id' => $request->kelas_id,
                'jenis_pendaftaran' => $request->jenis_pendaftaran,

                // information student
                'nik' => $request->nik,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
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

                // previously formal school
                'tanggal_masuk_sekolah_lama' => $request->tanggal_masuk_sekolah_lama,
                'tanggal_keluar_sekolah_lama' => $request->tanggal_keluar_sekolah_lama,
                'nama_sekolah_lama' => $request->nama_sekolah_lama,
                'alamat_lama' => $request->alamat_lama,
                'no_sttb' => $request->no_sttb,
                'nem' => $request->nem,
                'file_dokument_sekolah_lama' => $request->file_dokument_sekolah_lama,

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
            ]);

            if ($request->hasFile('pas_photo')) {
                $file = $request->file('pas_photo');
                $path = $file->store('siswa', 'public'); // Adjust the storage path as needed
                $siswa->pas_photo = $path;
            }

            $siswa->save();

            $anggota_kelas = new AnggotaKelas([
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'pendaftaran' => $request->jenis_pendaftaran,
            ]);
            $anggota_kelas->save();

            return back()->with('toast_success', 'Siswa berhasil ditambahkan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findorfail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'nullable|min:3|max:100|unique:user,username,' . ($siswa->user->id ?? '') . ',id',
                'password' => 'nullable|min:8|max:255',

                'nama_lengkap' => 'required|min:3|max:100',
                'jenis_kelamin' => 'required|in:Male,Female',
                'jenis_pendaftaran' => 'required|in:1,2',
                'kelas_id' => 'required|exists:kelas,id',
                'nis' => 'required',
                'nisn' => 'nullable|numeric|digits:10|unique:siswa,nisn,' . $siswa->id,
                'tempat_lahir' => 'required|min:3|max:50',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|in:1,2,3,4,5,6,7',
                'alamat' => 'required|min:3|max:255',
                'nomor_hp' => 'nullable|numeric',
                'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed file types and size as needed

                'nama_ayah' => 'required|min:3|max:100',
                'nama_ibu' => 'required|min:3|max:100',
                'pekerjaan_ayah' => 'required|min:3|max:100',
                'pekerjaan_ibu' => 'required|min:3|max:100',
                'nama_wali' => 'nullable|min:3|max:100',
                'pekerjaan_wali' => 'nullable|min:3|max:100',
            ]
        );
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $password_baru = bcrypt($request->password_baru);
            $password_lama = bcrypt($request->password_lama);

            if ($password_baru != $siswa->user->password && $request->password_baru != null || $request->username != null) {
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
                'tingkatan_id' => $request->kelas_id,
                'jurusan_id' => $request->kelas_id,
                'kelas_id' => $request->kelas_id,
                'jenis_pendaftaran' => $request->jenis_pendaftaran,

                // information student
                'nik' => $request->nik,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
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

                // previously formal school
                'tanggal_masuk_sekolah_lama' => strtotime($request->tanggal_masuk_sekolah_lama),
                'tanggal_keluar_sekolah_lama' => strtotime($request->tanggal_keluar_sekolah_lama),
                'nama_sekolah_lama' => $request->nama_sekolah_lama,
                'alamat_lama' => $request->alamat_lama,
                'no_sttb' => $request->no_sttb,
                'nem' => $request->nem,
                'file_dokument_sekolah_lama' => $request->file_dokument_sekolah_lama,

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

            if ($request->kelas_id != $siswa->kelas->id) {
                $anggota_kelas = new AnggotaKelas([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $request->kelas_id,
                    'pendaftaran' => $request->jenis_pendaftaran,
                ]);
                $anggota_kelas->save();
            }

            $siswa->update($data_siswa);

            return back()->with('toast_success', 'Siswa berhasil diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_siswa = Siswa::findorfail($id);
        $data_user = User::findorfail($data_siswa->user_id);

        $data_anggota_kelas = AnggotaKelas::where('siswa_id', $data_siswa->id)->get();
        if ($data_anggota_kelas->count() == 0) {
            $data_siswa->delete();
            $data_user->delete();
            return back()->with('toast_success', 'Siswa berhasil dihapus');
        } elseif ($data_anggota_kelas->count() == 1) {
            try {
                $anggota_kelas = AnggotaKelas::where('siswa_id', $data_siswa->id)->first();
                $anggota_kelas->delete();
                $data_siswa->delete();
                $data_user->delete();
                return back()->with('toast_success', 'Siswa berhasil dihapus');
            } catch (\Throwable $th) {
                return back()->with('toast_error', 'Data siswa tidak dapat dihapus');
            }
        } else {
            return back()->with('toast_error', 'Data siswa tidak dapat dihapus');
        }
    }

    public function export()
    {
        $filename = 'data_siswa ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new SiswaExport, $filename);
    }

    public function format_import()
    {
        $file = public_path() . "/format_import/format_import_siswa.xls";
        $headers = array(
            'Content-Type: application/xls',
        );
        return Response::download($file, 'format_import_siswa ' . date('Y-m-d H_i_s') . '.xls', $headers);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new SiswaImport, $request->file('file_import'));
            return back()->with('toast_success', 'Data siswa berhasil diimport');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Maaf, format data tidak sesuai');
        }
    }

    public function registrasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required',
            'keluar_karena' => 'required|max:30',
            'tanggal_keluar' => 'required',
            'alasan_keluar' => 'nullable|max:255',

        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $siswa = Siswa::findorfail($request->siswa_id);
            $anggota_kelas = AnggotaKelas::where('siswa_id', $siswa->id)->where('kelas_id', $siswa->kelas_id)->first();


            $siswa_keluar = new SiswaKeluar([
                'siswa_id' => $request->input('siswa_id'),
                'keluar_karena' => $request->input('keluar_karena'),
                'tanggal_keluar' => $request->input('tanggal_keluar'),
                'alasan_keluar' => $request->input('alasan_keluar'),
            ]);
            $siswa_keluar->save();

            if ($request->keluar_karena == 'Lulus') {
                $update_siswa = [
                    'kelas_id' => null,
                    'status' => 3
                ];
            } else {
                $update_siswa = [
                    'status' => 2
                ];
            }
            $siswa->update($update_siswa);
            User::findorfail($siswa->user_id)->update(['status' => false]);
            return redirect('admin/siswa')->with('toast_success', 'Siswa berhasil dinonaktifkan');
        }
    }

    public function activate(Request $request)
    {
        $id = $request->input('id');
        $siswa = Siswa::findorfail($id);
        $siswa->update(['status' => 1]);
        $siswa->user->update(['status' => 1]);

        $siswa_keluar = SiswaKeluar::where('siswa_id', $id)->firstOrFail();
        $siswa_keluar->delete();

        return back()->with('toast_success', 'Siswa ' . $siswa->nama_lengkap . ' telah memberhasil diaktifkan');
    }
}
