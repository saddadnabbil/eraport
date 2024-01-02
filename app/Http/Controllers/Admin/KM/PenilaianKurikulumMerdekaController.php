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
        $title = 'Penilaian Kurikulum Merdeka';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

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
            $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)->get();
            $pembelajaran_id = $request->pembelajaran_id;

            $tapel = Tapel::findorfail(session()->get('tapel_id'));
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            // Data Rencana Nilai Sumatif
            // $data_rencana_penilaian_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $request->pembelajaran_id)->get();
            $data_rencana_penilaian_sumatif = RencanaNilaiSumatif::with('nilai_sumatif')->where('pembelajaran_id', $request->pembelajaran_id)->get();
            $count_cp_sumatif = count($data_rencana_penilaian_sumatif);

            // dd($data_rencana_penilaian_sumatif);

            // Data Rencana Nilai Formatif
            // $data_rencana_penilaian_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $request->pembelajaran_id)->get();
            $data_rencana_penilaian_formatif = RencanaNilaiFormatif::with('nilai_formatif')->where('pembelajaran_id', $request->pembelajaran_id)->get();

            $count_cp_formatif = count($data_rencana_penilaian_formatif);

            if ($count_cp_sumatif == null) {
                return redirect(route('rencanasumatif.index'))->with('toast_error', 'Belum ada rencana penilaian ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana nilai sumatif ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
            } elseif ($count_cp_formatif == null) {
                return redirect(route('rencanaformatif.index'))->with('toast_error', 'Belum ada rencana penilaian ' .  $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ', silahkan tambah rencana nilai formatif ' . $pembelajaran->mapel->nama_mapel . ' ' .  $pembelajaran->kelas->nama_kelas . ' terlebih dahulu!');
            }

            $rencana_penilaian_data_sumatif = [];
            $rencana_penilaian_data_formatif = [];

            // Tambahkan data Rencana Nilai Sumatif ke $rencana_penilaian_data
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
                    'kode_cp' => $rencana_penilaian_sumatif->capaian_pembelajaran->kode_cp,
                    'kode_penilaian' => $rencana_penilaian_sumatif->kode_penilaian,
                    'ringkasan_cp' => $rencana_penilaian_sumatif->capaian_pembelajaran->ringkasan_cp,
                    'teknik_penilaian' => $teknik_penilaian,
                    'bobot' => $rencana_penilaian_sumatif->bobot_teknik_penilaian
                ];
            }

            // Tambahkan data Rencana Nilai Formatif ke $rencana_penilaian_data
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
                    'kode_cp' => $rencana_penilaian_formatif->capaian_pembelajaran->kode_cp,
                    'kode_penilaian' => $rencana_penilaian_formatif->kode_penilaian,
                    'ringkasan_cp' => $rencana_penilaian_formatif->capaian_pembelajaran->ringkasan_cp,
                    'teknik_penilaian' => $teknik_penilaian,
                    'bobot' => $rencana_penilaian_formatif->bobot_teknik_penilaian
                ];
            }

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
                $anggota_kelas->nilaiAkhirRaport = $nilaiAkhirRevisi;
            }

            return view('admin.km.penilaian.index', compact('title', 'pembelajaran_id', 'data_pembelajaran', 'data_anggota_kelas', 'data_rencana_penilaian_sumatif', 'count_cp_sumatif', 'data_rencana_penilaian_formatif', 'count_cp_formatif', 'rencana_penilaian_data_formatif', 'rencana_penilaian_data_sumatif', 'nilaiAkhirFormatif', 'nilaiAkhirSumatif', 'nilaiAkhirRaport', 'nilaiAkhirRevisi'));
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

            // Proses untuk Penilaian Sumatif
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
                    $nilaiSumatif = $request->nilai_sumatif[$count_siswa]; // Ambil array nilai sumatif untuk siswa tertentu
                    $nilaiFormatif = $request->nilai_formatif[$count_siswa]; // Ambil array nilai formatif untuk siswa tertentu

                    $totalBobotFormatif = is_array($request->bobot_rencana_nilai_formatif_id) ? array_sum($request->bobot_rencana_nilai_formatif_id) : 0;
                    $totalBobotSumatif = is_array($request->bobot_rencana_nilai_sumatif_id) ? array_sum($request->bobot_rencana_nilai_sumatif_id) : 0;

                    $averageSumatif = 0;
                    $averageFormatif = 0;

                    // Hitung nilai rata-rata berdasarkan bobot
                    if ($totalBobotFormatif > 0) {
                        foreach ($nilaiFormatif as $index => $nilai) {
                            $averageFormatif += ($nilai * $request->bobot_rencana_nilai_formatif_id[$index] / $totalBobotFormatif);
                        }
                    }

                    if ($totalBobotSumatif > 0) {
                        foreach ($nilaiSumatif as $index => $nilai) {
                            $averageSumatif += ($nilai * $request->bobot_rencana_nilai_sumatif_id[$index] / $totalBobotSumatif);
                        }
                    }

                    // Hitung nilai akhir berdasarkan input formatif dan sumatif
                    $bobotSumatif = 0.3;
                    $bobotFormatif = 0.7;

                    $averageSumatif = count($nilaiSumatif) > 0 ? array_sum($nilaiSumatif) / count($nilaiSumatif) : 0;
                    $averageFormatif = count($nilaiFormatif) > 0 ? array_sum($nilaiFormatif) / count($nilaiFormatif) : 0;

                    $nilaiAkhir = ($averageSumatif * $bobotSumatif) + ($averageFormatif * $bobotFormatif);

                    if (isset($request->nilai_revisi[$count_siswa])) {
                        $nilaiRevisi = $request->nilai_revisi[$count_siswa];
                    } else {
                        $nilaiRevisi = null; // Atau nilai default lainnya sesuai kebutuhan Anda
                    }

                    // Disimpan ke database, misalnya:
                    $dataNilaiAkhir = [
                        'anggota_kelas_id' => $request->anggota_kelas_id[$count_siswa],
                        'nilai_akhir_formatif' => $averageFormatif,
                        'nilai_akhir_sumatif' => $averageSumatif,
                        'nilai_akhir_raport' => $nilaiAkhir,
                        'nilai_akhir_revisi' => $nilaiRevisi,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    // Simpan data ke dalam tabel nilai_akhirs atau tabel yang sesuai
                    // Anda bisa menggunakan metode updateOrCreate atau metode lain sesuai kebutuhan
                    // Contoh:
                    NilaiAkhir::updateOrCreate(
                        ['anggota_kelas_id' => $dataNilaiAkhir['anggota_kelas_id']],
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
