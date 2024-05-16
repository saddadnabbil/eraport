<?php

namespace App\Http\Controllers\Admin\KM;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\KmDeskripsiNilaiSiswa;
use Illuminate\Support\Facades\Validator;

class ProsesDeskripsiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Deskripsi Nilai Siswa';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

        if (isset($guru)) {
            $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        } else {
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
        }

        return view('admin.km.prosesdeskripsi.index', compact('title', 'data_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembelajaran_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Input Deskripsi Nilai Siswa';
            $tapel = Tapel::where('status', 1)->first();
            $user = Auth::user();
            if ($user->hasAnyRole(['Teacher', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
                $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            }

            $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

            if ($user->hasAnyRole(['Teacher', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
                $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
                $pembelajaran = Pembelajaran::where('guru_id', $guru->id)->findorfail($request->pembelajaran_id);
                $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
            } else {
                $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
                $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
            }

            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Term::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $data_nilai_siswa = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get();

            if ($data_nilai_siswa->count() == 0) {
                return redirect(route('km.penilaian.index'))->with('toast_error', 'Belum ada data penilaian untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '. Silahkan input penilaian!');
            } else {
                foreach ($data_nilai_siswa as $nilai_siswa) {
                    $nilai_siswa->deskripsi_nilai_siswa = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $pembelajaran->id)->where('km_nilai_akhir_raport_id', $nilai_siswa->id)->first();
                }
            }
            return view('admin.km.prosesdeskripsi.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'data_nilai_siswa', 'term', 'semester'));
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
        if (is_null($request->nilai_akhir_raport_id)) {
            return back()->with('toast_error', 'Tidak ditemukan data deskripsi nilai siswa');
        } else {
            for ($cound_siswa = 0; $cound_siswa < count($request->nilai_akhir_raport_id); $cound_siswa++) {
                $data_deskripsi = array(
                    'pembelajaran_id' => $request->pembelajaran_id,
                    'km_nilai_akhir_raport_id'  => $request->nilai_akhir_raport_id[$cound_siswa],
                    'term_id'  => $request->term_id,
                    'deskripsi_raport'  => $request->deskripsi_raport[$cound_siswa],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );

                $cek_data = KmDeskripsiNilaiSiswa::where('pembelajaran_id', $request->pembelajaran_id)->where('km_nilai_akhir_raport_id', $request->nilai_akhir_raport_id[$cound_siswa])->first();

                if (is_null($cek_data)) {
                    KmDeskripsiNilaiSiswa::insert($data_deskripsi);
                } else {
                    $cek_data->update($data_deskripsi);
                }
            }
            return redirect(route('km.prosesdeskripsi.index'))->with('toast_success', 'Deskripsi nilai siswa berhasil disimpan');
        }
    }
}
