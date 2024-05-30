<?php

namespace App\Http\Controllers\Guru\TK;

use PDF;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\TkPembelajaran;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\TkJadwalMengajarRecord;
use App\Models\TkJadwalPelajaranSlot;
use Illuminate\Support\Facades\Validator;

class TkJadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Select Teacher - Teaching Schedule';

        $guru_ids = TkPembelajaran::pluck('guru_id');
        $kelas = Kelas::whereIn('guru_id', $guru_ids)->whereIn('tingkatan_id', [1, 2, 3])->get();
        $dataGuru = Guru::whereIn('id', $kelas->pluck('guru_id'))->orderBy('id', 'ASC')->get();

        return view('guru.tk.jadwalmengajar.pilihkelas', compact('title', 'dataGuru'));
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

        $dataPembelajaran = TkPembelajaran::select('*')
            ->where('guru_id', $request->guru_id)
            ->groupBy('tk_topic_id')
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

        $existingScheduleData = TkJadwalMengajarRecord::where('guru_id', $request->guru_id)->get();

        foreach ($dataPembelajaran as $pembelajaran) {
            foreach ($existingScheduleData as $schedule) {
                $selected[$schedule->tk_topic_id][$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
            }
        }

        $dataJadwalMengajarSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        return view('guru.tk.jadwalmengajar.build', compact('title', 'tapel', 'dataPembelajaran', 'guru', 'dataJadwalMengajarSlot', 'dataWeekdays', 'dataKelas', 'selected'));
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
            'tk_topic_id' => 'required|exists:tk_topics,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        foreach ($request->kelas as $tkTopicId => $slotIds) {
            foreach ($slotIds as $slotId => $kelas) {
                foreach ($kelas as $day => $classId) {
                    $existingRecord = TkJadwalMengajarRecord::where('tk_jadwal_pelajaran_slot_id', $slotId)
                        ->where('tk_topic_id', $tkTopicId)
                        ->where('hari', $day)
                        ->first();

                    if ($existingRecord) {
                        if ($existingRecord->kelas_id != $classId) {
                            $existingRecord->update([
                                'kelas_id' => $classId,
                            ]);
                        }
                    } else {
                        $test = TkJadwalMengajarRecord::create([
                            'tk_jadwal_pelajaran_slot_id' => $slotId,
                            'kelas_id' => $classId,
                            'guru_id' => $request->guru_id,
                            'tk_topic_id' => $tkTopicId,
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
        $pembelajaran = TkPembelajaran::findOrFail($id);

        $title = 'Teacher Schedule - ' . $pembelajaran->topic->name . ' - ' . $pembelajaran->guru->karyawan->nama_lengkap;
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

        $existingScheduleData = TkJadwalMengajarRecord::where('guru_id', $pembelajaran->guru_id)->where('tk_topic_id', $pembelajaran->tk_topic_id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        return view('guru.tk.jadwalmengajar.show', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas', 'pembelajaran'));
    }

    public function print(Request $request, $id)
    {
        $pembelajaran = TkPembelajaran::findOrFail($id);
        $guru = Guru::findOrFail($pembelajaran->guru_id);

        $title = 'Teacher Schedule - ' . $pembelajaran->topic->name . ' - ' . $pembelajaran->guru->karyawan->nama_lengkap;
        $title = 'Print Teacher Schedule - ' . $guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->topic->name;
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

        $existingScheduleData = TkJadwalMengajarRecord::where('guru_id', $pembelajaran->guru_id)->where('tk_topic_id', $pembelajaran->tk_topic_id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->orderBy('id', 'ASC')->get();

        $timetable = PDF::loadview('guru.tk.jadwalmengajar.print', compact('title', 'pembelajaran', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas'))->setPaper('A4', 'landscape');
        return $timetable->stream('Print (' . $guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->topic->name . ').pdf');
    }
}
