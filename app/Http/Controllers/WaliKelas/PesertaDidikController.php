<?php

namespace App\Http\Controllers\WaliKelas;

use App\Guru;
use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\Tingkatan;
use App\AnggotaKelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();
        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        return view('walikelas.pesertadidik.index', compact('title', 'data_anggota_kelas'));
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

        return view('walikelas.pesertadidik.show', compact('title', 'siswa', 'tingkatan_akhir', 'data_kelas_all', 'data_kelas_terendah', 'data_tingkatan'));
    }
}
