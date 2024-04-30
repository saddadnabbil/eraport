<?php

namespace App\Http\Controllers\Admin\TK;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\TkEvent;
use App\Models\AnggotaKelas;
use App\Models\TkAttendance;
use Illuminate\Http\Request;
use App\Models\KehadiranSiswa;
use App\Models\TkAchivementGrade;
use App\Http\Controllers\Controller;
use App\Models\TkAchivementEventGrade;
use Illuminate\Support\Facades\Validator;

class TkEventAchivementGradeSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Input Nilai Event Siswa';
        $tapel = Tapel::where('status', 1)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2, 3])->get();

        return view('admin.tk.event.create', compact('title', 'data_kelas'));
    }

    public function create(Request $request)
    {
        $kelas = Kelas::where('id', $request->kelas_id)->first();
        $title = 'Input Nilai Event Siswa - Kelas ' . $kelas->nama_kelas;
        $tapel = Tapel::where('status', 1)->first();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->where('id', $request->kelas_id)
            ->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        $data_event = TkEvent::get();

        $rekap_event = TkAchivementEventGrade::get();

        return view('admin.tk.event.input', compact('title', 'data_anggota_kelas', 'data_event', 'rekap_event'));
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
            'anggota_kelas_id.*' => 'required|exists:anggota_kelas,id',
            'grade_event.*' => 'nullable|in:C,ME,I,NI',
            'tk_event_id.*' => 'required|exists:tk_events,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach ($request->anggota_kelas_id as $index => $anggota_kelas_id) {
            $tk_event_id = $request->tk_event_id[$index];
            $grade = $request->grade_event[$index] ?? null;

            if ($grade !== null) {
                TkAchivementEventGrade::updateOrCreate(
                    ['anggota_kelas_id' => $anggota_kelas_id, 'tk_event_id' => $tk_event_id],
                    ['grade' => $grade]
                );
            }
        }

        return back()->with('success', 'Data berhasil disimpan');
    }
}
