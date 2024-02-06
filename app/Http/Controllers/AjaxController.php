<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Jurusan;
use App\Silabus;
use App\AnggotaKelas;
use App\Pembelajaran;
use Illuminate\Http\Request;
use App\AnggotaEkstrakulikuler;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function ajax_kelas($id)
    {
        $data_kelas = Pembelajaran::whereNotNull('guru_id')->where('mapel_id', $id)->where('status', true)->get('kelas_id');

        foreach ($data_kelas as $kelas) {
            $kls = Kelas::findorfail($kelas->kelas_id);
            $kelas->tingkatan_id = $kls->tingkatan->nama_tingkatan;
            $kelas->jurusan_id = $kls->jurusan->id;
            $kelas->nama_kelas = $kls->nama_kelas;
        }
        // dd($data_kelas);
        return json_encode($data_kelas, true);
    }

    public function ajax_kelas_by_tingkatan_id($id)
    {
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tingkatan_id', $id)->where('tapel_id', $tapel->id)->get();

        $data_jurusan = [];

        foreach ($data_kelas as $kelas) {
            $data_jurusan[] = Jurusan::where('id', $kelas->jurusan_id)->first();
        }

        return json_encode(['data' => $data_kelas, 'data_jurusan' => $data_jurusan], true);
    }



    public function ajax_kelas_ekstra($id)
    {
        $id_anggota_kelas = AnggotaEkstrakulikuler::where('ekstrakulikuler_id', $id)->get('anggota_kelas_id');
        $id_kelas = AnggotaKelas::whereIn('id', $id_anggota_kelas)->get('kelas_id');
        $data_kelas = Kelas::whereIn('id', $id_kelas)->get();

        return json_encode($data_kelas, true);
    }

    // public function ajax_kelas_silabus($id)
    // {
    //     $data_kelas = Pembelajaran::whereNotNull('guru_id')->where('mapel_id', $id)->where('status', true)->get('kelas_id');

    //     foreach ($data_kelas as $kelas) {
    //         $kls = Kelas::findorfail($kelas->kelas_id);
    //         $kelas->tingkatan_id = $kls->tingkatan->nama_tingkatan;
    //         $kelas->nama_kelas = $kls->nama_kelas;
    //     }
    //     // dd($data_kelas);
    //     return json_encode($data_kelas, true);
    // }

    public function ajax_kelas_silabus($id)
    {
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)
            ->where('guru_id', $guru->id)
            ->pluck('id');

        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)
            ->whereIn('kelas_id', $id_kelas)
            ->where('status', 1)
            ->orderBy('mapel_id', 'ASC')
            ->orderBy('kelas_id', 'ASC')
            ->get();

        $kelas = Kelas::whereIn('id', $data_pembelajaran->pluck('kelas_id'))
            ->orderBy('nama_kelas', 'ASC')
            ->get();

        $data_kelas = Pembelajaran::whereNotNull('guru_id')
            ->whereIn('kelas_id', $kelas->pluck('id'))
            ->where('mapel_id', $id)
            ->where('status', true)
            ->get('kelas_id');

        foreach ($data_kelas as $kelas) {
            $kls = Kelas::findorfail($kelas->kelas_id);
            $kelas->tingkatan_id = $kls->tingkatan->nama_tingkatan;
            $kelas->nama_kelas = $kls->nama_kelas;
        }

        return json_encode($data_kelas, true);
    }

    public function getPembelajaranId(Request $request)
    {
        $mapelId = $request->input('mapel_id');
        $kelasId = $request->input('kelas_id');

        // Hanya cari pembelajaran jika kelasId tidak kosong
        if ($kelasId) {
            // Gantilah sesuai dengan model dan field yang sesuai
            $pembelajaran = Pembelajaran::where('mapel_id', $mapelId)
                ->where('kelas_id', $kelasId)
                ->first();

            if ($pembelajaran) {
                return response()->json(['pembelajaran_id' => $pembelajaran->id]);
            } else {
                return response()->json(['error' => 'Pembelajaran not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Kelas not selected'], 400);
        }
    }

    public function getAllSilabus($id)
    {
        try {
            $silabus = Silabus::findOrFail($id);
            return response()->json(['success' => true, 'data' => $silabus]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
