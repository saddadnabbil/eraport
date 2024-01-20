<?php

namespace App\Http\Controllers\Siswa\K13;

use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\Silabus;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\K13NilaiAkhirRaport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SilabusController extends Controller
{
    public function index()
    {
        $title = 'Silabus';
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $tapel = Tapel::where('status', 1)->first();

        $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)->where('siswa_id', $siswa->id)->first();

        if (is_null($anggota_kelas)) {
            return back()->with('toast_warning', 'Belum tersedia silabus');
        } else {
            $data = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->where('status', 1)->get();

            $data_silabus = $data->pluck('silabus');

            // foreach ($data as $data_silabus_pembelajaran) {
            //     $data_silabus = $data_silabus_pembelajaran->silabus->where('pembelajaran_id', $data_silabus_pembelajaran->id)->where('kelas_id', $anggota_kelas->id);
            //     $data_silabus = $data_silabus;

            //     $data_silabus_pembelajaran->silabus = $data_silabus->where('pembelajaran_id', $data_silabus_pembelajaran->id)->where('kelas_id', $anggota_kelas->id);
            // }
            return view('siswa.k13.silabus.index', compact('title', 'siswa', 'data_silabus'));
        }
    }
}
