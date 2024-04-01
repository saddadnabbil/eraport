<?php

namespace App\Http\Controllers\Admin\KM;

use App\Models\Term;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\Pembelajaran;
use App\Models\CapaianPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CapaianPembelajaranController extends Controller
{
    public function index()
    {
        $title = 'Capaian Pembajaran';
        $tapel = Tapel::where('status', 1)->first();

        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        $id_mapel = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->whereNotIn('tingkatan_id', [1, 2, 3])->get();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');

        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $data_cp = CapaianPembelajaran::whereIn('mapel_id', $id_mapel)->get();
            return view('admin.km.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp', 'data_pembelajaran'));
        }

        return view('admin.km.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp', 'data_pembelajaran'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembelajaran_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Tambah Capaian Pembelajaran';
            $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);

            $tapel = Tapel::where('status', 1)->first();
            $term = Term::findorfail($pembelajaran->kelas->tingkatan->term_id);
            $semester = Semester::findorfail($pembelajaran->kelas->tingkatan->semester_id);

            $pembelajaran_id = $request->pembelajaran_id;
            $id_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->whereNotIn('tingkatan_id', [1, 2, 3])->get('id');
            $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('kelas_id', 'ASC')->orderBy('mapel_id', 'ASC')->get();
            $mapel_id = $pembelajaran->mapel->id;
            $tingkatan_id = $pembelajaran->kelas->tingkatan->id;
            $existingData = CapaianPembelajaran::where('pembelajaran_id', $pembelajaran_id)->get();

            foreach ($existingData as $data) {
                $data->canDelete = $this->isCapaianPembelajaranDeletable($data);
            }

            return view('admin.km.cp.create', compact('title', 'mapel_id', 'tingkatan_id', 'tapel', 'existingData', 'data_pembelajaran', 'pembelajaran_id', 'pembelajaran', 'semester', 'term'));
        }
    }

    private function isCapaianPembelajaranDeletable($capaian)
    {
        $isUsedInRencanaNilai = $capaian->rencana_nilai_sumatif()->where('capaian_pembelajaran_id', $capaian->id)->exists()
            || $capaian->rencana_nilai_formatif()->where('capaian_pembelajaran_id', $capaian->id)->exists();

        return !$isUsedInRencanaNilai;
    }


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
            $store_data_cp = [];

            for ($count = 0; $count < count($request->kode_cp); $count++) {
                // Cari data berdasarkan kode_cp
                $existingData = CapaianPembelajaran::where('kode_cp', $request->kode_cp[$count])->first();

                if ($existingData) {
                    if ($existingData->pembelajaran_id == $request->pembelajaran_id) {
                        $data_cp = [
                            'mapel_id'            => $request->mapel_id,
                            'tingkatan_id'        => $request->tingkatan_id,
                            'pembelajaran_id'     => $request->pembelajaran_id,
                            'semester'            => $request->semester,
                            'capaian_pembelajaran' => $request->capaian_pembelajaran[$count],
                            'ringkasan_cp'        => $request->ringkasan_cp[$count],
                            'updated_at'          => Carbon::now(),
                        ];

                        CapaianPembelajaran::where('kode_cp', $request->kode_cp[$count])
                            ->update($data_cp);
                    } else {
                        return back()->with('toast_error', 'Data sudah tersedia di pembelajaran lain');
                    }
                } else {
                    $data_cp = [
                        'mapel_id'            => $request->mapel_id,
                        'tingkatan_id'        => $request->tingkatan_id,
                        'pembelajaran_id'     => $request->pembelajaran_id,
                        'semester'            => $request->semester_id,
                        'kode_cp'             => $request->kode_cp[$count],
                        'capaian_pembelajaran' => $request->capaian_pembelajaran[$count],
                        'ringkasan_cp'        => $request->ringkasan_cp[$count],
                        'created_at'          => Carbon::now(),
                        'updated_at'          => Carbon::now(),
                    ];
                    $store_data_cp[] = $data_cp;
                }
            }

            if (!empty($store_data_cp)) {
                CapaianPembelajaran::insert($store_data_cp);
                return back()->with('toast_success', 'Capaian pembelajaran berhasil ditambahkan');
            } else {
                return back()->with('toast_success', 'Capaian pembelajaran berhasil diedit');
            }
        }
    }

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
