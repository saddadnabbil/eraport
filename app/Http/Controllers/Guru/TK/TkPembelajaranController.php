<?php

namespace App\Http\Controllers\Guru\TK;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\TkTopic;
use App\Models\Tingkatan;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\TkPembelajaran;
use App\Exports\PembelajaranExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TkPembelajaranExport;

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
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->get();

        if (count($data_topic) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $title = 'Data Pembelajaran TK';
            $id_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get('id');
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->get('id');
            $data_pembelajaran = TkPembelajaran::whereIn('kelas_id', $id_kelas)->whereNotNull('guru_id')->get();
            return view('guru.tk.pembelajaran.index', compact('title', 'data_kelas', 'data_pembelajaran'));
        }
    }

    public function settings(Request $request)
    {
        $title = 'Setting Pembelajaran TK';
        $tapel = Tapel::where('status', 1)->first();
        $kelas = Kelas::findorfail($request->kelas_id);
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->get();

        $data_pembelajaran_kelas = TkPembelajaran::where('kelas_id', $request->kelas_id)->get();
        $topic_id_pembelajaran_kelas = TkPembelajaran::where('kelas_id', $request->kelas_id)->get('tk_topic_id');
        $data_topic = TkTopic::whereNotIn('id', $topic_id_pembelajaran_kelas)
            ->whereHas('element', function ($query) use ($kelas) {
                $query->where('tingkatan_id', $kelas->tingkatan->id);
            })
            ->with('element')
            ->get();
        $data_guru = Guru::orderBy('id', 'ASC')
            ->whereHas('karyawan', function ($query) {
                $query->whereHas('unitKaryawan', function ($subquery) {
                    $subquery->where('unit_kode', 'G01');
                });
            })
            ->get();

        return view('guru.tk.pembelajaran.settings', compact('title', 'tapel', 'kelas', 'data_kelas', 'data_pembelajaran_kelas', 'data_topic', 'data_guru'));
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
                );
                $pembelajaran->update($update_data);
            }
            if (!is_null($request->tk_topic_id)) {
                for ($count = 0; $count < count($request->tk_topic_id); $count++) {
                    $data_baru = array(
                        'tingkatan_id'  => $request->tingkatan_id[$count],
                        'kelas_id'  => $request->kelas_id[$count],
                        'tk_topic_id'  => $request->tk_topic_id[$count],
                        'guru_id'  => $request->guru_id[$count],
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now(),
                    );
                    $store_data_baru[] = $data_baru;
                }
                TkPembelajaran::insert($store_data_baru);
            }
        } else {
            for ($count = 0; $count < count($request->tk_topic_id); $count++) {
                $data_baru = array(
                    'tingkatan_id'  => $request->tingkatan_id[$count],
                    'kelas_id'  => $request->kelas_id[$count],
                    'tk_topic_id'  => $request->tk_topic_id[$count],
                    'guru_id'  => $request->guru_id[$count],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $store_data_baru[] = $data_baru;
            }
            TkPembelajaran::insert($store_data_baru);
        }
        return redirect(route('tk.pembelajaran.index'))->with('toast_success', 'Setting pembelajaran berhasil');
    }

    public function export()
    {
        $filename = 'data_pembelajaran ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new TkPembelajaranExport, $filename);
    }
}
