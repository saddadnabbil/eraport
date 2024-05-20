<?php

namespace App\Http\Controllers\Guru\TK;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
use App\Models\KehadiranSiswa;
use App\Http\Controllers\Controller;
use App\Models\TkAttendance;

class TkKehadiranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2, 3])->get();

        return view('guru.tk.kehadiran-tk.index', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $title = 'Input Kehadiran Siswa';
        $tapel = Tapel::where('status', 1)->first();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->where('id', $request->kelas_id)
            ->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas_id_anggota_kelas)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        foreach ($data_anggota_kelas as $anggota) {
            $kehadiran = TkAttendance::where('anggota_kelas_id', $anggota->id)->first();
            if (is_null($kehadiran)) {
                $anggota->no_school_days = 0;
                $anggota->days_attended = 0;
                $anggota->days_absent = 0;
            } else {
                $anggota->no_school_days = $kehadiran->no_school_days;
                $anggota->days_attended = $kehadiran->days_attended;
                $anggota->days_absent = $kehadiran->days_absent;
            }
        }

        return view('guru.tk.kehadiran-tk.create', compact('title', 'data_anggota_kelas'));
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
                    'no_school_days'  => $request->no_school_days[$cound_siswa],
                    'days_attended'  => $request->days_attended[$cound_siswa],
                    'days_absent'  => $request->days_absent[$cound_siswa],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $cek_data = TkAttendance::where('anggota_kelas_id', $request->anggota_kelas_id[$cound_siswa])->first();
                if (is_null($cek_data)) {
                    TkAttendance::insert($data);
                } else {
                    $cek_data->update($data);
                }
            }
            return back()->with('toast_success', 'Kehadiran siswa berhasil disimpan');
        }
    }
}
