<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\Models\User;
use App\SiswaKeluar;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Tingkatan;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
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
        $tingkatanIds = [1, 2, 3, 4, 5];

        $jumlah_kelas = Kelas::where('tapel_id', $tapel->id)->count();

        if ($jumlah_kelas == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {

            $jumlah_kelas_per_level = Siswa::select('tingkatan_id', DB::raw('count(*) as total'))
                ->where('status', 1)
                ->whereIn('tingkatan_id', $tingkatanIds)
                ->groupBy('tingkatan_id')
                ->get()
                ->pluck('total', 'tingkatan_id');

            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');
            $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
            $data_kelas_all = Kelas::where('tapel_id', $tapel->id)
                ->orderBy('tingkatan_id', 'ASC')
                ->with('tingkatan')
                ->get();

            return view('admin.siswa.index', compact('title', 'data_kelas_all', 'jumlah_kelas', 'jumlah_kelas_per_level', 'data_tingkatan', 'tingkatan_terendah', 'tingkatan_akhir'));
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
                return $siswa->kelas_id ? $siswa->kelas->tingkatan->nama_tingkatan : 'Belum terdata';
            })
            ->addColumn('kelas', function ($siswa) {
                return $siswa->kelas_id ? $siswa->kelas->nama_kelas : 'Belum masuk anggota kelas';
            })
            ->addColumn('action', function ($siswa) {
                $deleteButton = view('components.actions.delete-button', [
                    'route' => route('siswa.destroy', $siswa->id),
                    'id' => $siswa->id,
                    'isPermanent' => false,
                    'withShow' => true,
                    'showRoute' => route('siswa.show', $siswa->id),
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

            $nama_kelas = Kelas::findorfail($request->kelas_id)->get('nama_kelas');

            $siswa = new Siswa([
                'user_id' => $user->id,
                'tingkatan_id' => $request->kelas_id,
                'jurusan_id' => $request->kelas_id,
                'kelas_id' => $request->kelas_id,
                'jenis_pendaftaran' => $request->jenis_pendaftaran,

                'tahun_masuk' => $request->tahun_masuk,
                'semester_masuk' => $request->semester_masuk,
                'kelas_masuk' => $nama_kelas,

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

            if ($request->hasFile('pas_photo')) {
                $file = $request->file('pas_photo');
                $path = $file->store('pas_photo_siswa', 'public'); // Adjust the storage path as needed
                $siswa->pas_photo = $path;
            }

            if ($request->hasFile('file_document_kesehatan')) {
                $file = $request->file('file_document_kesehatan');
                $path = $file->store('documents_siswa', 'public'); // Adjust the storage path as needed
                $siswa->file_document_kesehatan = $path;
            }

            if ($request->hasFile('file_list_pertanyaan')) {
                $file = $request->file('file_list_pertanyaan');
                $path = $file->store('documents_siswa', 'public'); // Adjust the storage path as needed
                $siswa->file_list_pertanyaan = $path;
            }

            if ($request->hasFile('file_dokument_sekolah_lama')) {
                $file = $request->file('file_dokument_sekolah_lama');
                $path = $file->store('documents_siswa', 'public'); // Adjust the storage path as needed
                $siswa->file_dokument_sekolah_lama = $path;
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
                'jenis_kelamin' => 'required|in:MALE,FEMALE',
                'jenis_pendaftaran' => 'required|in:1,2',

                'semester_masuk' => 'required',
                'tahun_masuk' => 'required',
                'kelas_masuk' => 'required',

                'kelas_id' => 'required|exists:kelas,id',
                'nik' => 'unique:siswa,nik,' . $siswa->id,
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

    // Function to handle file uploads
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
            return redirect('admin/siswa')->with('toast_success', 'Siswa berhasil dinonaktifkan');
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

        return view('admin.siswa.trash', compact('title', 'siswaTrashed'));
    }
}
