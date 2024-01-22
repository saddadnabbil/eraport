<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\NilaiAkhir;
use App\AnggotaKelas;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\CapaianPembelajaran;
use App\RencanaNilaiSumatif;
use Illuminate\Http\Request;
use App\RencanaNilaiFormatif;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Term;
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

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        }

        return view('admin.km.penilaian.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_pembelajaran'));
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
            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
                ->where('anggota_kelas.kelas_id', $pembelajaran->kelas_id)
                ->where('siswa.status', 1)
                ->get();
            $pembelajaran_id = $request->pembelajaran_id;

            $tapel = Tapel::where('status', 1)->first();
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);

            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            $data_rencana_penilaian_sumatif = RencanaNilaiSumatif::with('nilai_sumatif')->where('term_id', $term->term)->where('pembelajaran_id', $request->pembelajaran_id)->get();
            $count_cp_sumatif = count($data_rencana_penilaian_sumatif);

            $data_rencana_penilaian_formatif = RencanaNilaiFormatif::with('nilai_formatif')->where('term_id', $term->term)->where('pembelajaran_id', $request->pembelajaran_id)->get();

            $count_cp_formatif = count($data_rencana_penilaian_formatif);

            if ($count_cp_sumatif == null) {
                return redirect(route('rencanasumatif.index'))->with('toast_error', 'Belum ada rencana penilaian sumatif ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana nilai sumatif ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
            } elseif ($count_cp_formatif == null) {
                return redirect(route('rencanaformatif.index'))->with('toast_error', 'Belum ada rencana penilaian formatif ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana nilai formatif ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
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
    
                    $nilaiAkhir = NilaiAkhir::where('anggota_kelas_id', $anggota_kelas->id)->first();
    
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

            return view('admin.km.penilaian.index', compact('title', 'pembelajaran_id', 'data_pembelajaran', 'data_anggota_kelas', 'data_rencana_penilaian_sumatif', 'count_cp_sumatif', 'data_rencana_penilaian_formatif', 'count_cp_formatif', 'rencana_penilaian_data_formatif', 'rencana_penilaian_data_sumatif', 'nilaiAkhirFormatif', 'nilaiAkhirSumatif', 'nilaiAkhirRaport', 'nilaiAkhirRevisi', 'term'));
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
            return back()->with('toast_error', 'Data siswa tidak ditemukan');
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
                for ($count_siswa = 0; $count_siswa < count($request->anggota_kelas_id); $count_siswa++) {
                    $nilaiAkhirSumatif = $request->nilaiAkhirSumatif;
                    $nilaiAkhirFormatif = $request->nilaiAkhirFormatif;

                    $bobotSumatif = 0.3;
                    $bobotFormatif = 0.7;

                    $nilaiAkhir = ($nilaiAkhirSumatif * $bobotSumatif) + ($nilaiAkhirFormatif * $bobotFormatif);

                    if (isset($request->nilai_revisi[$count_siswa])) {
                        $nilaiRevisi = $request->nilai_revisi[$count_siswa];
                    } else {
                        $nilaiRevisi = null;
                    }

                    $dataNilaiAkhir = [
                        'anggota_kelas_id' => $request->anggota_kelas_id[$count_siswa],
                        'pembelajaran_id' => $request->pembelajaran_id[$count_siswa],
                        'term_id' => $request->term_id[$count_siswa],
                        'nilai_akhir_formatif' => $nilaiAkhirFormatif,
                        'nilai_akhir_sumatif' => $nilaiAkhirSumatif,
                        'nilai_akhir_raport' => $nilaiAkhir,
                        'nilai_akhir_revisi' => $nilaiRevisi,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    NilaiAkhir::updateOrCreate(
                        [
                            'anggota_kelas_id' => $dataNilaiAkhir['anggota_kelas_id'],
                            'pembelajaran_id' => $dataNilaiAkhir['pembelajaran_id'],
                            'term_id' => $dataNilaiAkhir['term_id'],
                        ],
                        $dataNilaiAkhir
                    );
                }
            }

            return back()->with('toast_success', 'Data penilaian berhasil disimpan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
