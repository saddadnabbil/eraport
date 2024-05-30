<?php

namespace App\Http\Controllers\Siswa;

use PDF;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\TkTopic;
use App\JadwalPelajaran;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use Illuminate\Support\Carbon;
use App\Models\Ekstrakulikuler;
use App\Models\JadwalPelajaranSlot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalPelajaranRecord;
use App\Models\TkJadwalPelajaranSlot;
use App\Models\TkJadwalPelajaranRecord;
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
        $kelas = Kelas::where('id', $anggota_kelas->kelas_id)->first();
        $title = 'Timetable';

        if ($anggota_kelas->kelas->whereIn('tingkatan_id', [1, 2, 3])->count() > 0) {
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
            $existingScheduleData = TkJadwalPelajaranRecord::where('kelas_id', $anggota_kelas->kelas_id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

            // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
            foreach ($existingScheduleData as $schedule) {
                $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->tk_topic_id;
            }

            $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

            $dataTopic = TkTopic::orderBy('id', 'ASC')->get();

            return view('siswa.jadwalpelajaran.tk.show', compact('title', 'kelas', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataTopic'));
        } else {
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

        if ($kelas->whereIn('tingkatan_id', [1, 2, 3])->count() > 0) {
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
            $existingScheduleData = TkJadwalPelajaranRecord::where('kelas_id', $id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

            // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
            foreach ($existingScheduleData as $schedule) {
                $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->tk_topic_id;
            }

            $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

            $dataTopic = TkTopic::orderBy('id', 'ASC')->get();
            $timetable = PDF::loadview('guru.tk.jadwalpelajaran.print', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataTopic', 'kelas'))->setPaper('A4', 'landscape');
            return $timetable->stream('Print (' . $kelas->nama_kelas . ').pdf');
        } else {
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
}
