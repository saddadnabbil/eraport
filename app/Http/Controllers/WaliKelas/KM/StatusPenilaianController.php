<?php

namespace App\Http\Controllers\WaliKelas\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\NilaiSumatif;
use App\Models\Pembelajaran;
use App\Models\NilaiFormatif;
use App\Models\KmNilaiAkhirRaport;
use App\Models\RencanaNilaiSumatif;
use App\Models\RencanaNilaiFormatif;
use App\Models\KmDeskripsiNilaiSiswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();
        $data_pembelajaran_kelas = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas_diampu)->where('status', 1)->get();

        $data_kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->get();

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
        return view('walikelas.km.statuspenilaian.index', compact('title', 'data_kelas', 'data_pembelajaran_kelas'));
    }
}
