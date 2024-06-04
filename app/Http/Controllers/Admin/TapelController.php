<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class TapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Academic Year';
        $data_tapel = Tapel::orderBy('id', 'ASC')->get();
        $data_semester = Semester::orderBy('id', 'ASC')->get();
        $data_term = Term::orderBy('id', 'ASC')->get();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();

        $tapelActive = Tapel::where('status', 1)->first();
        $tapel_id = $tapelActive ? $tapelActive->id : null;
        $semester_id = $tapelActive ? $tapelActive->semester_id : null;
        $term_id = $tapelActive ? $tapelActive->term_id : null;

        return view('admin.tapel.index', compact('title', 'data_tapel', 'tapel_id', 'data_semester', 'semester_id', 'data_term', 'term_id', 'data_tingkatan'));
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
            'tahun_pelajaran' => 'required|min:9|max:9',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            // Cek apakah tapel ini sudah ada
            $tapel = Tapel::where('tahun_pelajaran', $request->tahun_pelajaran)->first();
            if ($tapel) {
                return back()->with('toast_error', 'Academic Year sudah ada');
            }

            $tapel = new Tapel([
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester_id' => 1,
                'term_id' => 1,
            ]);
            $tapel->save();

            // Siswa::where('status', 1)->update(['kelas_id' => null]);

            return back()->with('toast_success', 'Academic Year berhasil ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tahun_pelajaran' => 'required|min:9|max:9',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            // Cek apakah tapel ini sudah ada
            $tapel = Tapel::where('id', '!=', $id)->where('tahun_pelajaran', $request->tahun_pelajaran)->first();
            if ($tapel) {
                return back()->with('toast_error', 'Academic Year sudah ada');
            }

            $tapel = Tapel::findorfail($id);
            $data_tapel = [
                'tahun_pelajaran' => $request->tahun_pelajaran,
            ];
            $tapel->update($data_tapel);
            return back()->with('toast_success', 'Academic Year berhasil diedit');
        }
    }

    public function setAcademicYear(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'select_tapel_id' => 'required|exists:tapels,id',
                'select_term_playgroup_id' => 'required|exists:terms,id',
                'select_semester_primaryschool_id' => 'required|exists:semesters,id',
                'select_term_primaryschool_id' => 'required|exists:terms,id',
                'select_semester_juniorhighschool_id' => 'required|exists:semesters,id',
                'select_term_juniorhighschool_id' => 'required|exists:terms,id',
                'select_semester_seniorhighschool_id' => 'required|exists:semesters,id',
                'select_term_seniorhighschool_id' => 'required|exists:terms,id',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->messages()->first());
            }

            $sekolah = Sekolah::get();
            if (!$sekolah) {
                throw new \Exception('Data Sekolah tidak ditemukan.');
            }

            $tapel = Tapel::findOrFail($request->select_tapel_id);
            $tapelLama = Tapel::where('status', 1)->first();

            $tingkatanUpdates = [
                ['id' => 1, 'term_id' => $request->select_term_playgroup_id],
                ['id' => 2, 'term_id' => $request->select_term_playgroup_id],
                ['id' => 3, 'term_id' => $request->select_term_playgroup_id],
                ['id' => 4, 'term_id' => $request->select_term_primaryschool_id, 'semester_id' => $request->select_semester_primaryschool_id],
                ['id' => 5, 'term_id' => $request->select_term_juniorhighschool_id, 'semester_id' => $request->select_semester_juniorhighschool_id],
                ['id' => 6, 'term_id' => $request->select_term_seniorhighschool_id, 'semester_id' => $request->select_semester_seniorhighschool_id],
            ];

            foreach ($tingkatanUpdates as $tingkatanUpdate) {
                Tingkatan::where('id', $tingkatanUpdate['id'])->update($tingkatanUpdate);
            }

            $semesterCounts = [
                1 => Tingkatan::whereIn('id', [4, 5, 6])->where('semester_id', 1)->count(),
                2 => Tingkatan::whereIn('id', [4, 5, 6])->where('semester_id', 2)->count(),
            ];

            $termCounts = [
                1 => Tingkatan::whereIn('id', [1, 2, 3])->where('term_id', 1)->count(),
                2 => Tingkatan::whereIn('id', [1, 2, 3])->where('term_id', 2)->count(),
                3 => Tingkatan::whereIn('id', [4, 5, 6])->where('term_id', 1)->count(),
                4 => Tingkatan::whereIn('id', [4, 5, 6])->where('term_id', 2)->count(),
            ];

            $maxSemesterId = array_keys($semesterCounts, max($semesterCounts))[0];
            $maxTermId = array_keys($termCounts, max($termCounts))[0];

            $tapel->update([
                'semester_id' => $maxSemesterId,
                'term_id' => $maxTermId,
            ]);

            if ($tapelLama->id == $request->select_tapel_id) {
                $tapelLama->update(['status' => 1]);
            } else {
                $tapelLama->update(['status' => 0]);
            }

            $tapel->update(['status' => 1]);

            foreach ($sekolah as $s) {
                $s->update(['tapel_id' => $request->select_tapel_id]);
            }

            session(['tapel_id' => $request->select_tapel_id]);
            session(['semester_id' => $tapel->semester_id]);
            session(['term_id' => $tapel->term_id]);

            return back()->with('success', 'School Year updated successfully');
        } catch (\Exception $e) {
            return back()->with('toast_error', $e->getMessage())->withInput();
        }
    }
}
