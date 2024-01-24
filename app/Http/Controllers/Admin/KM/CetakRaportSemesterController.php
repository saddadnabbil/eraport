<?php

namespace App\Http\Controllers\Admin\KM;

use PDF;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Sekolah;
use App\KmTglRaport;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\PrestasiSiswa;
use App\KehadiranSiswa;
use App\KmMappingMapel;
use App\Ekstrakulikuler;
use App\CatatanWaliKelas;
use App\KmNilaiAkhirRaport;
use Illuminate\Http\Request;
use App\NilaiEkstrakulikuler;
use App\AnggotaEkstrakulikuler;
use App\K13DeskripsiSikapSiswa;
use App\Http\Controllers\Controller;

class CetakRaportSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Cetak Raport Semester';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();
        return view('admin.km.raportsemester.setpaper', compact('title', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Cetak Raport Semester';
        $kelas = Kelas::findorfail($request->kelas_id);
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();
        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->where('anggota_kelas.kelas_id', $kelas->id)
            ->where('siswa.status', 1)
            ->get();

        $paper_size = $request->paper_size;
        $orientation = 'potrait';

        return view('admin.km.raportsemester.index', compact('title', 'kelas', 'data_kelas', 'data_anggota_kelas', 'paper_size', 'orientation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $sekolah = Sekolah::first();
        $anggota_kelas = AnggotaKelas::findorfail($id);
        $tapel = Tapel::where('status', 1)->first();

        if ($request->data_type == 1) {
            $title = 'Kelengkapan Raport';
            $kelengkapan_raport = PDF::loadview('walikelas.km.raportsemester.kelengkapanraport', compact('title', 'sekolah', 'anggota_kelas'))->setPaper($request->paper_size, $request->orientation);
            return $kelengkapan_raport->stream('KELENGKAPAN RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
        } elseif ($request->data_type == 2) {
            $title = 'Raport Semester';
            $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

            $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');

            $data_nilai_term_1 = KmNilaiAkhirRaport::where('term_id', 1)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_term_2 = KmNilaiAkhirRaport::where('term_id', 2)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            $nilai_akhir_term_1 = [];
            foreach ($data_nilai_term_1 as $nilai_term_1) {
                $nilai_akhir_term_1[] = [
                    'pembelajaran_id' => $nilai_term_1->pembelajaran_id,
                    'nilai_akhir_raport' => $nilai_term_1->nilai_akhir_raport,
                    'nama_mapel' => $nilai_term_1->pembelajaran->mapel->nama_mapel,
                    'nama_mapel_indonesian' => $nilai_term_1->pembelajaran->mapel->nama_mapel_indonesian,
                    'kkm' => $nilai_term_1->kkm,
                    'deskripsi_nilai' => $nilai_term_1->km_deskripsi_nilai_siswa
                ];
            }

            $nilai_akhir_term_2 = [];
            foreach ($data_nilai_term_2 as $nilai_term_2) {
                $nilai_akhir_term_2[] = [
                    'pembelajaran_id' => $nilai_term_2->pembelajaran_id,
                    'nilai_akhir_raport' => $nilai_term_2->nilai_akhir_raport,
                    'nama_mapel' => $nilai_term_2->pembelajaran->mapel->nama_mapel,
                    'nama_mapel_indonesian' => $nilai_term_2->pembelajaran->mapel->nama_mapel_indonesian,
                    'kkm' => $nilai_term_2->kkm,
                    'deskripsi_nilai' => $nilai_term_2->km_deskripsi_nilai_siswa
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
            }

            foreach ($nilai_akhir_term_2 as $nilai) {
                $pembelajaran_id = $nilai['pembelajaran_id'];
                if (!isset($nilai_akhir_total[$pembelajaran_id])) {
                    $nilai_akhir_total[$pembelajaran_id] = ['nilai' => 0, 'predikat' => '', 'nama_mapel' => ''];
                }
                $nilai_akhir_total[$pembelajaran_id]['nilai'] += $nilai['nilai_akhir_raport'];
                $nilai_akhir_total[$pembelajaran_id]['nama_mapel'] = $nilai['nama_mapel'];
                $nilai_akhir_total[$pembelajaran_id]['nama_mapel_indonesian'] = $nilai['nama_mapel_indonesian'];
                $nilai_akhir_total[$pembelajaran_id]['kkm'] = $nilai['kkm'];
                $nilai_akhir_total[$pembelajaran_id]['deskripsi_nilai'] = $nilai['deskripsi_nilai'];
            }

            // Nilai Akhir
            // Membagi hasil jumlah nilai dengan 2 dan menambahkan predikat
            $nilai_akhir_total = array_map(function ($data) {
                // Interval KKM
                $kkm = [
                    'predikat_d' => 60.00,
                    'predikat_c' => 70.00,
                    'predikat_b' => 80.00,
                    'predikat_a' => 100.00,
                ];

                if ($data['nilai'] < $kkm['predikat_d']) {
                    $data['predikat'] = 'D';
                } elseif ($data['nilai'] >= $kkm['predikat_d'] && $data['nilai'] < $kkm['predikat_c']) {
                    $data['predikat'] = 'C';
                } elseif ($data['nilai'] >= $kkm['predikat_c'] && $data['nilai'] < $kkm['predikat_b']) {
                    $data['predikat'] = 'B';
                } elseif ($data['nilai'] >= $kkm['predikat_b'] && $data['nilai'] <= $kkm['predikat_a']) {
                    $data['predikat'] = 'A';
                }

                return $data;
            }, $nilai_akhir_total);


            $data_nilai = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            $data_id_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get('id');
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

            $data_prestasi_siswa = PrestasiSiswa::where('anggota_kelas_id', $anggota_kelas->id)->get();
            $kehadiran_siswa = KehadiranSiswa::where('anggota_kelas_id', $anggota_kelas->id)->first();
            $catatan_wali_kelas = CatatanWaliKelas::where('anggota_kelas_id', $anggota_kelas->id)->first();

            $cek_tanggal_raport = KmTglRaport::where('tapel_id', $tapel->id)->first();
            if (is_null($cek_tanggal_raport)) {
                return back()->with('toast_warning', 'Tanggal raport belum disetting oleh admin');
            } else {
                $raport = PDF::loadview('walikelas.km.raportsemester.raport', compact('title', 'sekolah', 'anggota_kelas',  'data_anggota_ekstrakulikuler', 'data_prestasi_siswa', 'kehadiran_siswa', 'catatan_wali_kelas', 'data_nilai', 'nilai_akhir_total'))->setPaper($request->paper_size, $request->orientation);
                return $raport->stream('RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
            }
        }
    }
}
