<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\AnggotaKelas;
use App\Models\KehadiranSiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RekapKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Rekap Kehadiran';
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $tapel = Tapel::where('status', 1)->first();

        $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->pluck('id');
        $anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->whereIn('anggota_kelas.kelas_id', $data_id_kelas)
            ->where('anggota_kelas.siswa_id', $siswa->id)
            ->where('siswa.status', 1)
            ->get();
        if ($anggota_kelas->isEmpty()) {
            return back()->with('toast_warning', 'Anda belum masuk ke anggota kelas');
        } else {
            $kehadiran = KehadiranSiswa::where('anggota_kelas_id', $anggota_kelas->first()->id)->first();
            $anggota_kelas = $anggota_kelas->first();
            return view('siswa.presensi.index', compact('title', 'siswa', 'kehadiran', 'anggota_kelas'));
        }
            
    }


}
