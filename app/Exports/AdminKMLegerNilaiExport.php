<?php

namespace App\Exports;

use App\Models\AnggotaEkstrakulikuler;
use App\Models\AnggotaKelas;
use App\Models\Ekstrakulikuler;
use App\Models\Guru;

use App\Models\KmMappingMapel;
use App\Models\KmNilaiAkhirRaport;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\NilaiEkstrakulikuler;
use App\Models\Pembelajaran;
use App\Models\Sekolah;
use App\Models\Tapel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AdminKMLegerNilaiExport implements FromView, ShouldAutoSize
{
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');

        $tapel = Tapel::where('status', 1)->first();
        $kelas = Kelas::findorfail($this->id);
        $sekolah = $kelas->tingkatan->sekolah;

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $data_id_pembelajaran_all = Pembelajaran::where('kelas_id', $kelas->id)->get('id');
        $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get('id');
        $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get('id');

        $data_mapel_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->groupBy('pembelajaran_id')->get();
        $data_mapel_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->groupBy('pembelajaran_id')->get();

        $data_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();
        $count_ekstrakulikuler = count($data_ekstrakulikuler);

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas->id)->get();
        foreach ($data_anggota_kelas as $anggota_kelas) {

            $data_nilai_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;

            $rt_sumatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_sumatif');
            $rt_formatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_formatif');

            $anggota_kelas->rata_rata_sumatif = round($rt_sumatif, 0);
            $anggota_kelas->rata_rata_formatif = round($rt_formatif, 0);

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

        return view('exports.admin.km.legernilai', compact('time_download', 'sekolah', 'kelas', 'data_mapel_kelompok_a', 'data_mapel_kelompok_b', 'data_ekstrakulikuler', 'count_ekstrakulikuler', 'data_anggota_kelas'));
    }
}
