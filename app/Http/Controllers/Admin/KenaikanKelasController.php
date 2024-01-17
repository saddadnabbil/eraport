<?php

namespace App\Http\Controllers\Admin;

use App\AnggotaKelas;
use App\Guru;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\KenaikanKelas;
use App\Semester;
use App\Tapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KenaikanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Kehadiran Siswa';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->get();

        return view('admin.kenaikan.index', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $title = 'Kenaikan Kelas';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $kelas = Kelas::findorfail($request->kelas_id);
        $semester = Semester::findorfail($kelas->tingkatan->semester_id);


        if ($semester->id == 2) {
            $guru = Guru::where('user_id', Auth::user()->id)->first();
            $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('id', $request->kelas_id)->get('id');

            $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
            $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');
            $data_anggota_kelas = AnggotaKelas::whereIn('id', $id_anggota_kelas)->whereIn('kelas_id', $kelas_id_anggota_kelas)->get();

            foreach ($data_anggota_kelas as $anggota) {
                $kenaikan_kelas = KenaikanKelas::where('anggota_kelas_id', $anggota->id)->first();
                if (is_null($kenaikan_kelas)) {
                    $anggota->keputusan = null;
                    $anggota->kelas_tujuan = null;
                } else {
                    $anggota->keputusan = $kenaikan_kelas->keputusan;
                    $anggota->kelas_tujuan = $kenaikan_kelas->kelas_tujuan;
                }
            }

            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');

            return view('admin.kenaikan.create', compact('title', 'data_anggota_kelas', 'tingkatan_akhir'));
        } else {
            return back()->with('toast_warning', 'Menu kenaikan kelas hanya aktif pada semester genap');
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
        if (is_null($request->anggota_kelas_id)) {
            return back()->with('toast_error', 'Data siswa tidak ditemukan');
        } else {
            for ($cound_siswa = 0; $cound_siswa < count($request->anggota_kelas_id); $cound_siswa++) {
                if (is_null($request->kelas_tujuan)) {
                    $data_kenaikan = array(
                        'anggota_kelas_id'  => $request->anggota_kelas_id[$cound_siswa],
                        'keputusan'  => $request->keputusan[$cound_siswa],
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now(),
                    );
                    $cek_data_kenaikan = KenaikanKelas::where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->first();
                    if (is_null($cek_data_kenaikan)) {
                        KenaikanKelas::insert($data_kenaikan);
                    } else {
                        $cek_data_kenaikan->update($data_kenaikan);
                    }
                } else {
                    $data_kenaikan = array(
                        'anggota_kelas_id'  => $request->anggota_kelas_id[$cound_siswa],
                        'keputusan'  => $request->keputusan[$cound_siswa],
                        'kelas_tujuan'  => strtoupper($request->kelas_tujuan[$cound_siswa]),
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now(),
                    );
                    $cek_data_kenaikan = KenaikanKelas::where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->first();
                    if (is_null($cek_data_kenaikan)) {
                        KenaikanKelas::insert($data_kenaikan);
                    } else {
                        $cek_data_kenaikan->update($data_kenaikan);
                    }
                }
            }
            return redirect(route('kenaikanadmin.index'))->with('toast_success', 'Kenaikan kelas berhasil disimpan');
        }
    }
}
