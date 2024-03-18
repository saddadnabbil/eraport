<?php

namespace App\Http\Controllers\Admin\Km;

use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\TkPoint;
use App\Models\TkTopic;
use App\Models\TkElement;
use App\Models\TkSubtopic;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2])->orderBy('tingkatan_id', 'ASC')->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->where('tingkatan_id', [1, 2])->get('id');

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        }

        return view('admin.km.penilaiantk.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'tapel'));
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
        $term = Term::where('id', $kelas->tingkatan->term_id)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2])
            ->get();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2])
            ->where('id', $request->kelas_id)
            ->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');

        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        return view('admin.km.penilaiantk.create', compact('title', 'data_anggota_kelas', 'kelas', 'data_kelas', 'tapel', 'term'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Penilaian Raport TK';
        $kelas = Kelas::where('id', $request->kelas_id)->first();
        $tapel = Tapel::where('status', 1)->first();
        $term = Term::where('id', $kelas->tingkatan->term_id)->first();

        $data_kelas = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2])
            ->get();

        $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)
            ->whereIn('tingkatan_id', [1, 2])
            ->where('id', $request->kelas_id)
            ->get('id');

        $id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('id');
        $kelas_id_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get('kelas_id');


        $data_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->whereIn('anggota_kelas.id', $id_anggota_kelas)
            ->whereIn('anggota_kelas.kelas_id', $kelas_id_anggota_kelas)
            ->where('siswa.status', 1)
            ->get();

        $dataTkElements = TkElement::all();
        $dataTkTopics = TkTopic::all();
        $dataTkSubtopics = TkSubtopic::all();
        $dataTkPoints = TkPoint::all();

        return view('admin.km.penilaiantk.create', compact('title', 'data_anggota_kelas', 'kelas', 'data_kelas', 'tapel', 'term', 'dataTkElements', 'dataTkTopics', 'dataTkSubtopics', 'dataTkPoints',));
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
