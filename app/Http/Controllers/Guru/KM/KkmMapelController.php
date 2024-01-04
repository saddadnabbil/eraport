<?php

namespace App\Http\Controllers\Guru\KM;

use Excel;
use App\Guru;
use App\Mapel;
use App\Tapel;
use App\KmKkmMapel;
use App\Pembelajaran;
use Illuminate\Http\Request;
use App\Imports\KKMK13Import;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\FormatImportKKMK13Export;
use Illuminate\Support\Facades\Validator;

class KkmMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'KKM Mata Pelajaran';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $guru = Guru::where('user_id', Auth::user()->id)->first();

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        $id_mapel = Mapel::where('tapel_id', $tapel->id)->get('id');

        $cek_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('mapel_id', $id_mapel)->whereNotNull('guru_id')->where('status', 1)->get();
        if (count($cek_pembelajaran) == 0) {
            return redirect('admin/pembelajaran')->with('toast_warning', 'data pembelajaran untuk mapel ini belum tersedia');
        } else {
            $data_kkm = KmKkmMapel::whereIn('mapel_id', $id_mapel)->get();
            return view('guru.km.kkm.index', compact('title', 'data_mapel', 'data_kkm'));
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
        $validator = Validator::make($request->all(), [
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'kkm' => 'required|numeric|between:0,100',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $cek_kkm = KmKkmMapel::where('mapel_id', $request->mapel_id)->where('kelas_id', $request->kelas_id)->first();
            if (is_null($cek_kkm)) {
                $kkm = new KmKkmMapel([
                    'mapel_id' => $request->mapel_id,
                    'kelas_id' => $request->kelas_id,
                    'kkm' => ltrim($request->kkm),
                ]);
                $kkm->save();
                return back()->with('toast_success', 'KKM berhasil ditambahkan');
            } else {
                return back()->with('toast_error', 'Data KKM sudah ada');
            }
        }
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
        $validator = Validator::make($request->all(), [
            'kkm' => 'required|numeric|between:0,100',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $kkm = KmKkmMapel::findorfail($id);
            $data = [
                'kkm' => ltrim($request->kkm),
            ];
            $kkm->update($data);
            return back()->with('toast_success', 'KKM berhasil diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kkm = KmKkmMapel::findorfail($id);
        try {
            $kkm->delete();
            return back()->with('toast_success', 'KKM berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Data tidak dapat dihapus');
        }
    }

    public function format_import()
    {
        $filename = 'format_import_kkm_k13 ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new FormatImportKKMK13Export, $filename);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new KKMK13Import, $request->file('file_import'));
            return back()->with('toast_success', 'Data KKM berhasil diimport');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Maaf, format data tidak sesuai');
        }
    }
}
