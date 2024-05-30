<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use App\Models\JadwalPelajaranSlot;
use Illuminate\Http\Request;
use App\Models\JadwalMengajarRecord;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PDF;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Select Teacher - Teaching Schedule';

        $guru_ids = Pembelajaran::pluck('guru_id');
        $kelas = Kelas::whereIn('guru_id', $guru_ids)->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        $dataGuru = Guru::whereIn('id', $kelas->pluck('guru_id'))->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.pilihkelas', compact('title', 'dataGuru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guru_id' => 'required|exists:guru,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $dataPembelajaran = Pembelajaran::select('*')
            ->where('guru_id', $request->guru_id)
            ->groupBy('mapel_id')
            ->get();

        if ($dataPembelajaran->isEmpty()) {
            return back()->with('toast_error', 'Guru belum memiliki jadwal pembelajaran!');
        }

        $guru = Guru::where('id', $request->guru_id)->first();

        $title = 'Manage Teacher Schedule - ' . $guru->karyawan->nama_lengkap;
        $tapel = Tapel::where('status', 1)->first();

        $dataWeekdays = [];

        for ($i = Carbon::MONDAY; $i <= Carbon::FRIDAY; $i++) {
            $dayOfWeek = Carbon::now()->startOfWeek()->addDays($i - Carbon::MONDAY)->isoFormat('dddd');
            $dataWeekdays[] = $dayOfWeek;
        }

        $dataWeekdays = array_values($dataWeekdays);
        array_unshift($dataWeekdays, null);
        unset($dataWeekdays[0]);

        $selected = [];

        $existingScheduleData = JadwalMengajarRecord::where('guru_id', $request->guru_id)->get();

        foreach ($dataPembelajaran as $pembelajaran) {
            foreach ($existingScheduleData as $schedule) {
                $selected[$schedule->mapel_id][$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
            }
        }

        $dataJadwalMengajarSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.build', compact('title', 'tapel', 'dataPembelajaran', 'guru', 'dataJadwalMengajarSlot', 'dataWeekdays', 'dataKelas', 'selected'));
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
            'kelas' => 'required|array',
            'kelas.*.*.*' => 'nullable|exists:kelas,id',
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        foreach ($request->kelas as $mapelId => $slotIds) {
            foreach ($slotIds as $slotId => $kelas) {
                foreach ($kelas as $day => $classId) {
                    $existingRecord = JadwalMengajarRecord::where('jadwal_pelajaran_slot_id', $slotId)
                        ->where('mapel_id', $mapelId)
                        ->where('hari', $day)
                        ->first();

                    if ($existingRecord) {
                        if ($existingRecord->kelas_id != $classId) {
                            $existingRecord->update([
                                'kelas_id' => $classId,
                            ]);
                        }
                    } else {
                        JadwalMengajarRecord::create([
                            'jadwal_pelajaran_slot_id' => $slotId,
                            'kelas_id' => $classId,
                            'guru_id' => $request->guru_id,
                            'mapel_id' => $mapelId,
                            'hari' => $day,
                        ]);
                    }
                }
            }
        }

        return back()->with('success', 'Data jadwal mengajar berhasil disimpan');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembelajaran = Pembelajaran::findOrFail($id);

        $title = 'Teacher Schedule - ' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->guru->karyawan->nama_lengkap;
        $tapel = Tapel::where('status', 1)->first();

        $dataWeekdays = [];

        for ($i = Carbon::MONDAY; $i <= Carbon::FRIDAY; $i++) {
            $dayOfWeek = Carbon::now()->startOfWeek()->addDays($i - Carbon::MONDAY)->isoFormat('dddd');
            $dataWeekdays[] = $dayOfWeek;
        }

        $dataWeekdays = array_values($dataWeekdays);
        array_unshift($dataWeekdays, null);
        unset($dataWeekdays[0]);

        $selected = [];

        $existingScheduleData = JadwalMengajarRecord::where('guru_id', $pembelajaran->guru_id)->where('mapel_id', $pembelajaran->mapel_id)->orderBy('jadwal_pelajaran_slot_id', 'ASC')->get();

        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.show', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas', 'pembelajaran'));
    }

    public function print(Request $request, $id)
    {
        $pembelajaran = Pembelajaran::findOrFail($id);
        $guru = Guru::findOrFail($pembelajaran->guru_id);

        $title = 'Teacher Schedule - ' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->guru->karyawan->nama_lengkap;
        $title = 'Print Teacher Schedule - ' . $guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->mapel->nama_mapel;
        $tapel = Tapel::where('status', 1)->first();

        $dataWeekdays = [];

        for ($i = Carbon::MONDAY; $i <= Carbon::FRIDAY; $i++) {
            $dayOfWeek = Carbon::now()->startOfWeek()->addDays($i - Carbon::MONDAY)->isoFormat('dddd');
            $dataWeekdays[] = $dayOfWeek;
        }

        $dataWeekdays = array_values($dataWeekdays);
        array_unshift($dataWeekdays, null);
        unset($dataWeekdays[0]);

        $selected = [];

        $existingScheduleData = JadwalMengajarRecord::where('guru_id', $pembelajaran->guru_id)->where('mapel_id', $pembelajaran->mapel_id)->orderBy('jadwal_pelajaran_slot_id', 'ASC')->get();

        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereNotIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        $timetable = PDF::loadview('admin.jadwalmengajar.print', compact('title', 'pembelajaran', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas'))->setPaper('A4', 'landscape');
        return $timetable->stream('Print (' . $guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->mapel->nama_mapel . ').pdf');
    }
}
