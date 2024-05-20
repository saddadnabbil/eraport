<?php

namespace App\Http\Controllers\Admin\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\KmMappingMapel;
use App\Models\Ekstrakulikuler;
use App\Models\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use App\Models\NilaiEkstrakulikuler;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AnggotaEkstrakulikuler;
use App\Exports\AdminKMLegerNilaiExport;

class LegerNilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Leger Nilai Siswa';
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
        return view('admin.km.leger.pilihkelas', compact('title', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Leger Nilai Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $data_kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
            $kelas = Kelas::where('guru_id', $guru->id)->findorfail($request->kelas_id);
        } else {
            $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
            $kelas = Kelas::findorfail($request->kelas_id);
        }
        $term = Term::findorfail($kelas->tingkatan->term_id);

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $data_id_pembelajaran_all = Pembelajaran::where('kelas_id', $kelas->id)->get('id');
        $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get('id');
        $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $kelas->id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get('id');

        $data_mapel_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->groupBy('pembelajaran_id')->get();
        $data_mapel_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->groupBy('pembelajaran_id')->get();

        $data_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();
        $count_ekstrakulikuler = count($data_ekstrakulikuler);

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas->id)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        foreach ($data_anggota_kelas as $anggota_kelas) {

            $data_nilai_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();
            $data_nilai_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->get();

            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;

            $rt_sumatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_sumatif');
            $rt_formatif = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_all)->where('term_id', $term->id)->where('anggota_kelas_id', $anggota_kelas->id)->avg('nilai_formatif');

            $anggota_kelas->rata_rata_sumatif = round($rt_sumatif, 0);
            $anggota_kelas->rata_rata_formatif = round($rt_formatif, 0);

            $anggota_kelas->data_nilai_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get();

            foreach ($anggota_kelas->data_nilai_ekstrakulikuler as $data_nilai_ekstrakulikuler) {
                $cek_anggota_ekstra = AnggotaEkstrakulikuler::where('ekstrakulikuler_id', $data_nilai_ekstrakulikuler->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
                if (is_null($cek_anggota_ekstra)) {
                    $data_nilai_ekstrakulikuler->nilai = '-';
                } else {
                    $cek_nilai_ekstra = NilaiEkstrakulikuler::where('ekstrakulikuler_id', $data_nilai_ekstrakulikuler->id)->where('anggota_ekstrakulikuler_id', $cek_anggota_ekstra->id)->first();
                    if (is_null($cek_nilai_ekstra)) {
                        $data_nilai_ekstrakulikuler->nilai = '-';
                    } else {
                        $data_nilai_ekstrakulikuler->nilai = $cek_nilai_ekstra->nilai;
                    }
                }
            }
        }
        return view('admin.km.leger.index', compact('title', 'kelas', 'data_kelas', 'data_mapel_kelompok_a', 'data_mapel_kelompok_b', 'data_ekstrakulikuler', 'count_ekstrakulikuler', 'data_anggota_kelas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::findorfail($id);
        $tapel = $kelas->tapel;
        $semester = $tapel->semester_id;
        $tahun_pelajaran = $tapel->tahun_pelajaran;

        $filename = 'Daftar Legger - ' . $kelas->nama_kelas . ' - Semester ' . $semester . ' (' . $tahun_pelajaran . ').xls';

        return Excel::download(new AdminKMLegerNilaiExport($id), $filename);
    }
}
