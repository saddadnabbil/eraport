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
        $title = 'Data Tahun Pelajaran';
        $data_tapel = Tapel::orderBy('id', 'ASC')->get();
        $data_semester = Semester::orderBy('id', 'ASC')->get();
        $data_term = Term::orderBy('id', 'ASC')->get();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();

        $sekolah = Sekolah::first();
        $tapel_id = $sekolah ? $sekolah->tapel_id : null;
        $semester_id = $sekolah ? $sekolah->semester_id : null;
        $term_id = $sekolah ? $sekolah->term_id : null;

        return view('admin.tapel.index', compact('title', 'data_tapel', 'tapel_id', 'data_semester', 'semester_id', 'data_term', 'term_id', 'sekolah', 'data_tingkatan'));
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
                return back()->with('toast_error', 'Tahun Pelajaran sudah ada');
            }

            $tapel = new Tapel([
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester_id' => 1,
                'term_id' => 1,
            ]);
            $tapel->save();

            // Siswa::where('status', 1)->update(['kelas_id' => null]);

            return back()->with('toast_success', 'Tahun Pelajaran berhasil ditambahkan');
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
                return back()->with('toast_error', 'Tahun Pelajaran sudah ada');
            }

            $tapel = Tapel::findorfail($id);
            $data_tapel = [
                'tahun_pelajaran' => $request->tahun_pelajaran,
            ];
            $tapel->update($data_tapel);
            return back()->with('toast_success', 'Tahun Pelajaran berhasil diedit');
        }
    }

    // public function destroy(AcademicYear $academicYear): RedirectResponse
    // {
    //     $this->academicYear->deleteAcademicYear($academicYear);

    //     return back()->with('success', 'Academic year deleted successfully');
    // }

    // public function destroy($id)
    // {
    //     $tapel = Tapel::findorfail($id);
    //     if ($tapel->status == 1) {
    //         return back()->with('toast_error', 'Tahun Pelajaran masih aktif');
    //     }
    //     $tapel->forceDelete();
    //     return back()->with('toast_success', 'Tahun Pelajaran berhasil dihapus');
    // }

    public function setAcademicYear(Request $request): RedirectResponse
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'select_tapel_id' => 'required|exists:tapels,id',

                'select_semester_playgroup_id' => 'required|exists:semesters,id',
                'select_term_playgroup_id' => 'required|exists:terms,id',

                'select_semester_kindergarten_id' => 'required|exists:semesters,id',
                'select_term_kindergarten_id' => 'required|exists:terms,id',

                'select_semester_primaryschool_id' => 'required|exists:semesters,id',
                'select_term_primaryschool_id' => 'required|exists:terms,id',

                'select_semester_juniorhighschool_id' => 'required|exists:semesters,id',
                'select_term_juniorhighschool_id' => 'required|exists:terms,id',

                'select_semester_seniorhighschool_id' => 'required|exists:semesters,id',
                'select_term_seniorhighschool_id' => 'required|exists:terms,id',
            ]);

            $sekolah = Sekolah::first();
            $tapel = Tapel::where('id', $request->select_tapel_id)->first();
            $tapelLama = Tapel::where('status', 1)->first();

            $pg = Tingkatan::where('id', '1')->first();
            $kg = Tingkatan::where('id', '2')->first();
            $ps = Tingkatan::where('id', '3')->first();
            $jhs = Tingkatan::where('id', '4')->first();
            $shs = Tingkatan::where('id', '5')->first();
            // dd($pg, $kg);

            if (!$sekolah) {
                throw new \Exception('Data Sekolah tidak ditemukan.');
            }

            if ($pg) {
                // PG dan KG
                $data_tingkatan_pg_kg = [
                    'term_id' => $request->select_term_playgroup_id,
                ];
                $pg->update($data_tingkatan_pg_kg);
                $kg->update($data_tingkatan_pg_kg);
            }

            if ($ps) {
                // PS
                $data_tingkatan_ps = [
                    'term_id' => $request->select_term_primaryschool_id,
                    'semester_id' => $request->select_semester_primaryschool_id,
                ];
                $ps->update($data_tingkatan_ps);
            }

            if ($jhs) {
                // JHS
                $data_tingkatan_jhs = [
                    'term_id' => $request->select_term_juniorhighschool_id,
                    'semester_id' => $request->select_semester_juniorhighschool_id,
                ];
                $jhs->update($data_tingkatan_jhs);
            }

            if ($shs) {
                // SHS
                $data_tingkatan_shs = [
                    'term_id' => $request->select_term_seniorhighschool_id,
                    'semester_id' => $request->select_semester_seniorhighschool_id,
                ];
                $shs->update($data_tingkatan_shs);
            }

            $data_term_1 = Tingkatan::whereHas('term', function ($query) {
                $query->where('term_id', 1);
            })->pluck('id');

            $data_term_2 = Tingkatan::whereHas('term', function ($query) {
                $query->where('term_id', 2);
            })->pluck('id');

            $data_term_semester_1 = Tingkatan::whereHas('term', function ($query) {
                $query->where('semester_id', 1);
            })->pluck('id');

            $data_term_semester_2 = Tingkatan::whereHas('term', function ($query) {
                $query->where('semester_id', 2);
            })->pluck('id');

            if ($data_term_1->count() === count($data_term_1) && $data_term_1->count() >= 3) {
                $tapel->update([
                    'term_id' => 1,
                ]);
            } elseif ($data_term_2->count() === count($data_term_2) && $data_term_2->count() >= 3) {
                $tapel->update([
                    'term_id' => 2,
                ]);
            }

            if ($data_term_semester_1->count() === count($data_term_semester_1)  && $data_term_semester_1->count() >= 3) {
                $tapel->update([
                    'semester_id' => 1,
                ]);
            } elseif ($data_term_semester_2->count() === count($data_term_semester_2) && $data_term_semester_2->count() >= 3) {
                $tapel->update([
                    'semester_id' => 2,
                ]);
            }

            if ($tapelLama->id == $request->select_tapel_id) {
                $tapelLama->update(['status' => 1]);
            } else {
                $tapelLama->update(['status' => 0]);
            }

            $tapel->update([
                'status' => 1,
            ]);

            $data_sekolah = [
                'tapel_id' => $request->select_tapel_id,
            ];
            $sekolah->update($data_sekolah);

            session(['tapel_id' => $request->select_tapel_id]);
            session(['semester_id' => $tapel->semester_id]);
            session(['term_id' => $tapel->term_id]);

            return back()->with('success', 'School Year updated successfully');
        } catch (\Exception $e) {
            return back()->with('toast_error', $e->getMessage())->withInput();
        }
    }
}
