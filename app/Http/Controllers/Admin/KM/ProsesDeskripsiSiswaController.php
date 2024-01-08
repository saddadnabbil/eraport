<?php

namespace App\Http\Controllers\Admin\KM;

use App\Guru;
use App\Kelas;
use App\Tapel;
use Carbon\Carbon;
use App\K13KdMapel;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\KmNilaiAkhirRaport;
use App\CapaianPembelajaran;
use App\K13NilaiAkhirRaport;
use App\K13NilaiPengetahuan;
use App\RencanaNilaiSumatif;
use Illuminate\Http\Request;
use App\K13NilaiKeterampilan;
use App\RencanaNilaiFormatif;
use App\KmDeskripsiNilaiSiswa;
use App\K13DeskripsiNilaiSiswa;
use App\K13RencanaNilaiPengetahuan;
use App\Http\Controllers\Controller;
use App\K13RencanaNilaiKeterampilan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProsesDeskripsiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Input Deskripsi Nilai Siswa';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        // $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('admin.km.prosesdeskripsi.index', compact('title', 'data_pembelajaran'));
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

            // Data Master
            $title = 'Input Deskripsi Nilai Siswa';
            $tapel = Tapel::findorfail(session()->get('tapel_id'));

            // $guru = Guru::where('user_id', Auth::user()->id)->first();
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $data_nilai_siswa = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->get();

            if ($data_nilai_siswa->count() == 0) {
                return redirect(route('prosesdeskripsikmadmin.index'))->with('toast_error', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
            } else {
                foreach ($data_nilai_siswa as $nilai_siswa) {
                    $rencana_nilai_sumatif_id = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran->id)->get('id');
                    $nilai_sumatif_terbaik = NilaiSumatif::whereIn('rencana_nilai_sumatif_id', $rencana_nilai_sumatif_id)->where('anggota_kelas_id', $nilai_siswa->anggota_kelas_id)->orderBy('nilai', 'DESC')->first();
                    $rencana_nilai_sumatif_terbaik_id = RencanaNilaiSumatif::findorfail($nilai_sumatif_terbaik->rencana_nilai_sumatif_id);
                    // $cp_sumatif_terbaik = CapaianPembelajaran::findorfail($rencana_nilai_sumatif_terbaik_id->capaian_pembelajaran_id);

                    // $nilai_siswa->deskripsi_sumatif = $cp_sumatif_terbaik->ringkasan_cp;

                    $rencana_nilai_formatif_id = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->get('id');
                    $nilai_formatif_terbaik = NilaiFormatif::whereIn('rencana_nilai_formatif_id', $rencana_nilai_formatif_id)->where('anggota_kelas_id', $nilai_siswa->anggota_kelas_id)->orderBy('nilai', 'DESC')->first();
                    $rencana_nilai_formatif_terbaik = RencanaNilaiFormatif::findorfail($nilai_formatif_terbaik->rencana_nilai_formatif_id);
                    // $cp_formatif_terbaik = CapaianPembelajaran::findorfail($rencana_nilai_formatif_terbaik->capaian_pembelajaran_id);

                    // $nilai_siswa->deskripsi_formatif = $cp_formatif_terbaik->ringkasan_cp;

                    $nilai_siswa->deskripsi_nilai_siswa = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran->id)->where('km_nilai_akhir_raport_id', $nilai_siswa->id)->first();
                }
            }
            return view('admin.km.prosesdeskripsi.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'data_nilai_siswa'));
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
        if (is_null($request->nilai_akhir_raport_id)) {
            return back()->with('toast_error', 'Tidak ditemukan data deskripsi nilai siswa');
        } else {
            for ($cound_siswa = 0; $cound_siswa < count($request->nilai_akhir_raport_id); $cound_siswa++) {
                $data_deskripsi = array(
                    'pembelajaran_id' => $request->pembelajaran_id,
                    'km_nilai_akhir_raport_id'  => $request->nilai_akhir_raport_id[$cound_siswa],
                    'deskripsi_raport'  => $request->deskripsi_raport[$cound_siswa],
                    // 'deskripsi_formatif'  => $request->deskripsi_formatif[$cound_siswa],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );

                $cek_data = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $request->pembelajaran_id)->where('km_nilai_akhir_raport_id', $request->nilai_akhir_raport_id[$cound_siswa])->first();
                if (is_null($cek_data)) {
                    KmDeskripsiNilaiSiswa::insert($data_deskripsi);
                } else {
                    $cek_data->update($data_deskripsi);
                }
            }
            return redirect(route('prosesdeskripsikmadmin.index'))->with('toast_success', 'Deskripsi nilai siswa berhasil disimpan');
        }
    }
}
