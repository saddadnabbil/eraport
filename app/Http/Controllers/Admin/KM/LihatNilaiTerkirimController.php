<?php

namespace App\Http\Controllers\Admin\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\Pembelajaran;
use App\Models\KmNilaiAkhirRaport;

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

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');
        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();

        return view('admin.km.nilaiterkirimkm.index', compact('title', 'data_pembelajaran', 'data_kelas'));
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

            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();

            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $data_nilai_terkirim = KmNilaiAkhirRaport::where('pembelajaran_id', $request->pembelajaran_id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get();

            if (count($data_nilai_terkirim) == 0) {
                return redirect(route('km.penilaian.index'))->with('toast_error', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
            }

            return view('admin.km.nilaiterkirimkm.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'data_nilai_terkirim', 'term', 'semester'));
        }
    }
}
