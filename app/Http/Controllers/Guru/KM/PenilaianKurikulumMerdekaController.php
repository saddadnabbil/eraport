<?php

namespace App\Http\Controllers\Guru\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\NilaiAkhir;
use App\Models\AnggotaKelas;
use App\Models\NilaiSumatif;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\NilaiFormatif;
use Illuminate\Support\Carbon;
use App\Models\CapaianPembelajaran;
use App\Models\RencanaNilaiSumatif;
use App\Http\Controllers\Controller;
use App\Models\RencanaNilaiFormatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenilaianKurikulumMerdekaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Penilaian Raport';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();
        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

        if (isset($guru)) {
            $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        } else {
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
        }

        if (count($data_mapel) == 0) {
            return redirect(route('guru.mapel.index'))->with('toast_warning', 'Mohon isikan Subject Data');
        } elseif (count($data_kelas) == 0) {
            return redirect(route('guru.kelas.index'))->with('toast_warning', 'Mohon isikan data kelas');
        }

        return view('guru.km.penilaian.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_pembelajaran', 'tapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembelajaran_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Input Nilai Kurikulum Merdeka';

            $user = Auth::user();
            if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum'])) {
                $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            }

            if (isset($guru)) {
                $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
                $pembelajaran = Pembelajaran::where('guru_id', $guru->id)->findorfail($request->pembelajaran_id);
            } else {
                $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            }

            $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)
                ->orderBy('id', 'DESC')
                ->whereHas('siswa', function ($query) {
                    $query->where('status', 1);
                })
                ->get();
            $pembelajaran_id = $request->pembelajaran_id;

            $tapel = Tapel::where('status', 1)->first();
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

            if (isset($guru)) {
                $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
            } else {
                $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
            }

            $data_rencana_penilaian_sumatif = RencanaNilaiSumatif::with('nilai_sumatif')->where('term_id', $term->term)->where('semester_id', $semester->id)->where('pembelajaran_id', $request->pembelajaran_id)->get();
            $count_cp_sumatif = count($data_rencana_penilaian_sumatif);

            $data_rencana_penilaian_formatif = RencanaNilaiFormatif::with('nilai_formatif')->where('term_id', $term->term)->where('semester_id', $semester->id)->where('pembelajaran_id', $request->pembelajaran_id)->get();

            $count_cp_formatif = count($data_rencana_penilaian_formatif);

            if ($count_cp_sumatif == null) {
                return redirect(route('guru.km.rencanasumatif.index'))->with('toast_error', 'Belum ada Grading Plan sumatif ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana Sumatif Grade ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
            } elseif ($count_cp_formatif == null) {
                return redirect(route('guru.km.rencanaformatif.index'))->with('toast_error', 'Belum ada Grading Plan formatif ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana Formatif Grade ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
            }

            $rencana_penilaian_data_sumatif = [];
            $rencana_penilaian_data_formatif = [];

            foreach ($data_rencana_penilaian_sumatif as $rencana_penilaian_sumatif) {
                $teknik_penilaian = '';

                if ($rencana_penilaian_sumatif->teknik_penilaian == 1) {
                    $teknik_penilaian = 'Tes Tulis';
                } elseif ($rencana_penilaian_sumatif->teknik_penilaian == 2) {
                    $teknik_penilaian = 'Tes Lisan';
                } elseif ($rencana_penilaian_sumatif->teknik_penilaian == 3) {
                    $teknik_penilaian = 'Penugasan';
                }

                $rencana_penilaian_data_sumatif[] = [
                    'id' => $rencana_penilaian_sumatif->id,
                    'kode_penilaian' => $rencana_penilaian_sumatif->kode_penilaian,
                    'teknik_penilaian' => $teknik_penilaian,
                    'bobot' => $rencana_penilaian_sumatif->bobot_teknik_penilaian
                ];
            }

            foreach ($data_rencana_penilaian_formatif as $rencana_penilaian_formatif) {
                $teknik_penilaian = '';

                switch ($rencana_penilaian_formatif->teknik_penilaian) {
                    case 1:
                        $teknik_penilaian = 'Praktik';
                        break;
                    case 2:
                        $teknik_penilaian = 'Projek';
                        break;
                    case 3:
                        $teknik_penilaian = 'Produk';
                        break;
                    case 4:
                        $teknik_penilaian = 'Teknik 1';
                        break;
                    case 5:
                        $teknik_penilaian = 'Teknik 2';
                        break;
                }

                $rencana_penilaian_data_formatif[] = [
                    'id' => $rencana_penilaian_formatif->id,
                    'kode_penilaian' => $rencana_penilaian_formatif->kode_penilaian,
                    'teknik_penilaian' => $teknik_penilaian,
                    'bobot' => $rencana_penilaian_formatif->bobot_teknik_penilaian
                ];
            }

            if ($data_anggota_kelas->isEmpty()) {
                $nilaiAkhirFormatif = 0;
                $nilaiAkhirSumatif = 0;
                $nilaiAkhirRaport = 0;
                $nilaiAkhirRevisi = null;
            } else {
                foreach ($data_anggota_kelas as $anggota_kelas) {
                    $nilaiAkhirFormatif = 0;
                    $nilaiAkhirSumatif = 0;
                    $nilaiAkhirRaport = 0;
                    $nilaiAkhirRevisi = null;

                    $nilaiAkhir = NilaiAkhir::where('anggota_kelas_id', $anggota_kelas->id)->where('term_id', $term->term)->where('semester_id', $semester->id)->first();

                    if ($nilaiAkhir) {
                        $nilaiAkhirFormatif = $nilaiAkhir->nilai_akhir_formatif;
                        $nilaiAkhirSumatif = $nilaiAkhir->nilai_akhir_sumatif;
                        $nilaiAkhirRaport = $nilaiAkhir->nilai_akhir_raport;
                        $nilaiAkhirRevisi = $nilaiAkhir->nilai_akhir_revisi;
                    }

                    $anggota_kelas->nilaiAkhirFormatif = $nilaiAkhirFormatif;
                    $anggota_kelas->nilaiAkhirSumatif = $nilaiAkhirSumatif;
                    $anggota_kelas->nilaiAkhirRaport = $nilaiAkhirRaport;
                    $anggota_kelas->nilaiAkhirRevisi = $nilaiAkhirRevisi;
                }
            }

            return view('guru.km.penilaian.index', compact('title', 'pembelajaran_id', 'data_pembelajaran', 'data_anggota_kelas', 'data_rencana_penilaian_sumatif', 'count_cp_sumatif', 'data_rencana_penilaian_formatif', 'count_cp_formatif', 'rencana_penilaian_data_formatif', 'rencana_penilaian_data_sumatif', 'nilaiAkhirFormatif', 'nilaiAkhirSumatif', 'nilaiAkhirRaport', 'nilaiAkhirRevisi', 'term', 'semester'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->anggota_kelas_id)) {
            return back()->with('toast_error', 'Student Data tidak ditemukan');
        } else {
            $data_penilaian_sumatif_siswa = array();
            $data_penilaian_formatif_siswa = array();

            for ($count_siswa = 0; $count_siswa < count($request->anggota_kelas_id); $count_siswa++) {
                for ($count_penilaian = 0; $count_penilaian < count($request->rencana_nilai_sumatif_id); $count_penilaian++) {
                    if ($request->nilai_sumatif[$count_penilaian][$count_siswa] >= 0 && $request->nilai_sumatif[$count_penilaian][$count_siswa] <= 100) {
                        $data_nilai_sumatif = [
                            'anggota_kelas_id' => $request->anggota_kelas_id[$count_siswa],
                            'rencana_nilai_sumatif_id' => $request->rencana_nilai_sumatif_id[$count_penilaian],
                            'nilai' => ltrim($request->nilai_sumatif[$count_penilaian][$count_siswa]),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        NilaiSumatif::updateOrCreate(
                            [
                                'anggota_kelas_id' => $data_nilai_sumatif['anggota_kelas_id'],
                                'rencana_nilai_sumatif_id' => $data_nilai_sumatif['rencana_nilai_sumatif_id']
                            ],
                            $data_nilai_sumatif
                        );
                    } else {
                        return back()->with('toast_error', 'Nilai harus berisi antara 0 s/d 100');
                    }
                }
            }

            // Proses untuk Penilaian Formatif
            for ($count_siswa = 0; $count_siswa < count($request->anggota_kelas_id); $count_siswa++) {
                for ($count_penilaian = 0; $count_penilaian < count($request->rencana_nilai_formatif_id); $count_penilaian++) {
                    if ($request->nilai_formatif[$count_penilaian][$count_siswa] >= 0 && $request->nilai_formatif[$count_penilaian][$count_siswa] <= 100) {
                        $data_nilai_formatif = [
                            'anggota_kelas_id' => $request->anggota_kelas_id[$count_siswa],
                            'rencana_nilai_formatif_id' => $request->rencana_nilai_formatif_id[$count_penilaian],
                            'nilai' => ltrim($request->nilai_formatif[$count_penilaian][$count_siswa]),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        NilaiFormatif::updateOrCreate(
                            [
                                'anggota_kelas_id' => $data_nilai_formatif['anggota_kelas_id'],
                                'rencana_nilai_formatif_id' => $data_nilai_formatif['rencana_nilai_formatif_id']
                            ],
                            $data_nilai_formatif
                        );
                    } else {
                        return back()->with('toast_error', 'Nilai harus berisi antara 0 s/d 100');
                    }
                }
            }

            if (
                !empty($request->anggota_kelas_id) &&
                !empty($request->nilai_sumatif) &&
                !empty($request->nilai_formatif) ||
                !empty($request->nilai_revisi)
            ) {
                foreach ($request->anggota_kelas_id as $count_siswa => $anggota_kelas_id) {
                    // Hitung Final Grade
                    $nilaiAkhirSumatif = $request->nilaiAkhirSumatif[$count_siswa];
                    $nilaiAkhirFormatif = $request->nilaiAkhirFormatif[$count_siswa];
                    $bobotSumatif = 0.3;
                    $bobotFormatif = 0.7;
                    $nilaiAkhir = ($nilaiAkhirSumatif * $bobotSumatif) + ($nilaiAkhirFormatif * $bobotFormatif);

                    // Simpan Final Grade
                    NilaiAkhir::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggota_kelas_id,
                            'pembelajaran_id' => $request->pembelajaran_id,
                            'term_id' => $request->term_id,
                            'semester_id' => $request->semester_id,
                        ],
                        [
                            'nilai_akhir_formatif' => $nilaiAkhirFormatif,
                            'nilai_akhir_sumatif' => $nilaiAkhirSumatif,
                            'nilai_akhir_raport' => $nilaiAkhir,
                            'nilai_akhir_revisi' => $request->nilai_revisi[$count_siswa] ?? null,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }

            return back()->with('toast_success', 'Data penilaian berhasil disimpan.');
        }
    }
}
