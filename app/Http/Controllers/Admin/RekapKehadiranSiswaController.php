<?php

namespace App\Http\Controllers\Admin;

use App\Models\AnggotaKelas;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tapel;
use Illuminate\Http\Request;

class RekapKehadiranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Rekap Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();
        return view('admin.rekapkehadiran.pilihkelas', compact('title', 'data_kelas'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Rekap Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();
        $kelas = Kelas::findorfail($request->kelas_id);
        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->where('anggota_kelas.kelas_id', $kelas->id)
            ->where('siswa.status', 1)
            ->get();

        return view('admin.rekapkehadiran.index', compact('title', 'kelas', 'data_kelas', 'data_anggota_kelas'));
    }
}
