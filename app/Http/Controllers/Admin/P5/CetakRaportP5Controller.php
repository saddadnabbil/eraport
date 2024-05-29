<?php

namespace App\Http\Controllers\Admin\P5;

use PDF;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\P5Element;
use App\Models\P5Project;
use App\Models\AnggotaKelas;
use App\Models\P5Subelement;
use Illuminate\Http\Request;
use App\Models\P5NilaiProject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CetakRaportP5Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Print Report P5';
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

        return view('admin.p5.raportp5.setpaper', compact('title', 'data_kelas', 'tapel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $title = 'Print Report P5';
        $kelas = Kelas::findorfail($request->kelas_id);
        $tapel = Tapel::where('status', 1)->first();
        $semester = Semester::findorfail($request->semester_id);

        if ($tapel->km_tgl_raport == null) {
            return redirect()->back()->with('toast_error', 'Tempat Print Raport Tidak Boleh Kosong');
        }

        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereNotIn('tingkatan_id', [1, 2, 3])
            ->get();

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $request->kelas_id)->get();

        $paper_size = 'A4';
        $orientation = 'potrait';

        return view('admin.p5.raportp5.index', compact('title', 'kelas', 'tapel', 'data_kelas', 'data_anggota_kelas', 'paper_size', 'orientation', 'semester'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paper_size' => 'required',
            'orientation' => 'required',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $sekolah = Sekolah::first();
        $anggota_kelas = AnggotaKelas::findorfail($id);
        $tapel = Tapel::where('status', 1)->first();
        $semester = Semester::findorfail($request->semester_id);

        $title = 'Completeness of Report';

        $tapel = Tapel::where('status', 1)->first();
        $dataNilaiProject = P5NilaiProject::where('anggota_kelas_id', $id)->get();
        $dataProject = P5Project::with('kelas', 'p5_tema')->whereIn('id', $dataNilaiProject->pluck('p5_project_id'))->get();
        $dataSubelement = P5Subelement::orderBy('p5_element_id', 'ASC')->get();

        foreach ($dataProject as $project) {
            $subelements = json_decode($project->subelement_data, true);

            $activeSubelements = array_filter($subelements, function ($subelement) {
                return $subelement['has_active'] == true;
            });


            $project->active_subelement = P5Subelement::whereIn('id', array_column($activeSubelements, 'subelement_id'))->get();
            foreach ($project->active_subelement as $subelement) {
                $subelement->element_name = $subelement->element->name;
                $subelement->dimensi_name = $subelement->element->dimensi->name;
            }
        }

        foreach ($dataNilaiProject as $nilai) {
            $dataGrade = json_decode($nilai->grade_data);
            foreach ($dataGrade as $key => $value) {
                $dataSubelement = $dataSubelement->where('id', $value->subelement_id)->first();
                $value->subelement = $dataSubelement;
            }
        }

        $kelengkapan_raport = PDF::loadview('admin.p5.raportp5.raport', compact('title', 'sekolah', 'anggota_kelas', 'semester', 'tapel', 'dataProject', 'dataSubelement', 'dataNilaiProject'))->setPaper($request->paper_size, $request->orientation);

        return $kelengkapan_raport->stream('KELENGKAPAN RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }

    public function export(Request $request, $id)
    {
    }
}
