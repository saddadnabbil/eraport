<?php

namespace App\Exports;

use App\Models\AnggotaEkstrakulikuler;
use App\Models\AnggotaKelas;
use App\Models\Ekstrakulikuler;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\NilaiEkstrakulikuler;
use App\Models\Pembelajaran;
use App\Models\Sekolah;
use App\Models\Tapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WaliKelasLegerNilaiExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');

        $sekolah = Sekolah::first();
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_pembelajaran_all = Pembelajaran::whereIn('kelas_id', $id_kelas_diampu)->get('id');

        $data_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();
        $count_ekstrakulikuler = count($data_ekstrakulikuler);

        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get();
        foreach ($data_anggota_kelas as $anggota_kelas) {

            $anggota_kelas->data_nilai_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();

            foreach ($anggota_kelas->data_nilai_ekstrakulikuler as $data_nilai_ekstrakulikuler) {
                $cek_anggota_ekstra = AnggotaEkstrakulikuler::where('ekstrakulikuler_id', $data_nilai_ekstrakulikuler->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
                if (is_null($cek_anggota_ekstra)) {
                    $data_nilai_ekstrakulikuler->nilai = '-';
                } else {
                    $cek_nilai_ekstra = NilaiEkstrakulikuler::where('ekstrakulikuler_id', $data_nilai_ekstrakulikuler->id)->where('anggota_ekstrakulikuler_id', $cek_anggota_ekstra->id)->first();
                    if (is_null($cek_nilai_ekstra)) {
                        $data_nilai_ekstrakulikuler->nilai = '-';
                    } else {
                        $data_nilai_ekstrakulikuler->nilai = $cek_nilai_ekstra->nilai;
                    }
                }
            }
        }

        return view('exports.walikelas.km.legernilai', compact('time_download', 'sekolah', 'data_mapel_kelompok_a', 'data_mapel_kelompok_b', 'data_ekstrakulikuler', 'count_ekstrakulikuler', 'data_anggota_kelas'));
    }
}
