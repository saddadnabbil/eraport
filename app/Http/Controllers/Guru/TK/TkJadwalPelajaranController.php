<?php

namespace App\Http\Controllers\Guru\TK;

use PDF;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\TkPembelajaran;
use Illuminate\Support\Carbon;
use App\Models\JadwalPelajaran;
use App\Http\Controllers\Controller;
use App\Models\TkJadwalPelajaranSlot;
use App\Models\TkJadwalPelajaranRecord;
use App\Models\TkTopic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TkJadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tapel = Tapel::where('status', 1)->first();
        $title = 'Pilih Kelas - Time Table';

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->whereIn('tingkatan_id', [1, 2, 3])->get();

        return view('guru.tk.jadwalpelajaran.pilihkelas', compact('title', 'dataKelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $pembelajaran = TkPembelajaran::where('kelas_id', $request->kelas_id)->first();
        $kelas = Kelas::where('id', $request->kelas_id)->first();

        $title = 'Manage Timetable - ' .  $kelas->nama_kelas;
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
        $existingScheduleData = TkJadwalPelajaranRecord::where('kelas_id', $request->kelas_id)->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->tk_topic_id;
        }

        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataTopic = TkTopic::orderBy('id', 'ASC')->get();

        return view('guru.tk.jadwalpelajaran.build', compact('title', 'tapel', 'kelas', 'dataJadwalPelajaranSlot', 'dataWeekdays', 'dataTopic', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'topic' => 'required|array', // pastikan data topic ada dan berbentuk array
            'topic.*.*' => 'nullable|exists:tk_topics,id', // Jadikan nullable dan pastikan setiap subject yang dipilih valid
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Loop melalui data yang dikirim dari formulir
        foreach ($request->topic as $slotId => $topic) {
            foreach ($topic as $day => $subjectId) {
                $existingRecord = TkJadwalPelajaranRecord::where('tk_jadwal_pelajaran_slot_id', $slotId)
                    ->where('hari', $day)
                    ->first();

                if ($existingRecord) {
                    // Jika sudah ada, lakukan update
                    $existingRecord->update([
                        'tk_topic_id' => $subjectId,
                    ]);
                } else {
                    // Jika belum ada, lakukan create
                    TkJadwalPelajaranRecord::create([
                        'tk_jadwal_pelajaran_slot_id' => $slotId,
                        'tk_topic_id' => $subjectId,
                        'kelas_id' => $request->kelas_id,
                        'hari' => $day,
                    ]);
                }
            }
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Jadwal Pelajaran berhasil disimpan.');
    }


    public function timeSlot()
    {
        $title = 'Manage Time Slot';
        $tapel = Tapel::where('status', 1)->first();
        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::orderBy('start_time', 'ASC')->get();
        return view('guru.tk.jadwalpelajaran.timeslot', compact('title', 'dataJadwalPelajaranSlot', 'tapel'));
    }

    public function storeTimeSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tapel_id' => 'required',
            'start_time' => 'required',
            'stop_time' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $TkJadwalPelajaranSlot = new TkJadwalPelajaranSlot([
            'tapel_id' => $request->tapel_id,
            'start_time' => $request->start_time,
            'stop_time' => $request->stop_time,
            'keterangan' => $request->keterangan,
        ]);
        $TkJadwalPelajaranSlot->save();

        return back()->with('toast_success', 'Timeslot jadwal pelajaran berhasil ditambahkan');
    }


    public function updateTimeSlot(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'stop_time' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $slot = TkJadwalPelajaranSlot::findorfail($id);

        $data_slot = [
            'start_time' => $request->start_time,
            'stop_time' => $request->stop_time,
            'keterangan' => $request->keterangan,
        ];

        $slot->update($data_slot);

        return back()->with('toast_success', 'Timeslot jadwal pelajaran berhasil ditambahkan');
    }

    public function deleteTimeSlot($id)
    {
        try {
            $timeSlot = TkJadwalPelajaranSlot::findOrFail($id);

            // Hapus timeslot
            $timeSlot->delete();

            return back()->with('toast_success', 'Timeslot berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('toast_success', 'Timeslot gagal dihapus');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pembelajaran = TkPembelajaran::where('kelas_id', $id)->first();

        $kelas = Kelas::where('id', $id)->first();

        $title = 'Timetable - ' .  $kelas->nama_kelas;
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
        $existingScheduleData = TkJadwalPelajaranRecord::where('kelas_id', $id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->tk_topic_id;
        }

        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataTopic = TkTopic::orderBy('id', 'ASC')->get();

        return view('guru.tk.jadwalpelajaran.show', compact('title', 'kelas', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataTopic'));
    }

    public function print(Request $request, $id)
    {
        $pembelajaran = TkPembelajaran::where('kelas_id', $id)->first();

        $kelas = Kelas::findOrFail($id);
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
        $existingScheduleData = TkJadwalPelajaranRecord::where('kelas_id', $id)->orderBy('tk_jadwal_pelajaran_slot_id', 'ASC')->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->tk_jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->tk_topic_id;
        }

        $dataJadwalPelajaranSlot = TkJadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataTopic = TkTopic::orderBy('id', 'ASC')->get();
        $timetable = PDF::loadview('guru.tk.jadwalpelajaran.print', compact('title', 'dataWeekdays', 'selected', 'dataJadwalPelajaranSlot', 'dataTopic', 'kelas'))->setPaper('A4', 'landscape');
        return $timetable->stream('Print (' . $kelas->nama_kelas . ').pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $jadwalPelajaran = JadwalPelajaran::findOrFail($id);

            // Hapus jadwal Pelajaran
            $jadwalPelajaran->delete();

            return back()->with('toast_success', 'jadwal Pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('toast_success', 'jadwal Pelajaran gagal dihapus');
        }
    }
}
