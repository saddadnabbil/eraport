<?php

namespace App\Http\Controllers\Admin\KM;

use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\KmMappingMapel;
use App\Models\KmNilaiAkhirRaport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengelolaanNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Hasil Pengelolaan Nilai';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        return view('admin.km.pengelolaannilai.pilihkelas', compact('title', 'data_kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = 'Hasil Pengelolaan Nilai';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();

        $kelas = Kelas::findorfail($request->kelas_id);
        $sekolah = $kelas->tingkatan->sekolah;

        $term = Term::findorfail($kelas->tingkatan->term_id);
        $semester = Semester::findorfail($kelas->tingkatan->semester_id);

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas->id)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        foreach ($data_anggota_kelas as $anggota_kelas) {
            $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get('id');
            $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get('id');

            $data_nilai_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->where('semester_id', $semester->id)->get();
            $data_nilai_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->where('semester_id', $semester->id)->get();

            if ($data_nilai_kelompok_a->count() == 0 && $data_nilai_kelompok_b->count() == 0) {
                return redirect(route('km.penilaian.index'))->with('toast_error', 'Belum ada data penilaian. Silahkan input penilaian!');
            }

            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;
        }
        return view('admin.km.pengelolaannilai.index', compact('title', 'kelas', 'data_kelas', 'sekolah', 'data_anggota_kelas', 'semester'));
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
