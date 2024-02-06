<?php

namespace App\Http\Controllers\Guru\KM;

use App\Guru;
use App\Term;
use App\Kelas;
use App\Tapel;
use App\Semester;
use App\Pembelajaran;
use App\KmNilaiAkhirRaport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LihatNilaiTerkirimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Lihat Nilai Akhir Terkirim';
        $tapel = Tapel::where('status', 1)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('guru.km.nilaiterkirimkm.index', compact('title', 'data_pembelajaran', 'data_kelas'));
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
            $title = 'Lihat Nilai Akhir Terkirim';
            $tapel = Tapel::where('status', 1)->first();

            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $data_nilai_terkirim = KmNilaiAkhirRaport::where('pembelajaran_id', $request->pembelajaran_id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get();

            if (count($data_nilai_terkirim) == 0) {
                return redirect(route('guru.penilaiankm.index'))->with('toast_error', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
            }

            return view('guru.km.nilaiterkirimkm.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'data_nilai_terkirim', 'term', 'semester'));
        }
    }
}
