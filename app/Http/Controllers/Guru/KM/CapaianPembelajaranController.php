<?php

namespace App\Http\Controllers\Guru\KM;

use App\Guru;
use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Sekolah;
use App\Pembelajaran;
use App\CapaianPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CapaianPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Capaian Pembajaran';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $guru = Guru::where('user_id', Auth::user()->id)->first();

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        $id_mapel = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->get('id');

        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect('guru/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('guru/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $data_cp = CapaianPembelajaran::whereIn('mapel_id', $id_mapel)->get();
            return view('guru.km.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp', 'data_pembelajaran'));
        }

        return view('guru.km.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp', 'data_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Jika pembelajaran_id dan guru_id valid, lakukan validasi lainnya
        $validator = Validator::make($request->all(), [
            'pembelajaran_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Tambah Capaian Pembelajaran';
            $tapel = Tapel::findorfail(session()->get('tapel_id'));
            $semester = Sekolah::first()->semester_id;
            $guru = Guru::where('user_id', Auth::user()->id)->first();

            $pembelajaran = Pembelajaran::where('guru_id', $guru->id)->findorfail($request->pembelajaran_id);
            $pembelajaran_id = $request->pembelajaran_id;
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

            $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
            $mapel_id = $pembelajaran->mapel->id;
            $tingkatan_id = $pembelajaran->kelas->tingkatan->id;
            $existingData = CapaianPembelajaran::where('pembelajaran_id', $pembelajaran_id)->get();

            // Menambah properti canDelete ke setiap item di $existingData
            foreach ($existingData as $data) {
                $data->canDelete = $this->isCapaianPembelajaranDeletable($data);
            }


            return view('guru.km.cp.create', compact('title', 'mapel_id', 'tingkatan_id', 'tapel', 'existingData', 'data_pembelajaran', 'pembelajaran_id', 'pembelajaran', 'semester'));
        }
    }


    // Fungsi untuk mengecek apakah CapaianPembelajaran dapat dihapus
    private function isCapaianPembelajaranDeletable($capaian)
    {
        // Check if capaian_pembelajaran_id is used in either rencana_nilai_sumatif or rencana_nilai_formatif
        $isUsedInRencanaNilai = $capaian->rencana_nilai_sumatif()->where('capaian_pembelajaran_id', $capaian->id)->exists()
            || $capaian->rencana_nilai_formatif()->where('capaian_pembelajaran_id', $capaian->id)->exists();

        return !$isUsedInRencanaNilai;
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
            'kode_cp.*' => 'required|min:2|max:10',
            'capaian_pembelajaran.*' => 'required|min:10|max:255',
            'pembelajaran_id.*' => 'required',
            'ringkasan_cp.*' => 'required|min:10|max:150',
        ]);

        $validator->setAttributeNames([
            'kode_cp.*' => 'Kode CP',
            'capaian_pembelajaran.*' => 'Capaian Pembelajaran',
            'ringkasan_cp.*' => 'Ringkasan Capaian Pembelajaran',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->messages()->all()[0] . ' Jika ingin edit, hapus fields kosong.';
            return back()->with('toast_error', $errorMessage)->withInput();
        } else {
            $existingData = CapaianPembelajaran::where('pembelajaran_id', $request->pembelajaran_id)->whereIn('kode_cp', $request->kode_cp)->pluck('kode_cp')->toArray();

            for ($count = 0; $count < count($request->kode_cp); $count++) {
                $data_cp = array(
                    'mapel_id'  => $request->mapel_id,
                    'tingkatan_id'  => $request->tingkatan_id,
                    'pembelajaran_id'  => $request->pembelajaran_id,
                    'semester'  => $request->semester,
                    'kode_cp'  => $request->kode_cp[$count],
                    'capaian_pembelajaran'  => $request->capaian_pembelajaran[$count],
                    'ringkasan_cp'  => $request->ringkasan_cp[$count],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );

                // Check if kode_cp already exists in the CapaianPembelajaran model
                if (!in_array($request->kode_cp[$count], $existingData)) {
                    $store_data_cp[] = $data_cp;

                    CapaianPembelajaran::insert($store_data_cp);
                    return back()->with('toast_success', 'Capaian pembelajaran berhasil ditambahkan');
                } elseif (in_array($request->kode_cp[$count], $existingData)) {
                    $data_cp = array(
                        'mapel_id'  => $request->mapel_id,
                        'tingkatan_id'  => $request->tingkatan_id,
                        'pembelajaran_id'  => $request->pembelajaran_id,
                        'semester'  => $request->semester,
                        'capaian_pembelajaran'  => $request->capaian_pembelajaran[$count],
                        'ringkasan_cp'  => $request->ringkasan_cp[$count],
                        'updated_at'  => Carbon::now(),
                    );

                    CapaianPembelajaran::where('kode_cp', $request->kode_cp[$count])->update($data_cp);
                    return back()->with('toast_success', 'Capaian pembelajaran berhasil diedit');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cp = CapaianPembelajaran::find($id);

        if (!$cp) {
            return response()->json(['status' => 'error', 'message' => 'Capaian Pembelajaran not found.'], 404);
        }

        try {
            $cp->delete();
            return response()->json(['status' => 'success', 'message' => 'Capaian Pembelajaran deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error deleting Capaian Pembelajaran.'], 500);
        }
    }
}
