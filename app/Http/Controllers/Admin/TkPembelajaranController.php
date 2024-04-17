<?php

namespace App\Http\Controllers\Admin;

use Excel;
use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\TkPembelajaran;
use App\Exports\PembelajaranExport;
use App\Http\Controllers\Controller;
use App\Models\Tingkatan;
use App\Models\TkTopic;

class TkPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tapel = Tapel::where('status', 1)->first();
        $data_topic = TkTopic::get();
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();

        if (count($data_topic) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_tingkatan) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $title = 'Data Pembelajaran TK';
            $id_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get('id');
            $data_pembelajaran = TkPembelajaran::whereIn('tingkatan_id', $id_tingkatan)->whereNotNull('guru_id')->orderBy('tingkatan_id', 'ASC')->get();
            return view('admin.tk.pembelajaran.index', compact('title', 'data_tingkatan', 'data_pembelajaran'));
        }
    }

    public function settings(Request $request)
    {
        $title = 'Setting Pembelajaran TK';
        $tapel = Tapel::where('status', 1)->first();
        $tingkatan = Tingkatan::findorfail($request->tingkatan_id);
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();

        $data_pembelajaran_tingkatan = TkPembelajaran::where('tingkatan_id', $request->tingkatan_id)->get();
        $topic_id_pembelajaran_tingkatan = TkPembelajaran::where('tingkatan_id', $request->tingkatan_id)->get('tk_topic_id');
        $data_topic = TkTopic::whereNotIn('id', $topic_id_pembelajaran_tingkatan)
            ->whereHas('element', function ($query) use ($request) {
                $query->where('tingkatan_id', $request->tingkatan_id);
            })
            ->with('element')
            ->get();
        $data_guru = Guru::orderBy('id', 'ASC')->get();
        return view('admin.tk.pembelajaran.settings', compact('title', 'tapel', 'tingkatan', 'data_tingkatan', 'data_pembelajaran_tingkatan', 'data_topic', 'data_guru'));
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
                $pembelajaran = TkPembelajaran::findorfail($request->pembelajaran_id[$count]);
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
        return redirect('admin/pembelajaran')->with('toast_success', 'Setting pembelajaran berhasil');
    }

    public function export()
    {
        $filename = 'data_pembelajaran ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new PembelajaranExport, $filename);
    }
}
