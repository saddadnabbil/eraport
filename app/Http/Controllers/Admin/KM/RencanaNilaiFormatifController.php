<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Tapel;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\CapaianPembelajaran;
use Illuminate\Http\Request;
use App\RencanaNilaiFormatif;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Semester;
use App\Term;
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
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $term = Term::findorfail(session()->get('term_id'));

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

        $data_rencana_penilaian = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        foreach ($data_rencana_penilaian as $penilaian) {
            dd($penilaian->kelas->tingkatan);
            $rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->get();
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
        $term = Term::findorfail(session()->get('term_id'));
        $pembelajaran = Pembelajaran::findorfail($id);
        $data_rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $id)->orderBy('kode_penilaian', 'ASC')->get();
        $data_rencana_penilaian_tambah = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        foreach ($data_rencana_penilaian_tambah as $penilaian) {
            $rencana_penilaian = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }
        return view('admin.km.rencanaformatif.show', compact('title', 'pembelajaran', 'data_rencana_penilaian', 'data_rencana_penilaian_tambah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Tambah Rencana Nilai Formatif';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $semester = Semester::findorfail(session()->get('semester_id'));
        $term = Term::findorfail(session()->get('term_id'));

        $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
        $kelas = Kelas::findorfail($pembelajaran->kelas_id);
        $data_cp = CapaianPembelajaran::where([
            'semester' => $semester->semester,
            'pembelajaran_id' => $pembelajaran->id,
        ])->orderBy('kode_cp', 'ASC')->get();

        $data_rencana_penilaian = RencanaNilaiFormatif::where('pembelajaran_id', $pembelajaran->id)->where('term_id', $term->id)->get();

        if (count($data_rencana_penilaian) >= 3) {
            return redirect(route('rencanaformatif.index'))->with('toast_error', 'Data sudah tersedia');
        }

        $jumlah_penilaian = $request->jumlah_penilaian;
        return view('admin.km.rencanaformatif.create', compact('title', 'pembelajaran', 'jumlah_penilaian', 'data_cp', 'data_rencana_penilaian', 'term'));
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
                'term_id' => $request->term_id,
                'kode_penilaian' => $request->kode_penilaian[$count_penilaian],
                'teknik_penilaian' => $request->teknik_penilaian[$count_penilaian],
                'bobot_teknik_penilaian' => $request->bobot_teknik_penilaian[$count_penilaian],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Kriteria untuk mencari atau membuat data
            $criteria = [
                'pembelajaran_id' => $request->pembelajaran_id,
                'term_id' => $request->term_id,
                'kode_penilaian' => $request->kode_penilaian[$count_penilaian],
                // Anda bisa menambahkan kriteria lain sesuai kebutuhan
            ];

            RencanaNilaiFormatif::updateOrCreate($criteria, $data_penilaian);

            $data_penilaian_permapel[] = $data_penilaian;
        }

        return redirect(route('rencanaformatif.index'))->with('toast_success', 'Rencana nilai Formatif berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $title = 'Edit Rencana Nilai Formatif';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
        $kelas = Kelas::findorfail($pembelajaran->kelas_id);
        $data_cp = CapaianPembelajaran::where([
            'mapel_id' => $pembelajaran->mapel_id,
            'tingkatan_id' => $kelas->tingkatan_id,
            'semester' => $tapel->semester->semester,
        ])->orderBy('kode_cp', 'ASC')->get();
        $jumlah_penilaian = $request->jumlah_penilaian;

        return view('admin.km.rencanaformatif.edit', compact('title', 'pembelajaran', 'jumlah_penilaian', 'data_cp'));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'bobot_teknik_penilaian' => 'required|numeric',
            'teknik_penilaian' => 'required|in:1,2,3,4,5',
            'kode_penilaian' => 'required',
        ], [
            'bobot_teknik_penilaian.required' => 'Bobot teknik penilaian wajib diisi.',
            'kode_penilaian.required' => 'Kode Penilian penilaian wajib diisi.',
            'bobot_teknik_penilaian.numeric' => 'Bobot teknik penilaian harus berupa angka.',
            'teknik_penilaian.in' => 'Teknik penilaian tidak valid.',
        ]);

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
