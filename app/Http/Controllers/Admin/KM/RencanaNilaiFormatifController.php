<?php

namespace App\Http\Controllers\Admin\KM;

use App\Kelas;
use App\Tapel;
use App\Pembelajaran;
use App\NilaiFormatif;
use App\CapaianPembelajaran;
use Illuminate\Http\Request;
use App\RencanaNilaiFormatif;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class RencanaNilaiFormatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Rencana Nilai Formatif';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        // $guru = Guru::where('user_id', Auth::user()->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

        $data_rencana_penilaian = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        foreach ($data_rencana_penilaian as $penilaian) {
            $rencana_penilaian = RencanaNilaiFormatif::where('pembelajaran_id', $penilaian->id)->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }

        return view('admin.km.rencanaformatif.index', compact('title', 'data_rencana_penilaian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title = 'Tambah Rencana Nilai Formatif';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
        $kelas = Kelas::findorfail($pembelajaran->kelas_id);
        $data_cp = CapaianPembelajaran::where([
            'semester' => $tapel->semester,
            'pembelajaran_id' => $pembelajaran->id,
        ])->orderBy('kode_cp', 'ASC')->get();

        if (count($data_cp) == 0) {
            return redirect(route('cp.index'))->with('toast_error', 'Belum ditemukan data capaian pembelajaran formatif, silahkan tambahkan data CP.');
        } else {
            $jumlah_penilaian = $request->jumlah_penilaian;
            return view('admin.km.rencanaformatif.create', compact('title', 'pembelajaran', 'jumlah_penilaian', 'data_cp'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Memeriksa setiap kode_penilaian untuk keunikan
        foreach ($request->kode_penilaian as $kode) {
            $count = RencanaNilaiFormatif::where('kode_penilaian', $kode)
                                            ->where('pembelajaran_id', $request->pembelajaran_id)
                                            ->count();

            // Jika kode penilaian sudah ada, kembalikan pesan kesalahan
            if ($count > 0) {
                return back()->with('toast_error', 'Kode penilaian ' . $kode . ' sudah ada untuk pembelajaran ini.');
            }
        }

        for ($count_penilaian = 0; $count_penilaian < count($request->teknik_penilaian); $count_penilaian++) {
            for ($count_cp = 0; $count_cp < count($request->capaian_pembelajaran_id[$count_penilaian]); $count_cp++) {
                $data_penilaian = array(
                    'pembelajaran_id' => $request->pembelajaran_id,
                    'capaian_pembelajaran_id'  => $request->capaian_pembelajaran_id[$count_penilaian][$count_cp],
                    'kode_penilaian'  => $request->kode_penilaian[$count_penilaian],
                    'teknik_penilaian'  => $request->teknik_penilaian[$count_penilaian],
                    'bobot_teknik_penilaian'  => $request->bobot_teknik_penilaian[$count_penilaian],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $data_penilaian_permapel[] = $data_penilaian;
            }
            $store_data_penilaian = $data_penilaian_permapel;
        }
        RencanaNilaiFormatif::insert($store_data_penilaian);
        return redirect(route('rencanaformatif.index'))->with('toast_success', 'Rencana nilai Formatif berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Data Rencana Nilai Formatif';
        $pembelajaran = Pembelajaran::findorfail($id);
        $data_rencana_penilaian = RencanaNilaiFormatif::where('pembelajaran_id', $id)->orderBy('kode_penilaian', 'ASC')->orderBy('capaian_pembelajaran_id', 'DESC')->get();
        $data_rencana_penilaian_tambah = Pembelajaran::where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();
        
        foreach ($data_rencana_penilaian_tambah as $penilaian) {
            $rencana_penilaian = RencanaNilaiFormatif::where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get();
            $penilaian->jumlah_rencana_penilaian = count($rencana_penilaian);
        }
        return view('admin.km.rencanaformatif.show', compact('title', 'pembelajaran', 'data_rencana_penilaian', 'data_rencana_penilaian_tambah'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $title = 'Edit Rencana Nilai Formatif';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $pembelajaran = Pembelajaran::findorfail($request->pembelajaran_id);
        $kelas = Kelas::findorfail($pembelajaran->kelas_id);
        $data_cp = CapaianPembelajaran::where([
            'mapel_id' => $pembelajaran->mapel_id,
            'tingkatan_id' => $kelas->tingkatan_id,
            'semester' => $tapel->semester,
        ])->orderBy('kode_cp', 'ASC')->get();
        $jumlah_penilaian = $request->jumlah_penilaian;

        return view('admin.km.rencanaformatif.edit', compact('title', 'pembelajaran', 'jumlah_penilaian', 'data_cp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $kode_penilaian_list = []; // Array untuk menyimpan semua kode_penilaian

    //         for ($count_penilaian = 0; $count_penilaian < count($request->teknik_penilaian); $count_penilaian++) {
    //             for ($count_cp = 0; $count_cp < count($request->capaian_pembelajaran_id[$count_penilaian]); $count_cp++) {
    //                 $data_penilaian = array(
    //                     'pembelajaran_id' => $request->pembelajaran_id,
    //                     'capaian_pembelajaran_id'  => $request->capaian_pembelajaran_id[$count_penilaian][$count_cp],
    //                     'kode_penilaian'  => $request->kode_penilaian[$count_penilaian],
    //                     'teknik_penilaian'  => $request->teknik_penilaian[$count_penilaian],
    //                     'bobot_teknik_penilaian'  => $request->bobot_teknik_penilaian[$count_penilaian],
    //                     'created_at'  => Carbon::now(),
    //                     'updated_at'  => Carbon::now(),
    //                 );
    //                 $data_penilaian_permapel[] = $data_penilaian;
    //             }
    //             $store_data_penilaian = $data_penilaian_permapel;
    //         }

    //         // Validasi unik kode_penilaian
    //         $validator = Validator::make(['kode_penilaian_list' => $kode_penilaian_list], [
    //             'kode_penilaian_list.*' => 'distinct' // Memastikan semua kode adalah unik
    //         ]);
            
    //         if ($validator->fails()) {
    //             return back()->with('toast_error', 'Kode penilaian harus unik.');
    //         }

    //         try {
    //             RencanaNilaiFormatif::insert($store_data_penilaian);
    //             return redirect(route('rencanaformatif.index'))->with('toast_success', 'Rencana nilai Formatif berhasil diupdate.');
    //         } catch (\Throwable $th) {
    //             return back()->with('toast_warning', 'Perencanaan penilaian tidak dapat diupdate.');
    //         }
    //     } catch (\Throwable $th) {
    //         return back()->with('toast_error', 'Pilih minimal 1 CP pada setiap kolom penilaian.');
    //     }
    // }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'bobot_teknik_penilaian' => 'required|numeric',
            'teknik_penilaian' => 'required|in:1,2,3,4,5', 
            'kode_penilaian' => 'required', 
        ], [
            'bobot_teknik_penilaian.required' => 'Bobot teknik penilaian wajib diisi.',
            'kode_penilaian.required' => 'Kode Penilian penilaian wajib diisi.',
            'bobot_teknik_penilaian.numeric' => 'Bobot teknik penilaian harus berupa angka.',
            'teknik_penilaian.in' => 'Teknik penilaian tidak valid.',
        ]);
    
        try {
            // Cari data rencana penilaian berdasarkan ID
            $rencana_penilaian = RencanaNilaiFormatif::findOrFail($id);
        
            // Update data bobot_teknik_penilaian
            $rencana_penilaian->bobot_teknik_penilaian = $request->bobot_teknik_penilaian;
            $rencana_penilaian->teknik_penilaian = $request->teknik_penilaian; 
            $rencana_penilaian->kode_penilaian = $request->kode_penilaian; 
        
            // Simpan perubahan
            $rencana_penilaian->save();
        
            return back()->with('toast_success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            // Tangani kesalahan jika diperlukan
            return back()->with('toast_error', 'Terjadi kesalahan saat memperbarui data.');
        }
        
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RencanaNilaiFormatif  $rencanaNilaiFormatif
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        DB::beginTransaction();
    
        try {
            // Delete related records first
            NilaiFormatif::where('rencana_nilai_formatif_id', $id)->delete();
    
            // Now delete the main record
            $rencanaPenilaian = RencanaNilaiFormatif::find($id);
            $rencanaPenilaian->delete();
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Rencana Nilai Formatif deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
    
            return redirect()->back()->with('error', 'Failed to delete Rencana Nilai Formatif.');
        }
    }
    
    
}
