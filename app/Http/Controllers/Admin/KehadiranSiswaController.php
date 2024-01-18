<?php

namespace App\Http\Controllers\Admin;

use App\Guru;
use App\Kelas;
use App\Tapel;
use Carbon\Carbon;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\KehadiranSiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KehadiranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        return view('admin.kehadiran.index', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $title = 'Input Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('id', $request->kelas_id)->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::whereIn('id', $id_anggota_kelas)->whereIn('kelas_id', $kelas_id_anggota_kelas)->get();

        foreach ($data_anggota_kelas as $anggota) {
            $kehadiran = KehadiranSiswa::where('anggota_kelas_id', $anggota->id)->first();
            if (is_null($kehadiran)) {
                $anggota->sakit = 0;
                $anggota->izin = 0;
                $anggota->tanpa_keterangan = 0;
            } else {
                $anggota->sakit = $kehadiran->sakit;
                $anggota->izin = $kehadiran->izin;
                $anggota->tanpa_keterangan = $kehadiran->tanpa_keterangan;
            }
        }

        return view('admin.kehadiran.create', compact('title', 'data_anggota_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->anggota_kelas_id)) {
            return back()->with('toast_error', 'Data siswa tidak ditemukan');
        } else {
            for ($cound_siswa = 0; $cound_siswa < count($request->anggota_kelas_id); $cound_siswa++) {
                $data = array(
                    'anggota_kelas_id'  => $request->anggota_kelas_id[$cound_siswa],
                    'sakit'  => $request->sakit[$cound_siswa],
                    'izin'  => $request->izin[$cound_siswa],
                    'tanpa_keterangan'  => $request->tanpa_keterangan[$cound_siswa],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $cek_data = KehadiranSiswa::where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->first();
                if (is_null($cek_data)) {
                    KehadiranSiswa::insert($data);
                } else {
                    $cek_data->update($data);
                }
            }
            return redirect(route('kehadiranadmin.index'))->with('toast_success', 'Kehadiran siswa berhasil disimpan');
        }
    }
}
