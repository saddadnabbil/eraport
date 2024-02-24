<?php

namespace App\Http\Controllers\Guru;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use App\Models\JadwalMengajar;
use App\Models\JadwalMengajarSlot;
use Illuminate\Http\Request;
use App\Models\JadwalMengajarRecord;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

        $data_pembelajaran = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        return view('admin.jadwalmengajar.pilihkelas', compact('title', 'data_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tapel = Tapel::where('status', 1)->first();

        $pembelajaran = Pembelajaran::where('id', $request->pembelajaran_id)->first();
        $title = 'Teacher Schedule - ' . $pembelajaran->guru->karyawan->nama_lengkap . ' - ' . $pembelajaran->mapel->nama_mapel;

        $dataJadwalMengajar = JadwalMengajar::where('tapel_id', 1)->where('kelas_id', $pembelajaran->kelas_id)->get();

        return view('admin.jadwalmengajar.index', compact('title', 'dataJadwalMengajar', 'tapel', 'pembelajaran'));
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
            'tapel_id' => 'required',
            'kelas_id' => 'required',
            'nama' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $jadwalMengajar = new JadwalMengajar([
            'tapel_id' => $request->tapel_id,
            'kelas_id' => $request->kelas_id,
            'nama' => $request->nama,
        ]);
        $jadwalMengajar->save();

        return back()->with('toast_success', 'Timetable berhasil ditambahkan');
    }

    /**
     * Build the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function build($id)
    {
        $title = 'Manage Teacher Schedule';
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
        $existingScheduleData = JadwalMengajarRecord::all();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_mengajar_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $jadwalMengajar = JadwalMengajar::findOrFail($id);
        $dataJadwalMengajarSlot = JadwalMengajarSlot::where('jadwal_mengajar_id', $id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.build', compact('title', 'jadwalMengajar', 'dataJadwalMengajarSlot', 'dataWeekdays', 'dataKelas', 'selected'));
    }

    public function timeSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jadwal_mengajar_id' => 'required',
            'start_time' => 'required',
            'stop_time' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $jadwalMengajarSlot = new JadwalMengajarSlot([
            'jadwal_mengajar_id' => $request->jadwal_mengajar_id,
            'start_time' => $request->start_time,
            'stop_time' => $request->stop_time,
            'keterangan' => $request->keterangan,
        ]);
        $jadwalMengajarSlot->save();

        return back()->with('toast_success', 'Timeslot jadwal pelajaran berhasil ditambahkan');
    }

    public function deleteTimeSlot($id)
    {
        try {
            $timeSlot = JadwalMengajarSlot::findOrFail($id);

            // Hapus timeslot
            $timeSlot->delete();

            return back()->with('toast_success', 'Timeslot berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('toast_success', 'Timeslot gagal dihapus');
        }
    }

    public function manage(Request $request)
    {
        // Validasi input
        $request->validate([
            'kelas' => 'required|array', // pastikan data kelas ada dan berbentuk array
            'kelas.*.*' => 'nullable|exists:kelas,id', // Jadikan nullable dan pastikan setiap subject yang dipilih valid
        ]);

        // Loop melalui data yang dikirim dari formulir
        foreach ($request->kelas as $slotId => $kelas) {
            foreach ($kelas as $day => $subjectId) {
                // Cari apakah jadwal pelajaran record dengan slotId dan hari yang sama sudah ada
                $existingRecord = JadwalMengajarRecord::where('jadwal_mengajar_slot_id', $slotId)
                    ->where('hari', $day)
                    ->first();

                if ($existingRecord) {
                    // Jika sudah ada, lakukan update
                    $existingRecord->update([
                        'kelas_id' => $subjectId,
                    ]);
                } else {
                    // Jika belum ada, lakukan create
                    JadwalMengajarRecord::create([
                        'jadwal_mengajar_slot_id' => $slotId,
                        'kelas_id' => $subjectId,
                        'hari' => $day,
                    ]);
                }
            }
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Jadwal Mengajar berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Timetable';
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
        $existingScheduleData = JadwalMengajarRecord::all();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_mengajar_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $jadwalMengajar = JadwalMengajar::findOrFail($id);
        $dataJadwalMengajarSlot = JadwalMengajarSlot::where('jadwal_mengajar_id', $id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.show', compact('title', 'dataWeekdays', 'selected', 'jadwalMengajar', 'dataJadwalMengajarSlot', 'dataKelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            $jadwalMengajar = jadwalMengajar::findOrFail($id);

            // Hapus jadwal Mengajar
            $jadwalMengajar->delete();

            return back()->with('toast_success', 'jadwal Mengajar berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('toast_success', 'jadwal Mengajar  gagal dihapus');
        }
    }
}
