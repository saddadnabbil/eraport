<?php

namespace App\Http\Controllers\WaliKelas\KM;

use PDF;
use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\KehadiranSiswa;
use App\Models\Ekstrakulikuler;
use App\Models\CatatanWaliKelas;
use App\Models\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use App\Models\NilaiEkstrakulikuler;
use Illuminate\Support\Facades\Auth;
use App\Models\AnggotaEkstrakulikuler;
use Illuminate\Support\Facades\Validator;

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
        $tapel = Tapel::where('status', 1)->first();

        return view('walikelas.km.raportpts.setpaper', compact('title', 'tapel'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'term_id' => 'required',
            'semester_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $title = 'Raport Tengah Semester';
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::findorfail($request->term_id);
        $semester = Semester::findorfail($request->semester_id);

        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();
        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $kelas_id_anggota_kelas)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        $kelas = Kelas::findorfail($id_kelas_diampu);

        $paper_size = 'A4';
        $orientation = 'potrait';

        return view('walikelas.km.raportpts.index', compact('title', 'data_anggota_kelas', 'paper_size', 'orientation', 'tapel', 'semester', 'term', 'kelas'));
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
        $term = Term::findorfail($request->term_id);
        $semester = Semester::findorfail($request->term_id);

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');
        $data_nilai = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran)->where('term_id', $term->id)->where('semester_id', $semester->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();

        $data_nilai_term_1 = KmNilaiAkhirRaport::where('term_id', 1)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('semester_id', $semester->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();

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

        $raport = PDF::loadview('walikelas.km.raportpts.raport', compact('title', 'sekolah', 'anggota_kelas', 'data_nilai', 'data_anggota_ekstrakulikuler', 'kehadiran_siswa', 'catatan_wali_kelas', 'nilai_akhir_total', 'semester', 'term'))->setPaper($request->paper_size, $request->orientation);
        return $raport->stream('RAPORT PTS ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }
}
