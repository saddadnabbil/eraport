<?php

namespace App\Http\Controllers\Admin\KM;

use App\Term;
use App\Kelas;
use App\Tapel;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\K13NilaiPtsPas;
use App\K13NilaiSosial;
use App\K13NilaiSpiritual;
use App\KmNilaiAkhirRaport;
use App\K13NilaiAkhirRaport;
use App\K13NilaiPengetahuan;
use App\RencanaNilaiSumatif;
use Illuminate\Http\Request;
use App\K13NilaiKeterampilan;
use App\RencanaNilaiFormatif;
use App\K13RencanaNilaiSosial;
use App\KmDeskripsiNilaiSiswa;
use App\K13DeskripsiNilaiSiswa;
use App\K13RencanaBobotPenilaian;
use App\K13RencanaNilaiSpiritual;
use App\K13RencanaNilaiPengetahuan;
use App\Http\Controllers\Controller;
use App\K13RencanaNilaiKeterampilan;

class StatusPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Status Penilaian';
        $data_kelas = Kelas::where('tapel_id', session()->get('tapel_id'))->get();
        return view('admin.km.statuspenilaian.pilihkelas', compact('title', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Status Penilaian';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        $kelas = Kelas::findorfail($request->kelas_id);

        $data_pembelajaran_kelas = Pembelajaran::where('kelas_id', $kelas->id)->where('status', 1)->get();
        foreach ($data_pembelajaran_kelas as $pembelajaran) {
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $rencana_pengetahuan = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->first();
            if (is_null($rencana_pengetahuan)) {
                $pembelajaran->rencana_pengetahuan = 0;
                $pembelajaran->nilai_pengetahuan = 0;
            } else {
                $pembelajaran->rencana_pengetahuan = 1;
                $nilai_pengetahuan = NilaiSumatif::where('rencana_nilai_sumatif_id', $rencana_pengetahuan->id)->first();
                if (is_null($nilai_pengetahuan)) {
                    $pembelajaran->nilai_pengetahuan = 0;
                } else {
                    $pembelajaran->nilai_pengetahuan = 1;
                }
            }

            $rencana_keterampilan = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->first();
            if (is_null($rencana_keterampilan)) {
                $pembelajaran->rencana_keterampilan = 0;
                $pembelajaran->nilai_keterampilan = 0;
            } else {
                $pembelajaran->rencana_keterampilan = 1;
                $nilai_keterampilan = NilaiFormatif::where('rencana_nilai_formatif_id', $rencana_keterampilan->id)->first();
                if (is_null($nilai_keterampilan)) {
                    $pembelajaran->nilai_keterampilan = 0;
                } else {
                    $pembelajaran->nilai_keterampilan = 1;
                }
            }

            $nilai_akhir = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->first();
            if (is_null($nilai_akhir)) {
                $pembelajaran->nilai_akhir = 0;
            } else {
                $pembelajaran->nilai_akhir = 1;
            }

            $deskripsi = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->first();
            if (is_null($deskripsi)) {
                $pembelajaran->deskripsi = 0;
            } else {
                $pembelajaran->deskripsi = 1;
            }
        }
        return view('admin.km.statuspenilaian.index', compact('title', 'kelas', 'data_kelas', 'data_pembelajaran_kelas'));
    }
}
