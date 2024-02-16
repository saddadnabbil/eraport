<?php

namespace App\Http\Controllers\Admin;

use App\Guru;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Pembelajaran;
use App\JadwalMengajar;
use App\JadwalMengajarSlot;
use App\JadwalPelajaranSlot;
use Illuminate\Http\Request;
use App\JadwalMengajarRecord;
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

        $dataGuru = Guru::orderBy('id', 'ASC')->get();

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
        $guru = Guru::where('id', $request->guru_id)->first();

        $title = 'Manage Teacher Schedule - ' . $guru->karyawan->nama_lengkap;
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
        $existingScheduleData = JadwalMengajarRecord::where('guru_id', $request->guru_id)->get();

        foreach ($dataPembelajaran as $pembelajaran) {
            // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
            foreach ($existingScheduleData as $schedule) {
                $selected[$schedule->mapel_id][$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
            }
        }

        $dataJadwalMengajarSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

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
        // dd($request->all());

        // Validasi input
        $validator = Validator::make($request->all(), [
            'kelas' => 'required|array', // pastikan data kelas ada dan berbentuk array
            'kelas.*.*.*' => 'nullable|exists:kelas,id', // Jadikan nullable dan pastikan setiap subject yang dipilih valid
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        // Loop melalui data yang dikirim dari formulir
        foreach ($request->kelas as $mapelId => $slotIds) {
            foreach ($slotIds as $slotId => $kelas) {
                foreach ($kelas as $day => $classId) {
                    // Cari apakah jadwal pelajaran record dengan slotId dan hari yang sama sudah ada
                    $existingRecord = JadwalMengajarRecord::where('jadwal_pelajaran_slot_id', $slotId)
                        ->where('mapel_id', $mapelId)
                        ->where('hari', $day)
                        ->first();

                    if ($existingRecord) {
                        // Jika sudah ada, lakukan update jika kelas yang dipilih berbeda
                        if ($existingRecord->kelas_id != $classId) {
                            $existingRecord->update([
                                'kelas_id' => $classId,
                            ]);
                        }
                    } else {
                        // Jika belum ada, lakukan create
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


        // Redirect ke halaman yang sesuai setelah berhasil menyimpan data
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

        $title = 'Timetable -' . $pembelajaran->mapel->nama_mapel . ' - ' . $pembelajaran->guru->karyawan->nama_lengkap;
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
        $existingScheduleData = JadwalMengajarRecord::where('guru_id', $pembelajaran->guru_id)->where('mapel_id', $pembelajaran->mapel_id)->get();

        // Isi variabel $selected dengan data jadwal pelajaran yang sudah ada
        foreach ($existingScheduleData as $schedule) {
            $selected[$schedule->jadwal_pelajaran_slot_id][$schedule->hari] = $schedule->kelas_id;
        }

        $dataJadwalMengajarSlot = JadwalPelajaranSlot::where('tapel_id', $tapel->id)->orderBy('start_time', 'ASC')->get();

        $dataKelas = Kelas::where('tapel_id', $tapel->id)->orderBy('id', 'ASC')->get();

        return view('admin.jadwalmengajar.show', compact('title', 'dataWeekdays', 'selected', 'dataJadwalMengajarSlot', 'dataKelas'));
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
