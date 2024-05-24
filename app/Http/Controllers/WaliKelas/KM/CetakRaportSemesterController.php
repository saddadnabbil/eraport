<?php

namespace App\Http\Controllers\WaliKelas\KM;

use PDF;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\KmTglRaport;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\PrestasiSiswa;
use App\Models\KehadiranSiswa;
use App\Models\Ekstrakulikuler;
use App\Models\CatatanWaliKelas;
use App\Models\KmNilaiAkhirRaport;
use Illuminate\Http\Request;
use App\Models\NilaiEkstrakulikuler;
use App\Models\AnggotaEkstrakulikuler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CetakRaportSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Print Report Semester';
        $tapel = Tapel::where('status', 1)->first();

        return view('walikelas.km.raportsemester.setpaper', compact('title', 'tapel'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Print Report Semester';
        $tapel = Tapel::where('status', 1)->first();
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

        $paper_size = 'A4';
        $orientation = 'potrait';

        return view('walikelas.km.raportsemester.index', compact('title', 'data_anggota_kelas', 'paper_size', 'orientation', 'tapel', 'semester'));
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
        $semester = Semester::findorfail($request->semester_id);

        if ($request->data_type == 1) {
            $title = 'Completeness of Report';
            $kelengkapan_raport = PDF::loadview('walikelas.km.raportsemester.kelengkapanraport', compact('title', 'sekolah', 'anggota_kelas', 'semester'))->setPaper($request->paper_size, $request->orientation);
            return $kelengkapan_raport->stream('KELENGKAPAN RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
        } elseif ($request->data_type == 2) {
            $title = 'Raport Semester';
            $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

            $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');

            $data_nilai_term_1 = KmNilaiAkhirRaport::where('term_id', 1)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_term_2 = KmNilaiAkhirRaport::where('term_id', 2)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            // Inisialisasi array untuk Final Grade total
            $data_nilai_akhir_total = [];

            // Looping untuk semua term dan semester
            for ($semester_id = 1; $semester_id <= 2; $semester_id++) {
                // Inisialisasi array untuk Final Grade semester
                $data_nilai_akhir_semester = [];

                for ($term = 1; $term <= 2; $term++) {
                    // Ambil data nilai untuk term dan semester tertentu
                    $data_nilai = KmNilaiAkhirRaport::where('term_id', $term)->where('semester_id', $semester_id)->whereIn('pembelajaran_id', $data_id_pembelajaran)->where('anggota_kelas_id', $anggota_kelas->id)->get();

                    $nilai_akhir = [];
                    foreach ($data_nilai as $nilai) {
                        $nilai_akhir[] = [
                            'pembelajaran_id' => $nilai->pembelajaran_id,
                            'nilai_akhir_raport' => $nilai->nilai_akhir_raport,
                            'nama_mapel' => $nilai->pembelajaran->mapel->nama_mapel,
                            'nama_mapel_indonesian' => $nilai->pembelajaran->mapel->nama_mapel_indonesian,
                            'kkm' => $nilai->kkm,
                            'deskripsi_nilai' => $nilai->km_deskripsi_nilai_siswa,
                            'semester_id' => $nilai->semester_id, // Tambahkan 'semester_id' ke dalam data
                        ];
                    }

                    // Hitung Final Grade untuk term dan semester tertentu
                    foreach ($nilai_akhir as $nilai) {
                        $pembelajaran_id = $nilai['pembelajaran_id'];
                        $key = "nilai_akhir_term_{$term}_semester_{$semester_id}";
                        if (!isset($data_nilai_akhir_semester[$pembelajaran_id])) {
                            $data_nilai_akhir_semester[$pembelajaran_id] = ['nilai' => 0, 'predikat' => '', 'nama_mapel' => '', 'semester_id' => $semester_id];
                        }
                        $data_nilai_akhir_semester[$pembelajaran_id][$key] = $nilai['nilai_akhir_raport'];
                        $data_nilai_akhir_semester[$pembelajaran_id]['nilai'] += $nilai['nilai_akhir_raport'];
                        $data_nilai_akhir_semester[$pembelajaran_id]['nama_mapel'] = $nilai['nama_mapel'];
                        $data_nilai_akhir_semester[$pembelajaran_id]['nama_mapel_indonesian'] = $nilai['nama_mapel_indonesian'];
                        $data_nilai_akhir_semester[$pembelajaran_id]['kkm'] = $nilai['kkm'];
                        $data_nilai_akhir_semester[$pembelajaran_id]['deskripsi_nilai'] = $nilai['deskripsi_nilai'];
                    }
                }

                // Hitung Final Grade untuk semester tertentu
                $data_nilai_akhir_semester = array_map(function ($data) {
                    $data['nilai'] /= 2; // Bagi dengan jumlah term (dalam hal ini, 2)

                    // Tentukan predikat berdasarkan Final Grade total
                    $kkm = [
                        'predikat_a' => 80.00,
                        'predikat_b' => 70.00,
                        'predikat_c' => 60.00,
                        'predikat_d' => 0.00,
                    ];

                    if ($data['nilai'] >= $kkm['predikat_a'] && $data['nilai'] <= 100.00) {
                        $data['predikat'] = 'A';
                    } elseif ($data['nilai'] >= $kkm['predikat_b'] && $data['nilai'] < $kkm['predikat_a']) {
                        $data['predikat'] = 'B';
                    } elseif ($data['nilai'] >= $kkm['predikat_c'] && $data['nilai'] < $kkm['predikat_b']) {
                        $data['predikat'] = 'C';
                    } elseif ($data['nilai'] >= $kkm['predikat_d'] && $data['nilai'] <= $kkm['predikat_c']) {
                        $data['predikat'] = 'D';
                    } else {
                        // Jika nilai di luar rentang 0-100, berikan nilai tidak valid atau sebutkan logika yang sesuai
                        $data['predikat'] = 'Nilai Tidak Valid';
                    }

                    return $data;
                }, $data_nilai_akhir_semester);

                // Simpan hasil Final Grade semester dalam variabel sesuai semester
                if ($semester_id == 1) {
                    $data_nilai_akhir_semester_1 = $data_nilai_akhir_semester;
                } elseif ($semester_id == 2) {
                    $data_nilai_akhir_semester_2 = $data_nilai_akhir_semester;
                }

                // Masukkan ke dalam array Final Grade total jika sudah ada data dari kedua semester
                if (isset($data_nilai_akhir_semester_1) && isset($data_nilai_akhir_semester_2)) {
                    $data_nilai_akhir_total = [];

                    foreach ($data_nilai_akhir_semester_1 as $pembelajaran_id => $data_semester_1) {
                        if (isset($data_nilai_akhir_semester_2[$pembelajaran_id])) {
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_total'] = ($data_semester_1['nilai'] + $data_nilai_akhir_semester_2[$pembelajaran_id]['nilai']) / 2;
                            $data_nilai_akhir_total[$pembelajaran_id]['nama_mapel'] = $data_semester_1['nama_mapel'];
                            $data_nilai_akhir_total[$pembelajaran_id]['nama_mapel_indonesian'] = $data_semester_1['nama_mapel_indonesian'];
                            $data_nilai_akhir_total[$pembelajaran_id]['kkm'] = $data_semester_1['kkm'];
                            $data_nilai_akhir_total[$pembelajaran_id]['deskripsi_nilai'] = $data_semester_1['deskripsi_nilai'];
                            $data_nilai_akhir_total[$pembelajaran_id]['semester_id'] = $semester_id;
                            $data_nilai_akhir_total[$pembelajaran_id]['predikat'] = $data_semester_1['predikat'];


                            // Tambahkan nilai untuk setiap term dan semester jika tersedia
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_term_1_semester_1'] = $data_semester_1['nilai_akhir_term_1_semester_1'] ?? null;
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_term_2_semester_1'] = $data_semester_1['nilai_akhir_term_2_semester_1'] ?? null;
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_term_1_semester_2'] = $data_nilai_akhir_semester_2[$pembelajaran_id]['nilai_akhir_term_1_semester_2'] ?? null;
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_term_2_semester_2'] = $data_nilai_akhir_semester_2[$pembelajaran_id]['nilai_akhir_term_2_semester_2'] ?? null;

                            // Tambahan Final Grade total untuk per semester
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_semester_1'] = $data_semester_1['nilai'];
                            $data_nilai_akhir_total[$pembelajaran_id]['nilai_akhir_semester_2'] = $data_nilai_akhir_semester_2[$pembelajaran_id]['nilai'];
                        }
                    }
                }
            }

            // Sekarang, $data_nilai_akhir_total berisi Final Grade untuk masing-masing term dan semester dengan 'semester_id'.

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
                $raport = PDF::loadview('walikelas.km.raportsemester.raport', compact('title', 'sekolah', 'anggota_kelas',  'data_anggota_ekstrakulikuler', 'data_prestasi_siswa', 'kehadiran_siswa', 'catatan_wali_kelas', 'data_nilai', 'data_nilai_akhir_total', 'semester'))->setPaper($request->paper_size, $request->orientation);
                return $raport->stream('RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
            }
        }
    }
}
