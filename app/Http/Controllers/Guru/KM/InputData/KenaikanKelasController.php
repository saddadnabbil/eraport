<?php

namespace App\Http\Controllers\Guru\KM\InputData;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
use App\Models\KenaikanKelas;
use App\Http\Controllers\Controller;
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
        $tapel = Tapel::where('status', 1)->first();

        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $data_kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        } else {
            $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        }

        return view('guru.md.kenaikan.index', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $title = 'Kenaikan Kelas';
        $tapel = Tapel::where('status', 1)->first();

        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->findOrFail($request->kelas_id)->first();
        } else {
            $kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->findOrFail($request->kelas_id)->first();
        }

        $semester = Semester::findorfail($kelas->tingkatan->semester_id);

        if ($semester->id == 2) {
            $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('id', $kelas->id)->get('id');

            $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
            $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');
            $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $kelas_id_anggota_kelas)
                ->orderBy('id', 'DESC')
                ->whereHas('siswa', function ($query) {
                    $query->where('status', 1);
                })
                ->get();

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

            return view('guru.md.kenaikan.create', compact('title', 'data_anggota_kelas', 'tingkatan_akhir'));
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
            return redirect(route('guru.km.kenaikan.index'))->with('toast_success', 'Kenaikan kelas berhasil disimpan');
        }
    }
}
