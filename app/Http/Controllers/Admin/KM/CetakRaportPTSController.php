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

        $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');
        $data_nilai = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

        $data_nilai_term_1 = KmNilaiAkhirRaport::where('term_id', 1)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

        $nilai_akhir_term_1 = [];
        foreach ($data_nilai_term_1 as $nilai_term_1) {
            $nilai_akhir_term_1[] = [
                'term' => $nilai_term_1->term_id,
                'pembelajaran_id' => $nilai_term_1->pembelajaran_id,
                'nilai_akhir_raport' => $nilai_term_1->nilai_akhir_raport,
                'nama_mapel' => $nilai_term_1->pembelajaran->mapel->nama_mapel,
                'nama_mapel_indonesian' => $nilai_term_1->pembelajaran->mapel->nama_mapel_indonesian,
                'kkm' => $nilai_term_1->kkm,
                'deskripsi_nilai' => $nilai_term_1->km_deskripsi_nilai_siswa
            ];
        }

        $nilai_akhir_total = [];

        foreach ($nilai_akhir_term_1 as $nilai) {
            $pembelajaran_id = $nilai['pembelajaran_id'];
            if (!isset($nilai_akhir_total[$pembelajaran_id])) {
                $nilai_akhir_total[$pembelajaran_id] = ['nilai' => 0, 'predikat' => '', 'nama_mapel' => ''];
            }
            $nilai_akhir_total[$pembelajaran_id]['nilai'] += $nilai['nilai_akhir_raport'];
            $nilai_akhir_total[$pembelajaran_id]['nama_mapel'] = $nilai['nama_mapel'];
            $nilai_akhir_total[$pembelajaran_id]['nama_mapel_indonesian'] = $nilai['nama_mapel_indonesian'];
            $nilai_akhir_total[$pembelajaran_id]['kkm'] = $nilai['kkm'];
            $nilai_akhir_total[$pembelajaran_id]['deskripsi_nilai'] = $nilai['deskripsi_nilai'];
            $nilai_akhir_total[$pembelajaran_id]['term'] = $nilai['term'];
        }

        // Nilai Akhir
        // Membagi hasil jumlah nilai dengan 2 dan menambahkan predikat
        $nilai_akhir_total = array_map(function ($data) {
            $data['predikat'] = ($data['nilai'] > 90) ? 'A' : 'B'; // Sesuaikan logika predikat

            return $data;
        }, $nilai_akhir_total);

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

        $raport = PDF::loadview('walikelas.km.raportpts.raport', compact('title', 'sekolah', 'anggota_kelas', 'data_nilai', 'data_anggota_ekstrakulikuler', 'kehadiran_siswa', 'catatan_wali_kelas', 'nilai_akhir_total'))->setPaper($request->paper_size, $request->orientation);
        return $raport->stream('RAPORT PTS ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }
}
