<?php

namespace App\Http\Controllers\Admin\TK;

use PDF;
use App\Models\Guru;
use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\TkEvent;
use App\Models\TkPoint;
use App\Models\TkTopic;
use App\Models\Semester;
use App\Models\Tingkatan;
use App\Models\TkElement;
use App\Models\TkSubtopic;
use App\Models\KmTglRaport;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use App\Models\TkAttendance;
use Illuminate\Http\Request;
use App\Models\PrestasiSiswa;
use App\Models\KehadiranSiswa;
use App\Models\Ekstrakulikuler;
use App\Models\CatatanWaliKelas;
use App\Models\TkAchivementGrade;
use App\Models\KmNilaiAkhirRaport;
use App\Http\Controllers\Controller;
use App\Models\NilaiEkstrakulikuler;
use Illuminate\Support\Facades\Auth;
use App\Models\AnggotaEkstrakulikuler;
use App\Models\TkAchivementEventGrade;
use Illuminate\Support\Facades\Validator;

class CetakRaportTKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Cetak Raport TK';
        $tapel = Tapel::where('status', 1)->first();
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-pg-kg', 'homeroom-pg-kg'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $data_kelas = Kelas::where('guru_id', $guru->id)
                ->where('tapel_id', $tapel->id)
                ->whereIn('tingkatan_id', [1, 2, 3])
                ->get();
        } else {
            $data_kelas = Kelas::where('tapel_id', $tapel->id)
                ->whereIn('tingkatan_id', [1, 2, 3])
                ->get();
        }

        return view('admin.km.raporttk.setpaper', compact('title', 'data_kelas', 'tapel'));
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
            'kelas_id' => 'required|exists:kelas,id',
            'term_id' => 'required|exists:terms,id',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $title = 'Cetak Raport TK';
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::findorfail($request->term_id);
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum']) && $user->hasAnyPermission(['teacher-pg-kg', 'homeroom-pg-kg'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        }

        if (isset($guru)) {
            $kelas = Kelas::where('guru_id', $guru->id)->findOrFail($request->kelas_id);
            $data_kelas = Kelas::where('guru_id', $guru->id)
                ->where('tapel_id', $tapel->id)
                ->whereIn('tingkatan_id', [1, 2, 3])
                ->get();
        } else {
            $kelas = Kelas::findOrFail($request->kelas_id);
            $data_kelas = Kelas::where('tapel_id', $tapel->id)
                ->whereIn('tingkatan_id', [1, 2, 3])
                ->get();
        }

        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas->id)->get();

        $paper_size = 'A4';
        $orientation = 'potrait';

        return view('admin.km.raporttk.index', compact('title', 'kelas', 'tapel', 'data_kelas', 'data_anggota_kelas', 'paper_size', 'orientation', 'term'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $sekolah = Sekolah::first();
        $anggota_kelas = AnggotaKelas::findorfail($id);
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::findorfail($request->term_id);
        $nama = strtoupper($anggota_kelas->siswa->nama_lengkap);
        $kelas = strtoupper($anggota_kelas->kelas->nama_kelas);
        $nisn = $anggota_kelas->siswa->nisn;

        dd($tapel->km_tgl_raport->tempat_penerbitan);

        if ($tapel->km_tgl_raport->tempat_penerbitan == null) {
            return redirect()->back()->with('toast_error', 'Tempat Penerbitan Tidak Boleh Kosong');
        }

        if ($request->data_type == 1) {
            $title = 'Kelengkapan Raport TK';
            $kelengkapan_raport = PDF::loadview('walikelas.km.raporttk.kelengkapanraport', compact('title', 'sekolah', 'anggota_kelas', 'term'))->setPaper($request->paper_size, $request->orientation);
            return $kelengkapan_raport->stream('KELENGKAPAN RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
        } elseif ($request->data_type == 2) {
            $title = 'Raport TK';
            $data_id_pembelajaran = Pembelajaran::where('kelas_id', $anggota_kelas->kelas_id)->get('id');

            $dataTkElements = TkElement::where('tingkatan_id', $anggota_kelas->kelas->tingkatan_id)->get();
            $dataTkTopics = TkTopic::whereIn('tk_element_id', $dataTkElements->pluck('id'))->get();
            $dataTkSubtopics = TkSubtopic::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->get();
            $dataTkPoints = TkPoint::whereIn('tk_topic_id', $dataTkTopics->pluck('id'))->where('term_id', $term->id)->get();

            // Achivements
            $dataAchivements = TkAchivementGrade::get(['anggota_kelas_id', 'tk_point_id', 'achivement']);
            $dataAchivementEvents = TkAchivementEventGrade::get(['anggota_kelas_id', 'tk_event_id', 'achivement_event']);
            $dataAttendance = TkAttendance::where('anggota_kelas_id', $anggota_kelas->id)->first(['anggota_kelas_id', 'no_school_days', 'days_attended', 'days_absent']);
            $dataCatatanWalikelas = CatatanWalikelas::where('anggota_kelas_id', $anggota_kelas->id)->first(['anggota_kelas_id', 'catatan']);

            // EVENTS
            $dataEvents = TkEvent::where('tapel_id', $tapel->id)->where('term_id', $term->id)->get();

            $raport = PDF::loadview('walikelas.km.raporttk.raport', compact('title', 'sekolah', 'anggota_kelas',  'term', 'data_id_pembelajaran', 'dataTkElements', 'dataTkTopics', 'dataTkSubtopics', 'dataTkPoints', 'dataAchivements', 'dataEvents', 'dataAchivementEvents', 'dataAttendance', 'dataCatatanWalikelas'))->setPaper($request->paper_size, $request->orientation);

            $raport->render();
            $dompdf = $raport->getDomPDF();
            $font = $dompdf->getFontMetrics()->get_font("Arial", "bold");
            $width = 193.8;
            $height = 290;
            $margin = 10;
            $left = 22.5;

            $width *= 2.83;
            $height *= 2.83;

            $x = $width - $margin;
            $y = $height - $margin;

            $font_size = 6;
            $font_color = array(0, 0, 0);

            $dompdf->get_canvas()->page_text($left, $y, $nama . " ( "  . $nisn . ' ' . $kelas . " ) " . $tapel->tahun_pelajaran, $font, $font_size, $font_color, 0, 0, 0, 'L');

            $dompdf->get_canvas()->page_text($x, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, $font_size, $font_color, 0, 0, 0, 'R');

            return $raport->stream('RAPORT ' . $anggota_kelas->siswa->nama_lengkap . ' (' . $anggota_kelas->kelas->nama_kelas . ').pdf');
        }
    }

    public function export(Request $request, $id)
    {
        $sekolah = Sekolah::first();
        $data_anggota_kelas = AnggotaKelas::where('kelas_id', $id)->get();
        $kelas = Kelas::where('id', $id)->first();
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::findorfail($request->term_id);

        if ($request->data_type == 1) {
            $title = 'Kelengkapan Raport TK';
            $kelengkapan_raport = PDF::loadview('walikelas.km.raporttk.kelengkapanraport-all-data', compact('title', 'sekolah', 'kelas', 'tapel', 'data_anggota_kelas', 'term'))->setPaper($request->paper_size, $request->orientation);
            return $kelengkapan_raport->stream('KELENGKAPAN RAPORT  (' . $kelas->nama_kelas . ').pdf');
        } elseif ($request->data_type == 2) {
            $title = 'Raport TK';

            $dataTkElements = TkElement::all();
            $dataTkTopics = TkTopic::all();
            $dataTkSubtopics = TkSubtopic::all();
            $dataTkPoints = TkPoint::all();

            // Achivements
            $dataAchivements = TkAchivementGrade::get(['anggota_kelas_id', 'tk_point_id', 'achivement']);
            $dataAchivementEvents = TkAchivementEventGrade::get(['anggota_kelas_id', 'tk_event_id', 'achivement_event']);
            $dataAttendance = TkAttendance::get(['anggota_kelas_id', 'no_school_days', 'days_attended', 'days_absent']);
            $dataCatatanWalikelas = CatatanWalikelas::get(['anggota_kelas_id', 'catatan']);

            // EVENTS
            $dataEvents = TkEvent::where('tapel_id', $tapel->id)->where('term_id', $term->id)->get();

            $raport = PDF::loadview('walikelas.km.raporttk.raport-all-data', compact('title', 'sekolah', 'data_anggota_kelas',  'term', 'dataTkElements', 'dataTkTopics', 'dataTkSubtopics', 'dataTkPoints', 'dataAchivements', 'dataEvents', 'dataAchivementEvents', 'dataAttendance', 'kelas', 'dataCatatanWalikelas'))->setPaper($request->paper_size, $request->orientation);

            $raport->render();
            $dompdf = $raport->getDomPDF();
            $font = $dompdf->getFontMetrics()->get_font("Arial", "bold");
            $margin = 10; // margin in points
            $width = 193.8 * 2.83; // width of the page in points
            $height = 290 * 2.83; // height of the page in points

            $x = $width - $margin;
            $y = $height - $margin;
            $left = 22.5;

            $font_size = 6;
            $font_color_black = array(0, 0, 0); // RGB for black color

            $dompdf->get_canvas()->page_text($left, $y, $kelas->nama_kelas . $tapel->tahun_pelajaran, $font, $font_size, $font_color_black, 0, 0, 0, 'L');

            $dompdf->get_canvas()->page_text($x, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, $font_size, $font_color_black, 0, 0, 0, 'R');

            return $raport->stream('RAPORT ' . $kelas->nama_kelas . '.pdf');
        }
    }
}
