<?php

namespace App\Http\Controllers\Siswa\KM;

use App\Models\Term;
use App\Models\Kelas;
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
use App\Models\CatatanWaliKelas;
use App\Models\TkAchivementGrade;
use App\Models\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TkAchivementEventGrade;

class NilaiAkhirSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Final Grade Semester';
        $siswa = Siswa::where('user_id', Auth::user()->id)->first();
        $kelas = Kelas::where('id', $siswa->kelas_id)->first();
        $tingkatan = $kelas->tingkatan;

        $term = Term::where('id', $kelas->tingkatan->term_id)->first();
        $tapel = Tapel::where('status', 1)->first();

        $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
        $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)->where('siswa_id', $siswa->id)->first();

        if ($tingkatan->whereIn('id', [1, 2, 3])->count() > 0) {
            $dataTkElements = TkElement::where('tingkatan_id', $kelas->tingkatan_id)->get();
            $dataTkTopics = TkTopic::whereIn('tk_element_id', $dataTkElements->pluck('id'))->get();
            $dataTkSubtopics = TkSubtopic::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->get();
            $dataTkPoints = TkPoint::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->where('term_id', $term->id)->get();

            // Achivements
            $dataAchivements = TkAchivementGrade::where('term_id', $term->id)->get(['anggota_kelas_id', 'tk_point_id', 'achivement']);
            $dataAchivementEvents = TkAchivementEventGrade::get(['anggota_kelas_id', 'tk_event_id', 'achivement_event']);
            $dataAttendance = TkAttendance::where('anggota_kelas_id', $anggota_kelas->id)->first(['anggota_kelas_id', 'no_school_days', 'days_attended', 'days_absent']);
            $dataCatatanWalikelas = CatatanWaliKelas::where('anggota_kelas_id', $anggota_kelas->id)->first(['anggota_kelas_id', 'catatan']);
            // EVENTS
            $dataEvents = TkEvent::where('tapel_id', $tapel->id)->where('term_id', $term->id)->get();
        }

        if (is_null($anggota_kelas)) {
            return back()->with('toast_warning', 'Anda belum masuk ke anggota kelas');
        } else {
            $data_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->where('status', 1)->get();
            foreach ($data_pembelajaran as $pembelajaran) {
                $pembelajaran->nilai = KmNilaiAkhirRaport::where('pembelajaran_id', $pembelajaran->id)->where('anggota_kelas_id', $anggota_kelas->id)->first();
            }
            $anggotaKelas = $anggota_kelas;
            return view('siswa.km.nilaiakhir.index', compact('title', 'siswa', 'anggotaKelas', 'term', 'tapel', 'tingkatan', 'data_pembelajaran', 'dataAchivements', 'dataAchivementEvents', 'dataAttendance', 'dataCatatanWalikelas', 'dataEvents', 'dataTkPoints', 'dataTkSubtopics', 'dataTkTopics', 'dataTkElements'));
        }
    }
}
