<?php

namespace App\Http\Controllers\WaliKelas;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\PrestasiSiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PrestasiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Prestasi Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_prestasi_siswa = PrestasiSiswa::whereIn('anggota_kelas_id', $id_anggota_kelas)->get();

        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $kelas_id_anggota_kelas)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        return view('walikelas.prestasi.index', compact('title', 'data_prestasi_siswa', 'data_anggota_kelas'));
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
            'anggota_kelas_id' => 'required',
            'nama_prestasi' => 'required',
            'jenis_prestasi' => 'required',
            'tingkat_prestasi' => 'required',
            'deskripsi' => 'required|min:20|max:200',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $prestasi = new PrestasiSiswa([
                'anggota_kelas_id' => $request->anggota_kelas_id,
                'nama_prestasi' => $request->nama_prestasi,
                'jenis_prestasi' => $request->jenis_prestasi,
                'tingkat_prestasi' => $request->tingkat_prestasi,
                'deskripsi' => $request->deskripsi,
            ]);
            $prestasi->save();
            return back()->with('toast_success', 'Prestasi siswa berhasil ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'anggota_kelas_id' => 'required',
            'nama_prestasi' => 'required',
            'jenis_prestasi' => 'required',
            'tingkat_prestasi' => 'required',
            'deskripsi' => 'required|min:20|max:200',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $prestasi = PrestasiSiswa::findorfail($id);
            $prestasi->nama_prestasi = $request->nama_prestasi;
            $prestasi->jenis_prestasi = $request->jenis_prestasi;
            $prestasi->tingkat_prestasi = $request->tingkat_prestasi;
            $prestasi->deskripsi = $request->deskripsi;
            $prestasi->update();
            return back()->with('toast_success', 'Prestasi siswa berhasil diubah');
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
        $prestasi = PrestasiSiswa::findorfail($id);
        try {
            $prestasi->delete();
            return back()->with('toast_success', 'Prestasi siswa berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Data Prestasi siswa tidak dapat dihapus');
        }
    }
}
