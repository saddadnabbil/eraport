<?php

namespace App\Http\Controllers\Guru\KM;

use App\AnggotaKelas;
use App\Guru;
use App\Http\Controllers\Controller;
use App\KmKkmMapel;
use App\K13NilaiAkhirRaport;
use App\K13NilaiKeterampilan;
use App\K13NilaiPengetahuan;
use App\K13NilaiPtsPas;
use App\K13NilaiSosial;
use App\K13NilaiSpiritual;
use App\K13RencanaBobotPenilaian;
use App\K13RencanaNilaiKeterampilan;
use App\K13RencanaNilaiPengetahuan;
use App\K13RencanaNilaiSosial;
use App\K13RencanaNilaiSpiritual;
use App\Kelas;
use App\KmNilaiAkhirRaport;
use App\NilaiAkhir;
use App\NilaiFormatif;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\RencanaNilaiFormatif;
use App\RencanaNilaiSumatif;
use App\Tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('guru.km.kirimnilaiakhirkm.index', compact('title', 'data_pembelajaran'));
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
            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);

            $kkm = KmKkmMapel::where('mapel_id', $pembelajaran->mapel_id)->where('kelas_id', $pembelajaran->kelas_id)->first();

            if (is_null($kkm)) {
                return back()->with('toast_warning', 'KKM mata pelajaran belum ditentukan');
            }

            $rencana_nilai_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran->id)->get('id');
            $rencana_nilai_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->get('id');

            if (count($rencana_nilai_sumatif) == 0 || count($rencana_nilai_formatif) == 0) {
                return back()->with('toast_warning', 'Data rencana penilaian tidak ditemukan');
            } else {
                $nilai_sumatif = NilaiSumatif::whereIn('rencana_nilai_sumatif_id', $rencana_nilai_sumatif)->groupBy('rencana_nilai_sumatif_id')->get();
                $nilai_formatif = NilaiFormatif::whereIn('rencana_nilai_formatif_id', $rencana_nilai_formatif)->groupBy('rencana_nilai_formatif_id')->get();

                if (count($rencana_nilai_sumatif) != count($nilai_sumatif) || count($rencana_nilai_formatif) != count($nilai_formatif)) {
                    return back()->with('toast_warning', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
                } else {
                    // Data Master
                    $title = 'Kirim Nilai Akhir';
                    $tapel = Tapel::findorfail(session()->get('tapel_id'));

                    $guru = Guru::where('user_id', Auth::user()->id)->first();
                    $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
                    $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

                    // Interval KKM
                    $range = (100 - $kkm->kkm) / 3;
                    $kkm->predikat_c = round($kkm->kkm, 0);
                    $kkm->predikat_b = round($kkm->kkm + $range, 0);
                    $kkm->predikat_a = round($kkm->kkm + ($range * 2), 0);

                    /// Data Nilai
                    $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)->get();
                    foreach ($data_anggota_kelas as $anggota_kelas) {

                        $data_nilai_akhir = NilaiAkhir::where('anggota_kelas_id', $anggota_kelas->id)
                            ->first();

                        $nilai_akhir_pengetahuan = $data_nilai_akhir->nilai_akhir_sumatif;

                        $nilai_akhir_keterampilan = $data_nilai_akhir->nilai_akhir_formatif;

                        $nilai_akhir_raport  = $data_nilai_akhir->nilai_akhir_revisi;

                        if ($nilai_akhir_raport == null || $nilai_akhir_raport == 0) {
                            $nilai_akhir_raport = $data_nilai_akhir->nilai_akhir_raport;
                        }

                        $anggota_kelas->nilai_pengetahuan = round($nilai_akhir_pengetahuan, 0);
                        $anggota_kelas->nilai_keterampilan = round($nilai_akhir_keterampilan, 0);
                        $anggota_kelas->nilai_akhir_raport = round($nilai_akhir_raport, 0);
                    }
                    return view('guru.km.kirimnilaiakhirkm.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'kkm', 'data_anggota_kelas'));
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
                ->where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])
                ->first();

            if (is_null($cek_nilai)) {
                KmNilaiAkhirRaport::insert($data_nilai);
            } else {
                $cek_nilai->update($data_nilai);
            }
        }
        return redirect(route('kirimnilaiakhirkm.index'))->with('toast_success', 'Nilai akhir raport berhasil dikirim');
    }
}
