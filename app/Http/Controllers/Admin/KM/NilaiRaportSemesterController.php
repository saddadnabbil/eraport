<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\KmNilaiAkhirRaport;
use App\K13NilaiAkhirRaport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Term;
use Illuminate\Support\Facades\Validator;

class NilaiRaportSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Nilai Raport Semester';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $term = Term::findorfail(session()->get('term_id'));

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('admin.km.nilairaport.pilihkelas', compact('title', 'data_pembelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembelajaran_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Nilai Raport Semester';
            $tapel = Tapel::findorfail(session()->get('tapel_id'));
            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $pembelajaran_id = $request->pembelajaran_id;

            $data_kelas = Kelas::findorfail($pembelajaran->kelas_id);
            $kelas_id = $data_kelas->id;
            $data_mapel = Mapel::findorfail($pembelajaran->mapel_id);
            $mapel_id = $data_mapel->id;

            $data_pembelajaran = Pembelajaran::where('kelas_id', $kelas_id)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            $pembelajaran = Pembelajaran::where('mapel_id', $mapel_id)->where('kelas_id', $kelas_id)->first();
            if (is_null($pembelajaran)) {
                return back()->with('toast_error', 'Data pembelajaran tidak ditemukan');
            } else {

                $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
                    ->orderBy('siswa.nama_lengkap', 'ASC')
                    ->where('anggota_kelas.kelas_id', $kelas_id)
                    ->where('siswa.status', 1)
                    ->get();

                foreach ($data_anggota_kelas as $anggota_kelas) {
                    $anggota_kelas->nilai_raport = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->where('anggota_kelas_id', $anggota_kelas->id)->where('term_id', $term->id)->first();

                    if (is_null($anggota_kelas->nilai_raport)) {
                        return redirect(route('penilaiankm.index'))->with('toast_error', 'Data raport kelas ' . $anggota_kelas->kelas->nama_kelas . ' tidak ditemukan');
                    }
                }

                return view('admin.km.nilairaport.index', compact('title', 'data_mapel', 'data_kelas', 'data_pembelajaran', 'data_anggota_kelas', 'pembelajaran_id'));
            }
        }
    }
}
