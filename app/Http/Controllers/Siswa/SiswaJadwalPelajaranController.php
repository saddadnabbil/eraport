<?php

namespace App\Http\Controllers\Siswa;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use App\JadwalPelajaran;
use App\Models\JadwalPelajaranSlot;
use Illuminate\Http\Request;
use App\JadwalPelajaranRecord;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\JadwalMengajar;
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
        $title = 'Pilih Kelas - Time Table';

        $data_pembelajaran = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();


        return view('admin.jadwalpelajaran.pilihkelas', compact('title', 'data_pembelajaran'));
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
        $title = 'Timetable - ' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->kelas->nama_kelas;

        $dataJadwalPelajaran = JadwalPelajaran::where('tapel_id', 1)->where('mapel_id', $pembelajaran->mapel_id)->get();

        return view('admin.jadwalpelajaran.index', compact('title', 'dataJadwalPelajaran', 'tapel', 'pembelajaran'));
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
            'mapel_id' => 'required',
            'nama' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $jadwalPelajaran = new JadwalPelajaran([
            'tapel_id' => $request->tapel_id,
            'mapel_id' => $request->mapel_id,
            'nama' => $request->nama,
        ]);
        $jadwalPelajaran->save();

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
        $jadwalPelajaran = JadwalPelajaran::where('id', $id)->first();
        $pembelajaran = Pembelajaran::where('mapel_id', $jadwalPelajaran->mapel_id)->first();

        $title = 'Manage Timetable' . ' - ' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->kelas->nama_kelas;
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
        $existingScheduleData = JadwalPelajaranRecord::all();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->mapel_id;
        }

        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('jadwal_pelajaran_id', $id)->orderBy('start_time', 'ASC')->get();

        $dataMapel = Mapel::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('admin.jadwalpelajaran.build', compact('title', 'jadwalPelajaran', 'dataJadwalPelajaranSlot', 'dataWeekdays', 'dataMapel', 'selected'));
    }

    public function timeSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jadwal_pelajaran_id' => 'required',
            'start_time' => 'required',
            'stop_time' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $jadwalPelajaranSlot = new JadwalPelajaranSlot([
            'jadwal_pelajaran_id' => $request->jadwal_pelajaran_id,
            'start_time' => $request->start_time,
            'stop_time' => $request->stop_time,
            'keterangan' => $request->keterangan,
        ]);
        $jadwalPelajaranSlot->save();

        return back()->with('toast_success', 'Timeslot jadwal pelajaran berhasil ditambahkan');
    }

    public function deleteTimeSlot($id)
    {
        try {
            $timeSlot = JadwalPelajaranSlot::findOrFail($id);

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
            'mapel' => 'required|array', // pastikan data mapel ada dan berbentuk array
            'mapel.*.*' => 'nullable|exists:mapel,id', // Jadikan nullable dan pastikan setiap subject yang dipilih valid
        ]);

        // Loop melalui data yang dikirim dari formulir
        foreach ($request->mapel as $slotId => $mapel) {
            foreach ($mapel as $day => $subjectId) {
                // Cari apakah jadwal pelajaran record dengan slotId dan hari yang sama sudah ada
                $existingRecord = JadwalPelajaranRecord::where('jadwal_pelajaran_slot_id', $slotId)
                    ->where('hari', $day)
                    ->first();

                if ($existingRecord) {
                    // Jika sudah ada, lakukan update
                    $existingRecord->update([
                        'mapel_id' => $subjectId,
                    ]);
                } else {
                    // Jika belum ada, lakukan create
                    JadwalPelajaranRecord::create([
                        'jadwal_pelajaran_slot_id' => $slotId,
                        'mapel_id' => $subjectId,
                        'hari' => $day,
                    ]);
                }
            }
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Jadwal Pelajaran berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwalPelajaran = JadwalPelajaran::where('id', $id)->first();
        $pembelajaran = Pembelajaran::where('mapel_id', $jadwalPelajaran->mapel_id)->first();

        $title = 'Manage Timetable' . ' - ' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->kelas->nama_kelas;
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
        $existingScheduleData = JadwalPelajaranRecord::all();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->mapel_id;
        }

        $jadwalPelajaran = JadwalPelajaran::findOrFail($id);
        $dataJadwalPelajaranSlot = JadwalPelajaranSlot::where('jadwal_pelajaran_id', $id)->orderBy('start_time', 'ASC')->get();

        $dataMapel = Mapel::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('admin.jadwalpelajaran.show', compact('title', 'dataWeekdays', 'selected', 'jadwalPelajaran', 'dataJadwalPelajaranSlot', 'dataMapel'));
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
            $jadwalPelajaran = JadwalPelajaran::findOrFail($id);

            // Hapus jadwal Pelajaran
            $jadwalPelajaran->delete();

            return back()->with('toast_success', 'jadwal Pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('toast_success', 'jadwal Pelajaran gagal dihapus');
        }
    }
}
