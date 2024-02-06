<?php

namespace App\Http\Controllers\WaliKelas;

use App\AnggotaKelas;
use App\Guru;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaDidikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Peserta Didik';
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->get('id');
        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        return view('walikelas.pesertadidik.index', compact('title', 'data_anggota_kelas'));
    }
}
