<?php

namespace App\Http\Controllers\Guru\MD;

use App\Http\Controllers\Controller;
use App\Imports\MapelImport;
use App\Models\Mapel;
use App\Models\Tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Excel;
use Illuminate\Support\Facades\Response;


class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Subject Data';
        $tapel = Tapel::where('status', 1)->first();
        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        return view('guru.md.mapel.index', compact('title', 'data_mapel', 'tapel'));
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
            'tapel_id' => 'required',
            'nama_mapel' => 'required|min:3|max:255',
            'nama_mapel_indonesian' => 'required|min:3|max:255',
            'ringkasan_mapel' => 'required|min:2|max:50',
            'color' => 'nullable'
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $mapel = new Mapel([
                'tapel_id' => $request->tapel_id,
                'nama_mapel' => $request->nama_mapel,
                'nama_mapel_indonesian' => $request->nama_mapel_indonesian,
                'ringkasan_mapel' => $request->ringkasan_mapel,
                'color' => $request->color
            ]);
            $mapel->save();
            return back()->with('toast_success', 'Subject berhasil ditambahkan');
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
            'nama_mapel' => 'required|min:3|max:255',
            'nama_mapel_indonesian' => 'required|min:3|max:255',
            'ringkasan_mapel' => 'required|min:2|max:50',
            'color' => 'nullable'
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $mapel = Mapel::findorfail($id);
            $data_mapel = [
                'nama_mapel' => $request->nama_mapel,
                'nama_mapel_indonesian' => $request->nama_mapel_indonesian,
                'ringkasan_mapel' => $request->ringkasan_mapel,
                'color' => $request->color
            ];
            $mapel->update($data_mapel);
            return back()->with('toast_success', 'Subject berhasil diedit');
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
        $mapel = Mapel::findorfail($id);
        try {
            $mapel->forceDelete();
            return back()->with('toast_success', 'Subject berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_warning', 'Subject Data tidak dapat dihapus');
        }
    }

    public function format_import()
    {
        $file = public_path() . "/format_import/format_import_mapel.xls";
        $headers = array(
            'Content-Type: application/xls',
        );
        return Response::download($file, 'format_import_mapel ' . date('Y-m-d H_i_s') . '.xls', $headers);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new MapelImport, $request->file('file_import'));
            return back()->with('toast_success', 'Subject Data berhasil diimport');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Maaf, format data tidak sesuai');
        }
    }
}
