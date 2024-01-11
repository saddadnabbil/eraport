<?php

namespace App\Http\Controllers\Admin;

use App\Siswa;
use App\Tapel;
use App\Sekolah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Semester;
use App\Term;
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

        // Ambil nilai tapel_id jika ada, jika tidak, setel menjadi null
        $sekolah = Sekolah::first();
        $tapel_id = $sekolah ? $sekolah->tapel_id : null;
        $semester_id = $sekolah ? $sekolah->semester_id : null;
        $term_id = $sekolah ? $sekolah->term_id_id : null;

        return view('admin.tapel.index', compact('title', 'data_tapel', 'tapel_id', 'data_semester', 'semester_id', 'data_term', 'term_id', 'sekolah'));
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
            $tapel = new Tapel([
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester_id' => $request->semester_id,
            ]);
            $tapel->save();
            Siswa::where('status', 1)->update(['kelas_id' => null]);
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

    public function destroy($id)
    {
        $tapel = Tapel::findorfail($id);
        $tapel->delete();
        return back()->with('toast_success', 'Tahun Pelajaran berhasil dihapus');
    }

    public function setAcademicYear(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'select_tapel_id' => 'required|exists:tapels,id', // Ensure that the selected ID exists in the tapels table
                'select_semester_id' => 'required|exists:semesters,id', // Ensure that the selected ID exists in the semesters table
                'select_term_id' => 'required|exists:terms,id', // Ensure that the selected ID exists in the terms table
            ]);

            // if ($validator->fails()) {
            //     throw ValidationException::withMessages([
            //         'select_tapel_id' => $validator->messages()->first('select_tapel_id'),
            //         'select_semester_id' => $validator->messages()->first('select_semester_id'),
            //         'select_term_id' => $validator->messages()->first('select_term_id'),
            //     ]);
            // }

            // Assuming you have a way to identify the specific Sekolah record, adjust the next line accordingly
            $sekolah = Sekolah::first(); // Change this line based on your logic to retrieve the Sekolah record
            $tapel = Tapel::where('id', $request->select_tapel_id)->first(); // Change this line based on your logic to retrieve the Sekolah record

            if (!$sekolah) {
                throw new \Exception('Data Sekolah tidak ditemukan.');
            }

            $data_sekolah = [
                'tapel_id' => $request->select_tapel_id,
                'semester_id' => $request->select_semester_id,
                'term_id' => $request->select_term_id,
            ];

            $data_tapel = [
                'semester_id' => $request->select_semester_id,
            ];

            $sekolah->update($data_sekolah);
            $tapel->update($data_tapel);

            // Setel sesi 'tapel_id' dengan nilai baru
            session(['tapel_id' => $request->select_tapel_id]);
            session(['semester_id' => $request->select_semester_id]);
            session(['term_id' => $request->select_term_id]);

            return back()->with('success', 'School Year updated successfully');
        } catch (\Exception $e) {
            return back()->with('toast_error', $e->getMessage())->withInput();
        }
    }
}
