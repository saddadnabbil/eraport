<?php

namespace App\Http\Controllers\WaliKelas\KM;

use PDF;
use App\Guru;
use App\Kelas;
use App\Mapel;
use App\Tapel;
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
use Illuminate\Support\Facades\Auth;

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
        return view('walikelas.km.raportpts.setpaper', compact('title'));
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
        $tapel = Tapel::where('status', 1)->first();

        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->get('id');
        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        $paper_size = $request->paper_size;
        $orientation = $request->orientation;

        return view('walikelas.km.raportpts.index', compact('title', 'data_anggota_kelas', 'paper_size', 'orientation'));
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
        $tapel = Tapel::where('status', 1)->first();

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

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

        // Interval KKM                     
        // $kkm->predikat_d =  60.00;
        // $kkm->predikat_c =  70.00;
        // $kkm->predikat_b =  80.00;
        // $kkm->predikat_a =  100.00;

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
        $kehadiran_siswa = KehadiranSiswa::where('anggota_kelas_id', $anggota_kelas->id)->first();
        $catatan_wali_kelas = CatatanWaliKelas::where('anggota_kelas_id', $anggota_kelas->id)->first();

        $raport = PDF::loadview('walikelas.km.raportpts.raport', compact('title', 'sekolah', 'anggota_kelas', 'data_nilai', 'data_anggota_ekstrakulikuler', 'kehadiran_siswa', 'catatan_wali_kelas', 'nilai_akhir_total'))->setPaper($request->paper_size, $request->orientation);
        return $raport->stream('RAPORT PTS ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }
}
