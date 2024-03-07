<?php

namespace App\Http\Controllers\Admin\Km;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenilaianTkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Penilaian Raport TK';
        $tapel = Tapel::where('status', 1)->first();

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->where('tingkatan_id', [1, 2])->orderBy('tingkatan_id', 'ASC')->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2])->get('id');

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        }

        return view('admin.km.penilaiantk.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'tapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
