<?php

namespace App\Http\Controllers\Admin\K13;

use App\Http\Controllers\Controller;
use App\K13MappingMapel;
use App\Mapel;
use App\Tapel;
use Illuminate\Http\Request;

class MapingMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Mapping Mata Pelajaran';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } else {
            foreach ($data_mapel as $mapel) {
                $mapping = K13MappingMapel::where('mapel_id', $mapel->id)->first();
                if (is_null($mapping)) {
                    $mapel->kelompok = null;
                    $mapel->nomor_urut = null;
                } else {
                    $mapel->kelompok = $mapping->kelompok;
                    $mapel->nomor_urut = $mapping->nomor_urut;
                }
            }
            return view('admin.k13.mapping.index', compact('title', 'data_mapel'));
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
        for ($count = 0; $count < count($request->mapel_id); $count++) {
            $mapel_mapping = K13MappingMapel::where('mapel_id', $request->mapel_id[$count])->first();
            if (is_null($mapel_mapping)) {
                $mapping = new K13MappingMapel([
                    'mapel_id' => $request->mapel_id[$count],
                    // 'kelompok' => $request->kelompok[$count],
                    'nomor_urut' => $request->nomor_urut[$count],
                ]);
                $mapping->save();
            } else {
                $update_mapping = [
                    // 'kelompok' => $request->kelompok[$count],
                    'nomor_urut' => $request->nomor_urut[$count],
                ];
                $mapel_mapping->update($update_mapping);
            }
        }
        return back()->with('toast_success', 'Mapping mata pembelajaran berhasil');
    }
}
