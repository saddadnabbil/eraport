<?php

namespace App\Http\Controllers\Guru\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use Carbon\Carbon;
use App\Models\KmKkmMapel;
use App\Models\NilaiAkhir;
use App\Models\AnggotaKelas;
use App\Models\NilaiSumatif;
use App\Models\Pembelajaran;
use App\Models\NilaiFormatif;
use App\Models\KmNilaiAkhirRaport;
use App\Models\RencanaNilaiSumatif;
use Illuminate\Http\Request;
use App\Models\RencanaNilaiFormatif;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KirimNilaiAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Kirim Nilai Akhir';
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('guru.km.kirimnilaiakhirkm.index', compact('title', 'data_pembelajaran', 'data_kelas'));
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
            $tapel = Tapel::where('status', 1)->first();

            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $kkm = KmKkmMapel::where('mapel_id', $pembelajaran->mapel_id)->where('kelas_id', $pembelajaran->kelas_id)->first();

            if (is_null($kkm)) {
                return back()->with('toast_error', 'Belum ada data kkm untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input kkm!');
            }

            $rencana_nilai_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get('id');
            $rencana_nilai_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get('id');

            if (count($rencana_nilai_sumatif) == 0 || count($rencana_nilai_formatif) == 0) {
                return back()->with('toast_warning', 'Data rencana penilaian tidak ditemukan');
            } else {
                $nilai_sumatif = NilaiSumatif::whereIn('rencana_nilai_sumatif_id', $rencana_nilai_sumatif)->groupBy('rencana_nilai_sumatif_id')->get();
                $nilai_formatif = NilaiFormatif::whereIn('rencana_nilai_formatif_id', $rencana_nilai_formatif)->groupBy('rencana_nilai_formatif_id')->get();

                if (count($rencana_nilai_sumatif) != count($nilai_sumatif) || count($rencana_nilai_formatif) != count($nilai_formatif)) {
                    return redirect(route('guru.penilaiankm.index'))->with('toast_warning', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
                } else {
                    // Data Master
                    $title = 'Kirim Nilai Akhir';
                    $tapel = Tapel::where('status', 1)->first();

                    $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
                    $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
                    $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

                    // Interval KKM
                    $kkm->predikat_d =  60.00;
                    $kkm->predikat_c =  70.00;
                    $kkm->predikat_b =  80.00;
                    $kkm->predikat_a =  100.00;

                    // Data Nilai
                    $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)
                        ->orderBy('id', 'DESC')
                        ->whereHas('siswa', function ($query) {
                            $query->where('status', 1);
                        })
                        ->get();

                    if (count($data_anggota_kelas) == 0) {
                        return redirect(route('guru.penilaiankm.index'))->with('toast_error', 'Data anggota kelas tidak ditemukan');
                    }

                    foreach ($data_anggota_kelas as $anggota_kelas) {
                        $data_nilai_akhir = NilaiAkhir::where('anggota_kelas_id', $anggota_kelas->id)->where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->first();

                        if (!is_null($data_nilai_akhir)) {
                            $nilai_akhir_pengetahuan = $data_nilai_akhir->nilai_akhir_sumatif;
                            $nilai_akhir_keterampilan = $data_nilai_akhir->nilai_akhir_formatif;
                            $nilai_akhir_raport  = $data_nilai_akhir->nilai_akhir_revisi;
                            if ($nilai_akhir_raport == null || $nilai_akhir_raport == 0) {
                                $nilai_akhir_raport = $data_nilai_akhir->nilai_akhir_raport;
                            }
                        } else {
                            $nilai_akhir_pengetahuan = 0;
                            $nilai_akhir_keterampilan = 0;
                            $nilai_akhir_raport = 0;

                            return redirect(route('guru.penilaiankm.index'))->with('toast_error', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
                        }

                        $anggota_kelas->nilai_pengetahuan = round($nilai_akhir_pengetahuan, 0);
                        $anggota_kelas->nilai_keterampilan = round($nilai_akhir_keterampilan, 0);
                        $anggota_kelas->nilai_akhir_raport = round($nilai_akhir_raport, 0);
                    }
                    return view('guru.km.kirimnilaiakhirkm.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'kkm', 'data_anggota_kelas', 'term', 'semester'));
                }
            }
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
        for ($cound_siswa = 0; $cound_siswa < count($request->anggota_kelas_id); $cound_siswa++) {
            $data_nilai = array(
                'pembelajaran_id' => $request->pembelajaran_id,
                'term_id'  => $request->term_id,
                'kkm' => $request->kkm,
                'anggota_kelas_id'  => $request->anggota_kelas_id[$cound_siswa],
                'nilai_sumatif'  => ltrim($request->nilai_pengetahuan[$cound_siswa]),
                'predikat_sumatif'  => $request->predikat_pengetahuan[$cound_siswa],
                'nilai_formatif'  => ltrim($request->nilai_keterampilan[$cound_siswa]),
                'predikat_formatif'  => $request->predikat_keterampilan[$cound_siswa],
                'nilai_akhir_raport'  => ltrim($request->nilai_akhir_raport[$cound_siswa]),
                'predikat_akhir_raport'  => $request->predikat_akhir_raport[$cound_siswa],
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            );

            $cek_nilai = KmNilaiAkhirRaport::where('pembelajaran_id', $request->pembelajaran_id)
                ->where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->where('term_id', $request->term_id)
                ->first();

            if (is_null($cek_nilai)) {
                KmNilaiAkhirRaport::insert($data_nilai);
            } else {
                $cek_nilai->update($data_nilai);
            }
        }
        return back()->with('toast_success', 'Nilai akhir raport berhasil dikirim');
    }
}
