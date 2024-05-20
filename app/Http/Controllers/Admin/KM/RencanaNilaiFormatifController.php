<?php

namespace App\Http\Controllers\Admin\KM;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\NilaiFormatif;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\CapaianPembelajaran;
use App\Http\Controllers\Controller;
use App\Models\RencanaNilaiFormatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class RencanaNilaiFormatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Rencana Nilai Formatif';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

        if (isset($guru)) {
            $data_rencana_penilaian = Pembelajaran::where('guru_id', $guru->id)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        } else {
            $data_rencana_penilaian = Pembelajaran::where('status', 1)->whereIn('kelas_id', $id_kelas)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        }

        foreach ($data_rencana_penilaian as $penilaian) {
            $term = Term::findorfail($penilaian->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($penilaian->kelas->tingkatan->semester_id);
            $rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('semester_id', $semester->id)->where('pembelajaran_id', $penilaian->id)->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }

        return view('admin.km.rencanaformatif.index', compact('title', 'data_rencana_penilaian'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Data Rencana Nilai Formatif';
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-km', 'homeroom', 'homeroom-km'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            $pembelajaran = Pembelajaran::where('guru_id', $guru->id)->findorfail($id);
        } else {
            $pembelajaran = Pembelajaran::findorfail($id);
        }

        $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
        $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);
        $data_rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('semester_id', $semester->id)->where('pembelajaran_id', $id)->orderBy('kode_penilaian', 'ASC')->get();
        $data_rencana_penilaian_tambah = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        foreach ($data_rencana_penilaian_tambah as $penilaian) {
            $rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }
        return view('admin.km.rencanaformatif.show', compact('title', 'pembelajaran', 'data_rencana_penilaian', 'data_rencana_penilaian_tambah'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_penilaian_permapel = [];

        foreach ($request->teknik_penilaian as $count_penilaian => $value) {
            $data_penilaian = [
                'pembelajaran_id' => $request->pembelajaran_id,
                'semester_id' => $request->semester_id,
                'term_id' => $request->term_id,
                'kode_penilaian' => $request->kode_penilaian[$count_penilaian],
                'teknik_penilaian' => $request->teknik_penilaian[$count_penilaian],
                'bobot_teknik_penilaian' => $request->bobot_teknik_penilaian[$count_penilaian],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $kriteria = [
                'pembelajaran_id' => $request->pembelajaran_id,
                'semester_id' => $request->semester_id,
                'term_id' => $request->term_id,
                'kode_penilaian' => $request->kode_penilaian[$count_penilaian],
            ];

            RencanaNilaiFormatif::updateOrCreate($kriteria, $data_penilaian);

            $data_penilaian_permapel[] = $data_penilaian;
        }

        return redirect(route('km.rencanaformatif.index'))->with('toast_success', 'Rencana nilai Formatif berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'bobot_teknik_penilaian' => 'required|numeric',
            'teknik_penilaian' => 'required|in:1,2,3,4,5',
            'kode_penilaian' => 'required',
        ], [
            'bobot_teknik_penilaian.required' => 'Bobot teknik penilaian wajib diisi.',
            'kode_penilaian.required' => 'Kode Penilian penilaian wajib diisi.',
            'bobot_teknik_penilaian.numeric' => 'Bobot teknik penilaian harus berupa angka.',
            'teknik_penilaian.in' => 'Teknik penilaian tidak valid.',
        ]);

        if ($request->fails()) {
            return back()->with('toast_error', $validatedData->messages()->first())->withInput();
        }

        try {
            $rencana_penilaian = RencanaNilaiFormatif::findOrFail($id);

            $rencana_penilaian->bobot_teknik_penilaian = $request->bobot_teknik_penilaian;
            $rencana_penilaian->teknik_penilaian = $request->teknik_penilaian;
            $rencana_penilaian->kode_penilaian = $request->kode_penilaian;

            $rencana_penilaian->save();

            return back()->with('toast_success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Delete related records first
            NilaiFormatif::where('rencana_nilai_formatif_id', $id)->delete();

            // Now delete the main record
            $rencanaPenilaian = RencanaNilaiFormatif::find($id);
            $rencanaPenilaian->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Rencana Nilai Formatif deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to delete Rencana Nilai Formatif.');
        }
    }
}
