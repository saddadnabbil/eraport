<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Mapel;
use App\Tapel;
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

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel')->get();
        $id_mapel = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id')->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id')->get('id');

        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('admin.km.penilaian.pilihkelas', compact('title', 'data_pembelajaran', 'data_mapel', 'data_kelas'));
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
            $title = 'Tambah Penilaian';
            $tapel = Tapel::findorfail(session()->get('tapel_id'));
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            $pembelajaran_id = $request->pembelajaran_id;
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

            $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)->get();


            return view('admin.km.penilaian.create', compact('title', 'tapel', 'pembelajaran', 'pembelajaran_id', 'data_pembelajaran', 'data_anggota_kelas'));
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
