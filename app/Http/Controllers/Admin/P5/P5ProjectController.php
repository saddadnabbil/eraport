<?php

namespace App\Http\Controllers\Admin\P5;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\P5Tema;
use App\Models\P5Project;
use App\Models\P5Subelement;
use Illuminate\Http\Request;
use App\Models\P5NilaiProject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class P5ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'P5 Project';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $dataGuru = Guru::where('id', $guru->id)->orderBy('id', 'ASC')->get();
            $dataProject = P5Project::where('guru_id', $guru->id)->where('semester_id', $tapel->semester_id)->orderBy('kelas_id', 'ASC')->get();
        } else {
            $dataGuru = Guru::orderBy('id', 'ASC')->get();
            $dataProject = P5Project::where('semester_id', $tapel->semester_id)->orderBy('kelas_id', 'ASC')->get();
        }

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();
        if (count($dataKelas) == 0) {
            return redirect()->route('admin.kelas.index')->with('toast_warning', 'Mohon isikan data kelas');
        }
        $dataProject->each(function ($project) {
            $subelement_data_array = json_decode($project->subelement_data, true);

            $subelement_active_count = collect($subelement_data_array)->filter(function ($subelement) {
                return isset($subelement['has_active']) && $subelement['has_active'];
            })->count();

            $project->subelement_active_count = $subelement_active_count;
        });

        $dataTema = P5Tema::orderBy('id', 'ASC')->get();


        return view('admin.p5.project.index', compact('title', 'tapel', 'dataProject', 'dataTema', 'dataGuru', 'dataKelas'));
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
            'p5_tema_id' => 'required|exists:p5_temas,id',
            'guru_id' => 'required|exists:guru,id',
            'semester_id' => 'required|exists:semesters,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            $errorMessages = collect($validator->messages()->all())->implode('<br>');
            return back()->withInput()->with('toast_error', $errorMessages);
        }

        $p5Project = P5Project::create($validator->validated());

        return redirect()->back()->with('success', 'Project berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $dataGuru = Guru::where('id', $guru->id)->orderBy('id', 'ASC')->get();
            $project = P5Project::where('guru_id', $guru->id)->findOrFail($id);
        } else {
            $dataGuru = Guru::orderBy('id', 'ASC')->get();
            $project = P5Project::findOrFail($id);
        }

        $title = 'Edit P5 Project - ' . $project->kelas->nama_kelas . ' - ' . $project->p5_tema->name;

        $dataSubelement = P5Subelement::orderBy('p5_element_id', 'ASC')->get();

        $subelement_data = json_decode($project->subelement_data, true) ?? [];

        $subelement_active_count = 0;
        $dataSubelement->each(function ($subelement) use ($subelement_data, &$subelement_active_count) {
            $data = collect($subelement_data)->firstWhere('subelement_id', $subelement->id);
            if ($data) {
                $subelement->has_active = $data['has_active'];
                if ($data['has_active']) {
                    $subelement_active_count++;
                }
            } else {
                $subelement->has_active = false;
            }
        });

        $dataSubelement = $dataSubelement->sortByDesc('has_active')->values();

        $project->subelement_active_count = $subelement_active_count;

        return view('admin.p5.project.edit', compact('title', 'project', 'dataGuru', 'dataSubelement'));
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
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|exists:guru,id',
            'name' => 'required',
            'description' => 'required',
            'subelement_id' => 'array',
            'subelement_id.*' => 'exists:p5_subelements,id',
        ]);

        $validator->setAttributeNames([
            'name' => 'Judul Project',
            'guru_id' => 'Pembina Project'
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $project = P5Project::where('guru_id', $guru->id)->findOrFail($id);
        } else {
            $project = P5Project::findOrFail($id);
        }

        $project->guru_id = $request->guru_id;
        $project->name = $request->name;
        $project->description = $request->description;

        $subelement_data = [];
        foreach ($request->subelement_id as $index => $subelement_id) {
            $has_active = isset($request->has_active[$index]);
            $subelement_data[] = [
                'subelement_id' => $subelement_id,
                'has_active' => $has_active,
            ];
        }

        $project->subelement_data = json_encode($subelement_data);

        $project->save();

        return redirect()->back()->with('success', 'Project berhasil diperbarui');
    }


    public function show($id)
    {
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $dataGuru = Guru::where('id', $guru->id)->orderBy('id', 'ASC')->get();
            $dataProject = P5Project::where('guru_id', $guru->id)->where('semester_id', $tapel->semester_id)->orderBy('kelas_id', 'ASC')->get();
            $project = P5Project::where('guru_id', $guru->id)->with('kelas', 'p5_tema')->findOrFail($id);
        } else {
            $dataGuru = Guru::orderBy('id', 'ASC')->get();
            $dataProject = P5Project::where('semester_id', $tapel->semester_id)->orderBy('kelas_id', 'ASC')->get();
            $project = P5Project::with('kelas', 'p5_tema')->findOrFail($id);
        }

        $title = 'Nilai P5 Project - ' . $project->kelas->nama_kelas . ' - ' . $project->p5_tema->name;

        $dataSiswa = Siswa::where('kelas_id', $project->kelas_id)->orderBy('id', 'ASC')->get();
        $dataSubelement = P5Subelement::orderBy('p5_element_id', 'ASC')->get();

        // Load nilai projects for the project and eager load related models
        $project->load('nilai_projects.anggota_kelas');

        $subelement_data = json_decode($project->subelement_data, true) ?? [];
        $subelements = $dataSubelement->map(function ($subelement) use ($subelement_data) {
            $subelement_data_item = collect($subelement_data)->firstWhere('subelement_id', $subelement->id);
            $subelement->has_active = $subelement_data_item ? $subelement_data_item['has_active'] : false;
            return $subelement;
        });

        $gradeData = [];
        $catatanProses = [];
        foreach ($project->nilai_projects as $nilaiProject) {
            $grade = json_decode($nilaiProject->grade_data, true);
            $gradeData[$nilaiProject->anggota_kelas_id] = $grade;
            $catatanProses[$nilaiProject->anggota_kelas_id] = $nilaiProject->catatan_proses;
        }

        $dataSubelement = $subelements->sortBy(function ($subelement) {
            return $subelement->has_active ? 0 : 1;
        })->values();

        return view('admin.p5.project.show', compact('title', 'tapel', 'project', 'dataGuru', 'dataSiswa', 'dataSubelement', 'gradeData', 'catatanProses'));
    }

    public function nilai(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'subelement_id' => 'required|array',
            'subelement_id.*' => 'exists:p5_subelements,id',
            'anggota_kelas_id' => 'required|array',
            'anggota_kelas_id.*' => 'exists:anggota_kelas,id',
            'grade' => 'required|array',
            'catatan' => 'array',
            'catatan.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        foreach ($request->anggota_kelas_id as $anggotaKelasId) {
            $subelements = $request->subelement_id[$anggotaKelasId] ?? [];
            $grades = $request->grade[$anggotaKelasId] ?? [];
            $catatan = $request->catatan[$anggotaKelasId] ?? '';

            $grade_data = [];

            foreach ($subelements as $subelementId) {
                $grade = $grades[$subelementId] ?? null;

                if ($grade !== null) {
                    $grade_data[] = [
                        'subelement_id' => $subelementId,
                        'grade' => $grade,
                    ];
                }
            }

            // Simpan sebagai string JSON
            P5NilaiProject::updateOrCreate(
                [
                    'anggota_kelas_id' => $anggotaKelasId,
                    'p5_project_id' => $id,
                ],
                [
                    'grade_data' => json_encode($grade_data),
                    'catatan_proses' => $catatan,
                ]
            );
        }


        // Redirect with success message
        return redirect()->back()->with('success', 'Nilai project berhasil disimpan.');
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
