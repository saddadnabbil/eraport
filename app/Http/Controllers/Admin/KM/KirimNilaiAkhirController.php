<?php

namespace App\Http\Controllers\Admin\KM;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\KmKkmMapel;
use App\Models\NilaiAkhir;
use App\Models\AnggotaKelas;
use App\Models\NilaiSumatif;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\NilaiFormatif;
use App\Models\KmNilaiAkhirRaport;
use App\Models\RencanaNilaiSumatif;
use App\Http\Controllers\Controller;
use App\Models\RencanaNilaiFormatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KirimNilaiAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Submit Final Grade';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get();

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        } else {
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
        }

        return view('admin.km.kirimnilaiakhirkm.index', compact('title', 'data_pembelajaran', 'data_kelas'));
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
            $tapel = Tapel::where('status', 1)->first();
            $user = Auth::user();

            if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
                $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
                $pembelajaran = Pembelajaran::where('guru_id', $guru->id)->findorfail($request->pembelajaran_id);
            } else {
                $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
            }

            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $kkm = KmKkmMapel::where('mapel_id', $pembelajaran->mapel_id)->where('kelas_id', $pembelajaran->kelas_id)->first();

            if (is_null($kkm)) {
                return back()->with('toast_error', 'KKM untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . ' belum ditentukan. Silakan input KKM sebelum melakukan penilaian.');
            }

            $rencana_nilai_sumatif = RencanaNilaiSumatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get('id');
            $rencana_nilai_formatif = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->where('semester_id', $semester->id)->get('id');

            if (count($rencana_nilai_sumatif) == 0 || count($rencana_nilai_formatif) == 0) {
                return back()->with('toast_warning', 'Data Grading Plan tidak ditemukan');
            } else {
                $nilai_sumatif = NilaiSumatif::whereIn('rencana_nilai_sumatif_id', $rencana_nilai_sumatif)->groupBy('rencana_nilai_sumatif_id')->get();
                $nilai_formatif = NilaiFormatif::whereIn('rencana_nilai_formatif_id', $rencana_nilai_formatif)->groupBy('rencana_nilai_formatif_id')->get();

                // if (count($rencana_nilai_sumatif) != count($nilai_sumatif) || count($rencana_nilai_formatif) != count($nilai_formatif)) {
                //     return back()->with('toast_warning', 'Perlu pembaruan. Tidak ada data penilaian terbaru untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '.');
                // } else {
                // Data Master
                $title = 'Submit Final Grade';
                $tapel = Tapel::where('status', 1)->first();

                $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

                if (isset($guru)) {
                    $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
                } else {
                    $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
                }


                // Interval KKM
                $kkm->predikat_d =  60.00;
                $kkm->predikat_c =  70.00;
                $kkm->predikat_b =  80.00;
                $kkm->predikat_a =  100.00;

                // Data Nilai
                $ringkasan_mapel = $pembelajaran->mapel->ringkasan_mapel;

                $mapel_kata_pertama = explode('-', $ringkasan_mapel)[0];

                $agama = null;

                if (strtolower($mapel_kata_pertama) === 'agama') {
                    $mapel_singkatan = explode('-', $ringkasan_mapel);
                    if (count($mapel_singkatan) > 1) {
                        $agama_singkatan = strtolower($mapel_singkatan[1]);

                        switch ($agama_singkatan) {
                            case 'islam':
                                $agama = 1;
                                break;
                            case 'protestan':
                                $agama = 2;
                                break;
                            case 'katolik':
                                $agama = 3;
                                break;
                            case 'hindu':
                                $agama = 4;
                                break;
                            case 'budha':
                                $agama = 5;
                                break;
                            case 'khonghucu':
                                $agama = 6;
                                break;
                            case 'lainnya':
                                $agama = 7;
                                break;
                            default:
                                $agama = null;
                                break;
                        }
                    }
                }

                $data_anggota_kelas = AnggotaKelas::where('kelas_id', $pembelajaran->kelas_id)
                    ->orderBy('id', 'DESC')
                    ->whereHas('siswa', function ($query) use ($agama) {
                        $query->where('status', 1);
                        if ($agama !== null) {
                            $query->where('agama', $agama);
                        }
                    })
                    ->get();

                if (count($data_anggota_kelas) == 0) {
                    return redirect(route('km.penilaian.index'))->with('toast_error', 'Data anggota kelas tidak ditemukan');
                }

                foreach ($data_anggota_kelas as $anggota_kelas) {

                    $data_nilai_akhir = NilaiAkhir::where('anggota_kelas_id', $anggota_kelas->id)->where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->first();

                    if (!is_null($data_nilai_akhir)) {
                        $nilai_akhir_pengetahuan = $data_nilai_akhir->nilai_akhir_sumatif;
                        $nilai_akhir_keterampilan = $data_nilai_akhir->nilai_akhir_formatif;
                        $nilai_akhir_raport  = $data_nilai_akhir->nilai_akhir_revisi;
                        if ($nilai_akhir_raport == null || $nilai_akhir_raport == 0) {
                            $nilai_akhir_raport = $data_nilai_akhir->nilai_akhir_raport;
                        }
                    } else {
                        $nilai_akhir_pengetahuan = 0;
                        $nilai_akhir_keterampilan = 0;
                        $nilai_akhir_raport = 0;

                        // return redirect(route('km.penilaian.index'))->with('toast_error', 'Perlu pembaruan. Tidak ada data penilaian terbaru untuk ' . $pembelajaran->mapel->nama_mapel . ' ' . $pembelajaran->kelas->nama_kelas . '.');
                    }

                    $anggota_kelas->nilai_pengetahuan = round($nilai_akhir_pengetahuan, 0);
                    $anggota_kelas->nilai_keterampilan = round($nilai_akhir_keterampilan, 0);
                    $anggota_kelas->nilai_akhir_raport = round($nilai_akhir_raport, 0);
                }
                return view('admin.km.kirimnilaiakhirkm.create', compact('title', 'data_pembelajaran', 'pembelajaran', 'kkm', 'data_anggota_kelas', 'term', 'semester'));
                // }
            }
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
        foreach ($request->anggota_kelas_id as $index => $anggota_kelas_id) {
            $data_nilai = [
                'pembelajaran_id' => $request->pembelajaran_id,
                'term_id' => $request->term_id,
                'semester_id' => $request->semester_id,
                'kkm' => $request->kkm,
                'anggota_kelas_id' => $anggota_kelas_id,
                'nilai_sumatif' => intval($request->nilai_pengetahuan[$index]),
                'predikat_sumatif' => $request->predikat_pengetahuan[$index],
                'nilai_formatif' => intval($request->nilai_keterampilan[$index]),
                'predikat_formatif' => $request->predikat_keterampilan[$index],
                'nilai_akhir_raport' => intval($request->nilai_akhir_raport[$index]),
                'predikat_akhir_raport' => $request->predikat_akhir_raport[$index],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Cari atau buat entri baru berdasarkan pembelajaran_id, anggota_kelas_id, term_id, dan semester_id
            KmNilaiAkhirRaport::updateOrCreate(
                [
                    'pembelajaran_id' => $request->pembelajaran_id,
                    'anggota_kelas_id' => $anggota_kelas_id,
                    'term_id' => $request->term_id,
                    'semester_id' => $request->semester_id,
                ],
                $data_nilai
            );
        }

        return back()->with('toast_success', 'Final Grade raport berhasil dikirim');
    }
}
