<?php

namespace App\Http\Controllers\WaliKelas\KM;

use App\Guru;
use App\Term;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\KmMappingMapel;
use App\Ekstrakulikuler;
use App\KmNilaiAkhirRaport;
use Illuminate\Http\Request;
use App\NilaiEkstrakulikuler;
use App\AnggotaEkstrakulikuler;
use App\K13DeskripsiSikapSiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminKMLegerNilaiExport;
use App\Exports\AdminK13LegerNilaiExport;
use App\Exports\WaliKelasLegerNilaiExport;

class LegerNilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Leger Nilai Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->get('id');
        $kelas = Kelas::findorfail($id_kelas_diampu)->first();
        $term = Term::findorfail($kelas->tingkatan->term_id);

        $data_pembelajaran_kelas = Pembelajaran::whereIn('kelas_id', $id_kelas_diampu)->where('status', 1)->get();

        $data_kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->get();



        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $data_id_pembelajaran_all = Pembelajaran::where('kelas_id', $kelas->id)->get('id');
        $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get('id');
        $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get('id');

        $data_mapel_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->groupBy('pembelajaran_id')->get();
        $data_mapel_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->groupBy('pembelajaran_id')->get();

        $data_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();
        $count_ekstrakulikuler = count($data_ekstrakulikuler);

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');
        $data_anggota_kelas = AnggotaKelas::whereIn('id', $id_anggota_kelas)->whereIn('kelas_id', $kelas_id_anggota_kelas)->get();

        foreach ($data_anggota_kelas as $anggota_kelas) {

            $data_nilai_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;

            $rt_sumatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_sumatif');
            $rt_formatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_formatif');

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
        return view('walikelas.km.leger.index', compact('title', 'kelas', 'data_kelas', 'data_mapel_kelompok_a', 'data_mapel_kelompok_b', 'data_ekstrakulikuler', 'count_ekstrakulikuler', 'data_anggota_kelas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::findorfail($id);
        $tapel = $kelas->tapel;
        $semester = $tapel->semester_id;
        $tahun_pelajaran = $tapel->tahun_pelajaran;


        $filename = 'Daftar Legger - ' . $kelas->nama_kelas . ' - Semester ' . $semester . ' (' . $tahun_pelajaran . ').xls';

        return Excel::download(new WaliKelasLegerNilaiExport($id), $filename);
    }
}
