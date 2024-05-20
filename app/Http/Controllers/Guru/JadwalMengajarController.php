<?php

namespace App\Http\Controllers\Guru;

use PDF;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use App\Models\JadwalPelajaranSlot;
use Illuminate\Http\Request;
use App\Models\JadwalMengajarRecord;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Select Teaching Schedule';

        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $dataPembelajaran = Pembelajaran::select('*')
            ->where('guru_id', $guru->id)
            ->groupBy('mapel_id')
            ->get();

        return view('guru.jadwalmengajar.pilihkelas', compact('title', 'dataPembelajaran'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

        $pembelajaran = Pembelajaran::where('id', $request->pembelajaran_id)
            ->where('guru_id', $guru->id)
            ->first();

        if (!$pembelajaran) {
            return back()->with('toast_error', 'Teacher Schedule not found');
        } else {
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

            $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

            return view('guru.jadwalmengajar.show', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas', 'pembelajaran'));
        }
    }

    public function print(Request $request, $id)
    {
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

        $pembelajaran = Pembelajaran::where('id', $id)
            ->where('guru_id', $guru->id)
            ->first();

        if (!$pembelajaran) {
            return abort(404);
        } else {
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

            $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

            $timetable = PDF::loadview('guru.jadwalmengajar.print', compact('title', 'pembelajaran', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataKelas'))->setPaper('A4', 'landscape');
            return $timetable->stream('Print (' . $guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->mapel->nama_mapel . ').pdf');
        }
    }
}
