<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Karyawan;
use App\UnitKaryawan;
use App\StatusKaryawan;
use App\PositionKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Karyawan';
        $dataKaryawan  = Karyawan::orderBy('kode_karyawan', 'desc')->orderBy('status', 'desc')->get([
            'id',
            'nama_lengkap',
            'jenis_kelamin',
            'kode_karyawan',
            'status_karyawan_id',
            'unit_karyawan_id',
            'position_karyawan_id',
            'status',
        ]);

        $dataStatusKaryawan = StatusKaryawan::all();
        $dataUnitKaryawan = UnitKaryawan::all();
        $dataPositionKaryawan = PositionKaryawan::all();

        $totalKaryawanActive = Karyawan::where('status', true)->count();
        $totalKaryawanNonActive = Karyawan::where('status', false)->count();

        return view('admin.karyawan.employee.index', compact('title', 'dataKaryawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan', 'totalKaryawanActive', 'totalKaryawanNonActive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_karyawan_id' => 'required|exists:status_karyawans,id',
            'unit_karyawan_id' => 'required|exists:unit_karyawans,id',
            'position_karyawan_id' => 'required|exists:position_karyawans,id',
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
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimum 2 MB
            'photo_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_taxpayer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        try {
            $user = new User([
                'username' => strtolower(str_replace(' ', '', $request->nama_lengkap . $request->kode_karyawan)),
                'password' => bcrypt('123456'),
                'role' => 4,
                'status' => true
            ]);
            $user->save();
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Username telah digunakan');
        }

        // Validation passed, create a new Karyawan instance and fill it with request data
        $karyawan = new Karyawan([
            'user_id' => $user->id,
            'status_karyawan_id' => $request->status_karyawan_id,
            'unit_karyawan_id' => $request->unit_karyawan_id,
            'position_karyawan_id' => $request->position_karyawan_id,
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
            'status' => true,
            'avatar' => 'default.png'
        ]);

        // Save the Karyawan instance to the database
        $karyawan->save();

        // Optionally, you can attach any uploaded files to the model
        $this->saveUploadedFiles($request, $karyawan);

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' telah ditambahkan');
    }

    private function saveUploadedFiles(Request $request, Karyawan $karyawan)
    {
        // Handle and save the uploaded files (if any) associated with the Karyawan model
        // Example: Assuming 'pas_photo' is the name of the file input for pas_photo
        if ($request->hasFile('pas_photo')) {
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $pasPhoto->store('pas_photo', 'public'); // Assuming 'pas_photo' is your storage disk

            // Save the file path to the model attribute
            $karyawan->pas_photo = $pasPhotoPath;
        }

        // Repeat the process for other uploaded files
        // Example: 'photo_kartu_identitas', 'photo_taxpayer', 'photo_kk', 'other_document', etc.

        $this->savePhoto('photo_kartu_identitas', $request, $karyawan, 'photo_kartu_identitas');
        $this->savePhoto('photo_taxpayer', $request, $karyawan, 'photo_taxpayer');
        $this->savePhoto('photo_kk', $request, $karyawan, 'photo_kk');
        $this->savePhoto('other_document', $request, $karyawan, 'other_document');

        // Save the Karyawan model after handling files
        $karyawan->save();
    }

    private function savePhoto($inputName, Request $request, Karyawan $karyawan, $attributeName)
    {
        if ($request->hasFile($inputName)) {
            $photo = $request->file($inputName);
            $photoPath = $photo->store($attributeName, 'public'); // Assuming $attributeName is your storage disk

            // Save the file path to the model attribute
            $karyawan->$attributeName = $photoPath;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Detail Karyawan';
        $karyawan = Karyawan::find($id);

        $dataStatusKaryawan = StatusKaryawan::all();
        $dataUnitKaryawan = UnitKaryawan::all();
        $dataPositionKaryawan = PositionKaryawan::all();


        return view('admin.karyawan.employee.show', compact('title', 'karyawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'status_karyawan_id' => 'required|exists:status_karyawans,id',
            'unit_karyawan_id' => 'required|exists:unit_karyawans,id',
            'position_karyawan_id' => 'required|exists:position_karyawans,id',
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
        ]);
    }


    // public function export()
    // {
    //     $filename = 'data_siswa ' . date('Y-m-d H_i_s') . '.xls';
    //     return Excel::download(new SiswaExport, $filename);
    // }

    // public function format_import()
    // {
    //     $file = public_path() . "/format_import/format_import_siswa.xls";
    //     $headers = array(
    //         'Content-Type: application/xls',
    //     );
    //     return Response::download($file, 'format_import_siswa ' . date('Y-m-d H_i_s') . '.xls', $headers);
    // }

    // public function import(Request $request)
    // {
    //     try {
    //         Excel::import(new SiswaImport, $request->file('file_import'));
    //         return back()->with('toast_success', 'Data siswa berhasil diimport');
    //     } catch (\Throwable $th) {
    //         return back()->with('toast_error', 'Maaf, format data tidak sesuai');
    //     }
    // }

    // public function activate(Request $request)
    // {
    //     $id = $request->input('id');
    //     $karyawan = Karyawan::findorfail($id);
    //     $karyawan->update(['status' => 1]);
    //     // $karyawan->user->update(['status' => 1]);

    //     // $siswa_keluar = SiswaKeluar::where('siswa_id', $id)->firstOrFail();
    //     // $siswa_keluar->delete();

    //     return back()->with('toast_success', 'Siswa ' . $karyawan->nama_lengkap . ' telah memberhasil diaktifkan');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $siswa = Karyawan::findOrFail($id);

    //     try {
    //         $siswa->update([
    //             'status' => 0
    //         ]);

    //         $siswa->user->update([
    //             'status' => 0
    //         ]);

    //         $siswa->delete();

    //         foreach ($siswa->anggota_kelas as $anggotaKelas) {
    //             $anggotaKelas->delete();
    //         }

    //         $siswa->user->delete();



    //         return back()->with('toast_success', 'Siswa & User berhasil dihapus');
    //     } catch (\Throwable $th) {
    //         return back()->with('toast_error', 'Terjadi kesalahan saat menghapus siswa.');
    //     }
    // }

    // /**
    //  * Permanently remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroyPermanent($id)
    // {
    //     $siswa = Siswa::withTrashed()->findOrFail($id);

    //     try {
    //         $siswa->anggota_kelas()->forceDelete();

    //         $siswa->user->forceDelete();
    //         $siswa->forceDelete();

    //         return back()->with('toast_success', 'Siswa & User berhasil dihapus secara permanen');
    //     } catch (\Throwable $th) {
    //         return back()->with('toast_error', 'Terjadi kesalahan saat menghapus siswa secara permanen.');
    //     }
    // }

    // /**
    //  * Restore the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function restore($id)
    // {
    //     try {
    //         $siswa = Siswa::withTrashed()->findOrFail($id);

    //         $siswa->restoreSiswa();

    //         return back()->with('toast_success', 'Siswa & User berhasil direstorasi');
    //     } catch (\Throwable $th) {
    //         dd($th->getMessage());
    //         return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi siswa.');
    //     }
    // }

    // public function showTrash()
    // {
    //     $title = "Data Trash Siswa";
    //     $siswaTrashed = Siswa::onlyTrashed()->get();

    //     return view('admin.siswa.trash', compact('title', 'siswaTrashed'));
    // }
}
