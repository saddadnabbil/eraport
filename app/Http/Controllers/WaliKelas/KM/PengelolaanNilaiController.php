<?php

namespace App\Http\Controllers\WaliKelas\KM;

use App\Guru;
use App\Term;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Sekolah;
use App\Semester;
use App\AnggotaKelas;
use App\Pembelajaran;
use App\KmMappingMapel;
use App\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $sekolah = Sekolah::first();
        $tapel = Tapel::where('status', 1)->first();
        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->get('id');
        $data_pembelajaran_kelas = Pembelajaran::whereIn('kelas_id', $id_kelas_diampu)->where('status', 1)->get();

        $data_kelas = Kelas::where('guru_id', $guru->id)->where('tapel_id', $tapel->id)->get();

        $kelas = Kelas::findorfail($id_kelas_diampu)->first();

        $term = Term::findorfail($kelas->tingkatan->term_id);
        $semester = Semester::findorfail($kelas->tingkatan->semester_id);

        $data_id_mapel_semester_ini = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_id_mapel_kelompok_a = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'A')->get('mapel_id');
        $data_id_mapel_kelompok_b = KmMappingMapel::whereIn('mapel_id', $data_id_mapel_semester_ini)->where('kelompok', 'B')->get('mapel_id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        foreach ($data_anggota_kelas as $anggota_kelas) {
            $data_id_pembelajaran_a = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->whereIn('mapel_id', $data_id_mapel_kelompok_a)->get('id');
            $data_id_pembelajaran_b = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->whereIn('mapel_id', $data_id_mapel_kelompok_b)->get('id');

            $data_nilai_kelompok_a = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_a)->where('term_id', $term->id)->get();
            $data_nilai_kelompok_b = KmNilaiAkhirRaport::whereIn('pembelajaran_id', $data_id_pembelajaran_b)->where('term_id', $term->id)->get();

            if ($data_nilai_kelompok_a->count() == 0 && $data_nilai_kelompok_b->count() == 0) {
                return back()->with('toast_error', 'Belum ada data penilaian. Silahkan input penilaian!');
            }

            $anggota_kelas->data_nilai_kelompok_a = $data_nilai_kelompok_a;
            $anggota_kelas->data_nilai_kelompok_b = $data_nilai_kelompok_b;
        }
        return view('walikelas.km.pengelolaannilai.index', compact('title', 'kelas', 'data_kelas', 'sekolah', 'data_anggota_kelas', 'semester'));
    }
}
