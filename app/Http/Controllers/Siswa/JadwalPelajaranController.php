<?php

namespace App\Http\Controllers\Siswa;

use PDF;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\JadwalMengajar;
use App\Models\Ekstrakulikuler;
use App\JadwalPelajaran;
use App\Models\JadwalPelajaranSlot;
use Illuminate\Http\Request;
use App\Models\JadwalPelajaranRecord;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $tapel = Tapel::where('status', 1)->first();
        $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)->where('siswa_id', $siswa->id)->first();
        $title = 'Timetable';

        // Inisialisasi array kosong untuk menyimpan nama hari weekdays
        $dataWeekdays = [];

        for ($i = Carbon::MONDAY; $i <= Carbon::FRIDAY; $i++) {
            $dayOfWeek = Carbon::now()->startOfWeek()->addDays($i - Carbon::MONDAY)->isoFormat('dddd');
            $dataWeekdays[] = $dayOfWeek;
        }

        $dataWeekdays = array_values($dataWeekdays);
        array_unshift($dataWeekdays, null);
        unset($dataWeekdays[0]);

        // Inisialisasi variabel $selected sebagai array kosong
        $selected = [];

        // Dapatkan data jadwal pelajaran yang sudah ada, misalnya dari database
        $existingScheduleData = JadwalPelajaranRecord::where('kelas_id', $anggota_kelas->kelas_id)->orderBy('jadwal_pelajaran_slot_id', 'ASC')->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->mapel_id;
        }

        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataMapel = Mapel::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('siswa.jadwalpelajaran.show', compact('title', 'anggota_kelas', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataMapel'));
    }

    public function print(Request $request, $id)
    {
        $siswa = Siswa::where('user_id', Auth::user()->id)->where('kelas_id', $id)->first();

        if ($siswa) {
            $kelas = Kelas::findOrFail($siswa->kelas_id);
        } else {
            abort(404);
        }

        $kelas = Kelas::findOrFail($siswa->kelas_id);


        $title = 'Print Timetable - ' . $kelas->nama_kelas;

        $tapel = Tapel::where('status', 1)->first();

        // Inisialisasi array kosong untuk menyimpan nama hari weekdays
        $dataWeekdays = [];

        for ($i = Carbon::MONDAY; $i <= Carbon::FRIDAY; $i++) {
            $dayOfWeek = Carbon::now()->startOfWeek()->addDays($i - Carbon::MONDAY)->isoFormat('dddd');
            $dataWeekdays[] = $dayOfWeek;
        }

        $dataWeekdays = array_values($dataWeekdays);
        array_unshift($dataWeekdays, null);
        unset($dataWeekdays[0]);

        // Inisialisasi variabel $selected sebagai array kosong
        $selected = [];

        // Dapatkan data jadwal pelajaran yang sudah ada, misalnya dari database
        $existingScheduleData = JadwalPelajaranRecord::where('kelas_id', $id)->orderBy('jadwal_pelajaran_slot_id', 'ASC')->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->mapel_id;
        }

        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataMapel = Mapel::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();
        $timetable = PDF::loadview('admin.jadwalpelajaran.print', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataMapel', 'kelas'))->setPaper('A4', 'landscape');
        return $timetable->stream('Print (' . $kelas->nama_kelas . ').pdf');
    }
}
