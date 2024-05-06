<?php

namespace App\Http\Controllers\Admin\P5;

use PDF;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $title = 'Cetak Raport P5';
        $tapel = Tapel::where('status', 1)->first();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereNotIn('tingkatan_id', [1, 2, 3])
            ->get();

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

        $title = 'Cetak Raport P5';
        $kelas = Kelas::findorfail($request->kelas_id);
        $tapel = Tapel::where('status', 1)->first();
        $semester = Semester::findorfail($request->semester_id);

        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereNotIn('tingkatan_id', [1, 2, 3])
            ->get();

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa.nama_lengkap', 'ASC')
            ->where('anggota_kelas.kelas_id', $kelas->id)
            ->where('siswa.status', 1)
            ->get();

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
        $sekolah = Sekolah::first();
        $anggota_kelas = AnggotaKelas::findorfail($id);
        $tapel = Tapel::where('status', 1)->first();
        $semester = Semester::findorfail($request->semester_id);

        $title = 'Kelengkapan Raport';
        $kelengkapan_raport = PDF::loadview('admin.p5.raportp5.raport', compact('title', 'sekolah', 'anggota_kelas', 'semester'))->setPaper($request->paper_size, $request->orientation);
        return $kelengkapan_raport->stream('KELENGKAPAN RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
    }

    public function export(Request $request, $id)
    {
    }
}
