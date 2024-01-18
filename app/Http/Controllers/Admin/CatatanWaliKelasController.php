<?php

namespace App\Http\Controllers\Admin;

use App\AnggotaKelas;
use App\CatatanWaliKelas;
use App\Guru;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanWaliKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Catatan Wali Kelas';
        $tapel = Tapel::where('status', 1)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        return view('admin.catatan.index', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $title = 'Input Catatan Wali Kelas';
        $tapel = Tapel::where('status', 1)->first();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('id', $request->kelas_id)->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::whereIn('id', $id_anggota_kelas)->whereIn('kelas_id', $kelas_id_anggota_kelas)->get();

        foreach ($data_anggota_kelas as $anggota) {
            $cek_data = CatatanWaliKelas::where('anggota_kelas_id', $anggota->id)->first();
            if (is_null($cek_data)) {
                $anggota->catatan_wali_kelas = null;
            } else {
                $anggota->catatan_wali_kelas = $cek_data->catatan;
            }
        }
        return view('admin.catatan.create', compact('title', 'data_anggota_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->anggota_kelas_id)) {
            return back()->with('toast_error', 'Data siswa tidak ditemukan');
        } else {
            for ($cound_siswa = 0; $cound_siswa < count($request->anggota_kelas_id); $cound_siswa++) {
                $data = array(
                    'anggota_kelas_id'  => $request->anggota_kelas_id[$cound_siswa],
                    'catatan'  => $request->catatan_wali_kelas[$cound_siswa],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $cek_data = CatatanWaliKelas::where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->first();
                if (is_null($cek_data)) {
                    CatatanWaliKelas::insert($data);
                } else {
                    $cek_data->update($data);
                }
            }
            return redirect(route('catatanadmin.index'))->with('toast_success', 'Catatan wali kelas berhasil disimpan');
        }
    }
}
