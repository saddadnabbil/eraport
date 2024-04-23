<?php

namespace App\Http\Controllers\Admin\Km;

use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\TkEvent;
use App\Models\TkPoint;
use App\Models\TkTopic;
use App\Models\TkElement;
use App\Models\TkSubtopic;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\TkAttendance;
use Illuminate\Http\Request;
use App\Models\TkPembelajaran;
use App\Models\CatatanWaliKelas;
use App\Models\TkAchivementGrade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TkAchivementEventGrade;
use Illuminate\Support\Facades\Validator;


class PenilaianTkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Penilaian Raport TK';
        $tapel = Tapel::where('status', 1)->first();

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();

        // $data_element = TkElement::where('tingkatan_id', $request->tingkatan_id)->get();
        // $data_topic = TkTopic::whereIn('tk_element_id', $data_element->pluck('id'))->get();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->get();

        // handle if kelas null
        if (count($data_kelas) == 0) {
            return redirect(route('kelas.index'))->with('toast_warning', 'Kelas Tingkatan TK Belum tersedia');
        }

        $term = $data_kelas->first()->tingkatan->term_id;

        $data_term = Term::orderBy('id', 'ASC')->get();

        $id_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2, 3])->get('id');

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        }

        return view('admin.km.penilaiantk.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'tapel', 'data_term', 'term'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Penilaian Raport TK';
        $kelas = Kelas::where('id', $request->kelas_id)->first();
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::where('id', $request->term_id)->first();

        $data_term = Term::orderBy('id', 'ASC')->get();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->get();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->where('id', $request->kelas_id)
            ->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->whereHas('siswa', function ($query) {
                // Memeriksa bahwa status siswa adalah 1
                $query->where('status', 1);
            })
            ->get();

        return view('admin.km.penilaiantk.create', compact('title', 'data_anggota_kelas', 'kelas', 'data_kelas', 'tapel', 'term', 'data_term'));
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
            'term_id' => 'required|exists:terms,id',
            'anggota_kelas_id' => 'required|exists:anggota_kelas,id',
            'tk_point_id.*' => 'required|exists:tk_points,id',
            'achivement.*' => 'nullable|min:0|max:100',
            'tk_event_id.*' => 'required|exists:tk_events,id',
            'achivement_event.*' => 'nullable|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $achivements = $request->input('achivement');

        if ($achivements) {
            foreach ($achivements as $key => $achivement) {
                if (!empty($achivement)) {
                    TkAchivementGrade::updateOrCreate(
                        [
                            'term_id' => $request->input('term_id'),
                            'anggota_kelas_id' => $request->input('anggota_kelas_id'),
                            'tk_point_id' => $request->input('tk_point_id')[$key],
                        ],
                        [
                            'achivement' => $achivement
                        ]
                    );
                }
            }
        }

        $achivement_events = $request->input('achivement_event');

        if ($achivement_events) {
            foreach ($achivement_events as $key => $event) {
                if (!empty($event)) {
                    TkAchivementEventGrade::updateOrCreate(
                        [
                            'anggota_kelas_id' => $request->input('anggota_kelas_id'),
                            'tk_event_id' => $request->input('tk_event_id')[$key],
                        ],
                        [
                            'achivement_event' => $event
                        ]
                    );
                }
            }
        }

        $no_school_days = $request->input('no_school_days');
        $days_attended = $request->input('days_attended');
        $days_absent = $request->input('days_absent');
        $catatan_wali_kelas = $request->input('catatan_wali_kelas');

        TkAttendance::updateOrCreate(
            ['anggota_kelas_id' => $request->input('anggota_kelas_id')],
            [
                'no_school_days' => $no_school_days ?? null,
                'days_attended' => $days_attended ?? null,
                'days_absent' => $days_absent ?? null,
            ]
        );

        CatatanWaliKelas::updateOrCreate(
            ['anggota_kelas_id' => $request->input('anggota_kelas_id')],
            [
                'catatan' => $catatan_wali_kelas
            ]
        );
        return back()->with('toast_success', 'Achievements saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = Auth::user();
        $kelas = Kelas::where('id', $request->kelas_id)->first();
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::where('id', $request->term_id)->first();
        $title = 'Penilaian Raport TK' . ' - ' . $kelas->nama_kelas . ' - Term ' . $term->term;
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $anggotaKelas = AnggotaKelas::where('id', $request->anggota_kelas_id)->first();
        $siswa = Siswa::where('id', $id)->first();

        $data_term = Term::orderBy('id', 'ASC')->get();
        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2, 3])
            ->get();

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

        $dataTkElements = TkElement::where('tingkatan_id', $kelas->tingkatan_id)->get();
        $dataTkTopics = TkTopic::whereIn('tk_element_id', $dataTkElements->pluck('id'))->get();
        $dataTkSubtopics = TkSubtopic::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->get();
        $dataTkPoints = TkPoint::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->where('term_id', $term->id)->get();

        // Achivements
        $dataAchivements = TkAchivementGrade::where('term_id', $term->id)->get(['anggota_kelas_id', 'tk_point_id', 'achivement']);
        $dataAchivementEvents = TkAchivementEventGrade::get(['anggota_kelas_id', 'tk_event_id', 'achivement_event']);
        $dataAttendance = TkAttendance::where('anggota_kelas_id', $request->anggota_kelas_id)->first(['anggota_kelas_id', 'no_school_days', 'days_attended', 'days_absent']);
        $dataCatatanWalikelas = CatatanWaliKelas::where('anggota_kelas_id', $request->anggota_kelas_id)->first(['anggota_kelas_id', 'catatan']);
        // EVENTS
        $dataEvents = TkEvent::where('tapel_id', $tapel->id)->where('term_id', $term->id)->get();

        return view('admin.km.penilaiantk.show', compact('title', 'data_anggota_kelas', 'kelas', 'data_kelas', 'tapel', 'term', 'data_term', 'dataTkElements', 'dataTkTopics', 'dataTkSubtopics', 'dataTkPoints', 'siswa', 'dataEvents', 'dataAchivements', 'anggotaKelas', 'dataAchivementEvents', 'dataAttendance', 'dataCatatanWalikelas'));
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
        //
    }
}
