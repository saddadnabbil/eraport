<?php

namespace App\Http\Controllers\Siswa\K13;

use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\KmNilaiAkhirRaport;
use App\K13NilaiAkhirRaport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NilaiAkhirSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Nilai Akhir Semester';
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $tapel = Tapel::where('status', 1)->first();

        $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)->where('siswa_id', $siswa->id)->first();
        if (is_null($anggota_kelas)) {
            return back()->with('toast_warning', 'Anda belum masuk ke anggota kelas');
        } else {
            $data_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->where('status', 1)->get();
            foreach ($data_pembelajaran as $pembelajaran) {
                $pembelajaran->nilai = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            }
            return view('siswa.km.nilaiakhir.index', compact('title', 'siswa', 'data_pembelajaran'));
        }
    }
}
