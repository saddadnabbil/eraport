<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Pembelajaran;
use App\CapaianPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CapaianPembelajaranController extends Controller
{
    public function index()
    {
        $title = 'Capaian Pembajaran';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));
        $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
        $id_mapel = Mapel::where('tapel_id', $tapel->id)->get('id');

        $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->get();

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } elseif (count($data_kelas) == 0) {
            return redirect('admin/kelas')->with('toast_warning', 'Mohon isikan data kelas');
        } else {
            $data_cp = CapaianPembelajaran::whereIn('mapel_id', $id_mapel)->get();
            return view('admin.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp'));
        }

        return view('admin.cp.pilihkelas', compact('title', 'data_mapel', 'data_kelas', 'data_cp'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_cp.*' => 'required|min:2|max:10',
            'capaian_pembelajaran.*' => 'required|min:10|max:255',
            'ringkasan_cp.*' => 'required|min:10|max:150',
        ]);

        $validator->setAttributeNames([
            'kode_cp.*' => 'Kode CP',
            'capaian_pembelajaran.*' => 'Capaian Pembelajaran',
            'ringkasan_cp.*' => 'Ringkasan Capaian Pembelajaran',
        ]);
        
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $existingData = CapaianPembelajaran::whereIn('kode_cp', $request->kode_cp)->pluck('kode_cp')->toArray();
            
            for ($count = 0; $count < count($request->kode_cp); $count++) {
                $data_cp = array(
                    'mapel_id'  => $request->mapel_id,
                    'tingkatan_id'  => $request->tingkatan_id,
                    'semester'  => $request->semester,
                    'kode_cp'  => $request->kode_cp[$count],
                    'capaian_pembelajaran'  => $request->capaian_pembelajaran[$count],
                    'ringkasan_cp'  => $request->ringkasan_cp[$count],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                
                // Check if kode_cp already exists in the CapaianPembelajaran model
                if(!in_array($request->kode_cp[$count], $existingData)){
                    $store_data_cp[] = $data_cp;
                }
            }
            
            if(!empty($store_data_cp)){
                CapaianPembelajaran::insert($store_data_cp);
                return back()->with('toast_success', 'Capaian pembelajaran berhasil ditambahkan');

            } else {
                // Update existing data in the CapaianPembelajaran model
                for ($count = 0; $count < count($request->kode_cp); $count++) {
                    $data_cp = array(
                        'mapel_id'  => $request->mapel_id,
                        'tingkatan_id'  => $request->tingkatan_id,
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

    // Fungsi untuk mengecek apakah CapaianPembelajaran dapat dihapus
    private function isCapaianPembelajaranDeletable($capaian)
    {
        // Check if capaian_pembelajaran_id is used in either rencana_nilai_sumatif or rencana_nilai_formatif
        $isUsedInRencanaNilai = $capaian->rencana_nilai_sumatif()->where('capaian_pembelajaran_id', $capaian->id)->exists()
            || $capaian->rencana_nilai_formatif()->where('capaian_pembelajaran_id', $capaian->id)->exists();

        return !$isUsedInRencanaNilai;
    }
    

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mapel_id' => 'required',
            'tingkatan_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $title = 'Tambah Capaian Pembelajaran';
            $mapel_id = $request->mapel_id;
            $tingkatan_id = $request->tingkatan_id;

            $existingData = CapaianPembelajaran::where('mapel_id', $mapel_id)
            ->where('tingkatan_id', $tingkatan_id)
            ->get();

            $tapel = Tapel::findorfail(session()->get('tapel_id'));
            $data_mapel = Mapel::where('tapel_id', $tapel->id)->orderBy('nama_mapel', 'ASC')->get();
            $data_kelas = Kelas::where('tapel_id', $tapel->id)->groupBy('tingkatan_id')->orderBy('tingkatan_id', 'ASC')->get();

            // Menambah properti canDelete ke setiap item di $existingData
            foreach ($existingData as $data) {
                $data->canDelete = $this->isCapaianPembelajaranDeletable($data);
            }


            return view('admin.cp.create', compact('title', 'mapel_id', 'tingkatan_id', 'tapel', 'data_mapel', 'data_kelas', 'existingData'));
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
