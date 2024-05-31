<?php

namespace App\Http\Controllers\Guru\MD;

use App\Exports\PembelajaranExport;
use App\Models\Guru;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pembelajaran;
use App\Models\Tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tapel = Tapel::where('status', 1)->first();
        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('tingkatan_id', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect()->back()->with('toast_warning', 'Mohon isikan Subject Data');
        } elseif (count($data_kelas) == 0) {
            return redirect()->back()->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $title = 'Learning Data';
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->orderBy('tingkatan_id', 'ASC')->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->whereNotNull('guru_id')->where('status', 1)->orderBy('kelas_id', 'ASC')->get();
            return view('guru.md.pembelajaran.index', compact('title', 'data_kelas', 'data_pembelajaran'));
        }
    }

    public function settings(Request $request)
    {
        $title = 'Setting Pembelajaran';
        $tapel = Tapel::where('status', 1)->first();
        $kelas = Kelas::findorfail($request->kelas_id);
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('tingkatan_id', 'ASC')->get();

        $data_pembelajaran_kelas = Pembelajaran::where('kelas_id', $request->kelas_id)->get();
        $mapel_id_pembelajaran_kelas = Pembelajaran::where('kelas_id', $request->kelas_id)->get('mapel_id');
        $data_mapel = Mapel::whereNotIn('id', $mapel_id_pembelajaran_kelas)->get();
        $data_guru = Guru::orderBy('id', 'ASC')->get();

        return view('guru.md.pembelajaran.settings', compact('title', 'tapel', 'kelas', 'data_kelas', 'data_pembelajaran_kelas', 'data_mapel', 'data_guru'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (!is_null($request->pembelajaran_id)) {
            for ($count = 0; $count < count($request->pembelajaran_id); $count++) {
                $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id[$count]);
                $update_data = array(
                    'guru_id'  => $request->update_guru_id[$count],
                    'status'  => $request->update_status[$count],
                );
                $pembelajaran->update($update_data);
            }
            if (!is_null($request->mapel_id)) {
                for ($count = 0; $count < count($request->mapel_id); $count++) {
                    $data_baru = array(
                        'kelas_id'  => $request->kelas_id[$count],
                        'mapel_id'  => $request->mapel_id[$count],
                        'guru_id'  => $request->guru_id[$count],
                        'status'  => $request->status[$count],
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now(),
                    );
                    $store_data_baru[] = $data_baru;
                }
                Pembelajaran::insert($store_data_baru);
            }
        } else {
            for ($count = 0; $count < count($request->mapel_id); $count++) {
                $data_baru = array(
                    'kelas_id'  => $request->kelas_id[$count],
                    'mapel_id'  => $request->mapel_id[$count],
                    'guru_id'  => $request->guru_id[$count],
                    'status'  => $request->status[$count],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $store_data_baru[] = $data_baru;
            }
            Pembelajaran::insert($store_data_baru);
        }
        return redirect(route('guru.pembelajaran.index'))->with('toast_success', 'Setting pembelajaran berhasil');
    }

    public function export()
    {
        $filename = 'data_pembelajaran ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new PembelajaranExport, $filename);
    }
}
