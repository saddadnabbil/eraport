<?php

namespace App\Http\Controllers\Admin;

use App\Siswa;
use App\Tapel;
use App\Sekolah;
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
        $data_tapel = Tapel::orderBy('id', 'DESC')->get();

        // Ambil nilai tapel_id jika ada, jika tidak, setel menjadi null
        $sekolah = Sekolah::first();
        $tapel_id = $sekolah ? $sekolah->tapel->tahun_pelajaran : null;

        return view('admin.tapel.index', compact('title', 'data_tapel', 'tapel_id'));
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
            'semester' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $tapel = new Tapel([
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester' => $request->semester,
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
            'semester' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $tapel = Tapel::findorfail($id);
            $data_tapel = [
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester' => $request->semester,
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
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'select_tapel_id' => $validator->messages()->first('select_tapel_id'),
                ]);
            }

            // Assuming you have a way to identify the specific Sekolah record, adjust the next line accordingly
            $sekolah = Sekolah::first(); // Change this line based on your logic to retrieve the Sekolah record

            if (!$sekolah) {
                throw new \Exception('Data Sekolah tidak ditemukan.');
            }

            $sekolah->update(['tapel_id' => $request->select_tapel_id]);

            // Setel sesi 'tapel_id' dengan nilai baru
            session(['tapel_id' => $request->select_tapel_id]);

            return back()->with('success', 'Tahun Pelajaran berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('toast_error', $e->getMessage())->withInput();
        }
    }
}
