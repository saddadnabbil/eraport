<?php

namespace App\Http\Controllers\Admin\KM;

use PDF;
use App\Kelas;
use App\Mapel;
use App\Sekolah;
use App\KmKkmMapel;
use App\AnggotaKelas;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\K13NilaiPtsPas;
use App\KehadiranSiswa;
use App\KmMappingMapel;
use App\Ekstrakulikuler;
use App\CatatanWaliKelas;
use App\KmNilaiAkhirRaport;
use App\RencanaNilaiSumatif;
use Illuminate\Http\Request;
use App\NilaiEkstrakulikuler;
use App\RencanaNilaiFormatif;
use App\KmDeskripsiNilaiSiswa;
use App\AnggotaEkstrakulikuler;
use App\Http\Controllers\Controller;
use App\K13RencanaNilaiKeterampilan;

class CetakRaportPTSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Raport Tengah Semester';
        $data_kelas = Kelas::where('tapel_id', session()->get('tapel_id'))->get();
        return view('admin.km.raportpts.setpaper', compact('title', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Raport Tengah Semester';
        $kelas = Kelas::findorfail($request->kelas_id);
        $data_kelas = Kelas::where('tapel_id', session()->get('tapel_id'))->get();
        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->where('anggota_kelas.kelas_id', $kelas->id)
            ->where('siswa.status', 1)
            ->get();

        $paper_size = $request->paper_size;
        $orientation = $request->orientation;

        return view('admin.km.raportpts.index', compact('title', 'kelas', 'data_kelas', 'data_anggota_kelas', 'paper_size', 'orientation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = 'Raport PTS';
        $sekolah = Sekolah::first();
        $anggota_kelas = AnggotaKelas::findorfail($id);

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', session()->get('tapel_id'))->get('id');
        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');
        $data_nilai = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

        $data_id_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', session()->get('tapel_id'))->get('id');

        $data_anggota_ekstrakulikuler = AnggotaEkstrakulikuler::whereIn('ekstrakulikuler_id', $data_id_ekstrakulikuler)->where('anggota_kelas_id', $anggota_kelas->id)->get();
        foreach ($data_anggota_ekstrakulikuler as $anggota_ekstrakulikuler) {
            $cek_nilai_ekstra = NilaiEkstrakulikuler::where('anggota_ekstrakulikuler_id', $anggota_ekstrakulikuler->id)->first();
            if (is_null($cek_nilai_ekstra)) {
                $anggota_ekstrakulikuler->nilai = null;
                $anggota_ekstrakulikuler->deskripsi = null;
            } else {
                $anggota_ekstrakulikuler->nilai = $cek_nilai_ekstra->nilai;
                $anggota_ekstrakulikuler->deskripsi = $cek_nilai_ekstra->deskripsi;
            }
        }
        $kehadiran_siswa = KehadiranSiswa::where('anggota_kelas_id', $anggota_kelas->id)->first();
        $catatan_wali_kelas = CatatanWaliKelas::where('anggota_kelas_id', $anggota_kelas->id)->first();

        // Data Nilai Kelompok A
        $data_pembelajaran_a = Pembelajaran::where('kelas_id', $anggota_kelas->kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get();
        foreach ($data_pembelajaran_a as $pembelajaran_a) {
            $kkm = KmKkmMapel::where('mapel_id', $pembelajaran_a->mapel_id)->where('kelas_id', $anggota_kelas->kelas->id)->first();
            // $deskripsi = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran_a->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            if (is_null($kkm)) {
                return back()->with('toast_warning', 'KKM mata pelajaran belum ditentukan');
            }
            // elseif (is_null($deskripsi)) {
            //     return redirect(route('prosesdeskripsikm'))->with('toast_warning', 'Deskripsi nilai siswa belum ditentukan');
            // }

            // Interval KKM
            $range = (100 - $kkm->kkm) / 3;
            $pembelajaran_a->kkm = round($kkm->kkm, 0);
            $pembelajaran_a->predikat_c = round($kkm->kkm, 0);
            $pembelajaran_a->predikat_b = round($kkm->kkm + $range, 0);
            $pembelajaran_a->predikat_a = round($kkm->kkm + ($range * 2), 0);

            $data_id_rencana_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran_a->id)->get('id');
            $rt_nilai_sumatif = NilaiSumatif::where('anggota_kelas_id', $anggota_kelas->id)->whereIn('rencana_nilai_sumatif_id', $data_id_rencana_sumatif)->avg('nilai');

            $pembelajaran_a->rt_nilai_sumatif = round($rt_nilai_sumatif, 0);

            $data_id_rencana_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran_a->id)->get('id');
            $rt_nilai_formatif = NilaiFormatif::where('anggota_kelas_id', $anggota_kelas->id)->whereIn('rencana_nilai_formatif_id', $data_id_rencana_formatif)->avg('nilai');

            $pembelajaran_a->rt_nilai_formatif = round($rt_nilai_formatif, 0);

            // $nilai_pts = K13NilaiPtsPas::where('pembelajaran_id', $pembelajaran_a->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            // if (is_null($nilai_pts)) {
            //     $pembelajaran_a->nilai_pts = 0;
            // } else {
            //     $pembelajaran_a->nilai_pts = $nilai_pts->nilai_pts;
            // }
        }

        // Data Nilai Kelompok B
        $data_pembelajaran_b = Pembelajaran::where('kelas_id', $anggota_kelas->kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get();
        foreach ($data_pembelajaran_b as $pembelajaran_b) {
            $kkm = KmKkmMapel::where('mapel_id', $pembelajaran_b->mapel_id)->where('kelas_id', $anggota_kelas->kelas->id)->first();
            // $deskripsi = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran_b->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            if (is_null($kkm)) {
                return back()->with('toast_warning', 'KKM mata pelajaran belum ditentukan');
            }
            // elseif (is_null($deskripsi)) {
            //     return redirect(route('prosesdeskripsikm'))->with('toast_warning', 'Deskripsi nilai siswa belum ditentukan');
            // }

            // Interval KKM
            $range = (100 - $kkm->kkm) / 3;
            $pembelajaran_b->kkm = round($kkm->kkm, 0);
            $pembelajaran_b->predikat_c = round($kkm->kkm, 0);
            $pembelajaran_b->predikat_b = round($kkm->kkm + $range, 0);
            $pembelajaran_b->predikat_a = round($kkm->kkm + ($range * 2), 0);

            $data_id_rencana_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran_b->id)->get('id');
            $rt_nilai_sumatif = NilaiSumatif::where('anggota_kelas_id', $anggota_kelas->id)->whereIn('rencana_nilai_sumatif_id', $data_id_rencana_sumatif)->avg('nilai');

            $pembelajaran_b->rt_nilai_sumatif = round($rt_nilai_sumatif, 0);

            $data_id_rencana_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran_b->id)->get('id');
            $rt_nilai_formatif = NilaiFormatif::where('anggota_kelas_id', $anggota_kelas->id)->whereIn('rencana_nilai_formatif_id', $data_id_rencana_formatif)->avg('nilai');

            $pembelajaran_b->rt_nilai_formatif = round($rt_nilai_formatif, 0);

            // $nilai_pts = K13NilaiPtsPas::where('pembelajaran_id', $pembelajaran_b->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            // if (is_null($nilai_pts)) {
            //     $pembelajaran_b->nilai_pts = 0;
            // } else {
            //     $pembelajaran_b->nilai_pts = $nilai_pts->nilai_pts;
            // }
        }

        $raport = PDF::loadview('walikelas.km.raportpts.raport', compact('title', 'sekolah', 'anggota_kelas', 'data_pembelajaran_a', 'data_pembelajaran_b', 'data_nilai', 'data_anggota_ekstrakulikuler', 'kehadiran_siswa', 'catatan_wali_kelas'))->setPaper($request->paper_size, $request->orientation);
        return $raport->stream('RAPORT PTS ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }
}
