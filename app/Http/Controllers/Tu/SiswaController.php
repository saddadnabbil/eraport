<?php

namespace App\Http\Controllers\Tu;

use Excel;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Jurusan;
use App\Models\Tingkatan;
use App\Models\SiswaKeluar;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateSiswaRequest;
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
        $title = 'Student Data';
        $tapel = Tapel::where('status', 1)->first();
        $tingkatanIds = [1, 2, 3, 4, 5, 6];

        $jumlah_kelas = Kelas::where('tapel_id', $tapel->id)->count();

        if ($jumlah_kelas == 0) {
            return redirect()->back()->with('toast_warning', 'Mohon isikan data kelas');
        } else {

            $jumlah_kelas_per_level = Siswa::select('tingkatan_id', DB::raw('count(*) as total'))
                ->where('status', 1)
                ->whereIn('tingkatan_id', $tingkatanIds)
                ->groupBy('tingkatan_id')
                ->get()
                ->pluck('total', 'tingkatan_id');

            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
            $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();
            $data_kelas = Kelas::orderBy('id', 'ASC')->get();

            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');
            $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
            $data_kelas_all = Kelas::where('tapel_id', $tapel->id)
                ->orderBy('tingkatan_id', 'ASC')
                ->with('tingkatan')
                ->get();

            return view('tu.siswa.index', compact('title', 'tapel', 'data_kelas_all', 'jumlah_kelas', 'jumlah_kelas_per_level', 'data_tingkatan', 'data_jurusan', 'tingkatan_terendah', 'tingkatan_akhir', 'data_kelas'));
        }
    }

    public function data()
    {
        $data_siswa = Siswa::select('id', 'nama_lengkap', 'kelas_id', 'nis', 'nisn', 'jenis_kelamin', 'status')
            ->orderBy('kelas_id', 'DESC')
            ->orderBy('status', 'ASC')
            ->with(['kelas.tingkatan', 'user'])
            ->get();

        return DataTables::of($data_siswa)
            ->addColumn('tingkatan', function ($siswa) {
                return $siswa->kelas_id ? ($siswa->kelas ? ($siswa->kelas->tingkatan ? $siswa->kelas->tingkatan->nama_tingkatan : 'Belum terdata') : 'Belum terdata') : 'Belum terdata';
            })
            ->addColumn('kelas', function ($siswa) {
                return $siswa->kelas_id ? ($siswa->kelas ? $siswa->kelas->nama_kelas : 'Belum masuk anggota kelas') : 'Belum masuk anggota kelas';
            })
            ->addColumn('action', function ($siswa) {
                $showRoute = route('tu.siswa.show', $siswa->id);

                $deleteButton = view('components.actions.delete-button', [
                    'route' => route('tu.siswa.destroy', $siswa->id),
                    'id' => $siswa->id,
                    'isPermanent' => false,
                    'withShow' => true,
                    'showRoute' => $showRoute,
                    'withEdit' => false,
                ])->render();

                return $deleteButton;
            })
            ->toJson();
    }


    public function show($id)
    {
        $siswa = Siswa::findorfail($id);
        $title = 'Detail Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
        $data_kelas = Kelas::orderBy('id', 'ASC')->get();
        $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();

        $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
        $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');
        $data_kelas_terendah = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', $tingkatan_terendah)->orderBy('tingkatan_id', 'ASC')->get();
        $data_kelas_all = Kelas::where('tapel_id', $tapel->id)->orderBy('tingkatan_id', 'ASC')->get();

        return view('tu.siswa.show', compact('title', 'siswa', 'tingkatan_akhir', 'data_kelas_all', 'data_kelas_terendah', 'data_tingkatan', 'data_kelas', 'data_jurusan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Image validation before upload
            $this->validateImageSize($request);

            try {
                $user = new User([
                    'username' => strtolower(str_replace(' ', '', $request->nama_lengkap . $request->nis)),
                    'password' => bcrypt('123456'),
                    'status' => true
                ]);
                $user->assignRole('Student');
                $user->save();
            } catch (\Throwable $th) {
                return back()->with('toast_error', 'Username telah digunakan');
            }

            $nama_kelas = Kelas::where('id', $request->kelas_id)->get('nama_kelas');

            $siswa = new Siswa([
                'user_id' => $user->id,
                'tingkatan_id' => $request->kelas_id,
                'jurusan_id' => $request->kelas_id,
                'kelas_id' => $request->kelas_id,
                'jenis_pendaftaran' => $request->jenis_pendaftaran,

                'tahun_masuk' => $request->tahun_masuk,
                'semester_masuk' => $request->semester_masuk,
                'kelas_masuk' => $nama_kelas[0]->nama_kelas,

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
                'alamat_sekolah_lama' => $request->alamat_sekolah_lama,
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

            $this->saveUploadedFiles($request, $siswa);

            $anggota_kelas = new AnggotaKelas([
                'siswa_id' => $siswa->id,
                'kelas_id' => $request->kelas_id,
                'tapel_id' => $request->tapel_id,
                'pendaftaran' => $request->jenis_pendaftaran,
            ]);
            $anggota_kelas->save();

            return back()->with('toast_success', 'Siswa ' . $request->nama_lengkap . ' berhasil ditambahkan');
        } catch (\Throwable $th) {
            // Handle validation errors
            return back()->with('toast_error', 'File size exceeds limit (2 MB)');
        }
    }

    private function validateImageSize(Request $request)
    {
        $maxFileSizeKB = 2048; // 2 MB in kilobytes
        $images = ['pas_photo', 'file_document_kesehatan', 'file_list_pertanyaan', 'file_dokument_sekolah_lama'];

        foreach ($images as $imageField) {
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $fileSizeKB = $file->getSize() / 1024; // Convert bytes to kilobytes
                if ($fileSizeKB > $maxFileSizeKB) {
                    throw new \Exception('File size exceeds limit for ' . $imageField);
                }
            }
        }
    }

    private function saveUploadedFiles(Request $request, Siswa $siswa)
    {
        if ($request->hasFile('pas_photo')) {
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $this->savePhoto($pasPhoto, 'siswa', $request->nis, '.jpg');
            $siswa->pas_photo = $pasPhotoPath;
        }

        $this->savePhotoField('file_document_kesehatan', $request, $siswa, $request->nis, '.jpg');
        $this->savePhotoField('file_list_pertanyaan', $request, $siswa, $request->nis, '.jpg');
        $this->savePhotoField('file_dokument_sekolah_lama', $request, $siswa, $request->nis, '.jpg');

        $siswa->save();
    }

    private function savePhoto($file, $field, $nis, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $nis . $extension;
        return $file->storeAs($field, $filename, 'public');
    }

    private function savePhotoField($inputName, Request $request, Siswa $siswa, $nis, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $nis, $extension);
            $siswa->$inputName = $path;
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        try {
            // Image validation before upload
            $this->validateImageSize($request);
        } catch (\Throwable $th) {
            // Handle validation errors
            return back()->with('toast_error', 'File size exceeds limit (2 MB)');
        }

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
            'tingkatan_id' => $request->kelas_id,
            'jurusan_id' => $request->kelas_id,
            'kelas_id' => $request->kelas_id,
            'jenis_pendaftaran' => $request->jenis_pendaftaran,
            'tahun_masuk' => $request->tahun_masuk,
            'semester_masuk' => $request->semester_masuk,
            'kelas_masuk' => $request->kelas_masuk,

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
            'alamat_sekolah_lama' => $request->alamat_sekolah_lama,
            'prestasi_sekolah_lama' => $request->prestasi_sekolah_lama,
            'tahun_prestasi_sekolah_lama' => $request->tahun_prestasi_sekolah_lama,
            'sertifikat_number_sekolah_lama' => $request->sertifikat_number_sekolah_lama,
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
            return back()->with('toast_success', 'Student Data berhasil diimport');
        } catch (\Throwable $th) {
            dd($th->getMessage());
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

            $siswa_keluar = SiswaKeluar::where('siswa_id', $siswa->id)->first();

            if ($siswa_keluar) {
            }

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
            return redirect(route('tu.siswa.index'))->with('toast_success', 'Siswa berhasil dinonaktifkan');
        }
    }

    public function activate(Request $request)
    {
        $id = $request->id;
        $siswa = Siswa::findorfail($id);
        $siswa_keluar = SiswaKeluar::where('siswa_id', $id)->firstOrFail();

        if ($siswa->status == 1) {
            return back()->with('toast_error', 'Siswa ' . $siswa->nama_lengkap . ' sudah aktif');
        }

        $siswa->update(['status' => 1]);
        $siswa->user->update(['status' => 1]);
        $siswa_keluar->forceDelete();

        return back()->with('toast_success', 'Siswa ' . $siswa->nama_lengkap . ' telah memberhasil diaktifkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        try {
            $siswa->update([
                'status' => 0
            ]);

            $siswa->user->update([
                'status' => 0
            ]);

            $siswa->delete();

            foreach ($siswa->anggota_kelas as $anggotaKelas) {
                $anggotaKelas->delete();
            }

            $siswa->user->delete();



            return back()->with('toast_success', 'Siswa & User berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus siswa.');
        }
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanent($id)
    {
        $siswa = Siswa::withTrashed()->findOrFail($id);

        try {
            $siswa->anggota_kelas()->forceDelete();

            $siswa->user->forceDelete();
            $siswa->forceDelete();

            return back()->with('toast_success', 'Siswa & User berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus siswa secara permanen.');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $siswa = Siswa::withTrashed()->findOrFail($id);

            $siswa->restoreSiswa();

            return back()->with('toast_success', 'Siswa & User berhasil direstorasi');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi siswa.');
        }
    }

    public function showTrash()
    {
        $title = "Data Trash Siswa";
        $siswaTrashed = Siswa::onlyTrashed()->get();

        return view('tu.siswa.trash', compact('title', 'siswaTrashed'));
    }
}
