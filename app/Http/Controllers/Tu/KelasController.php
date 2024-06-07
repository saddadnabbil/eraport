<?php

namespace App\Http\Controllers\Tu;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Jurusan;
use App\Models\Tingkatan;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tapel = Tapel::where('status', 1)->first();

        $title = 'Data Kelas';
        $data_kelas = Kelas::with('anggota_kelas')
            ->where('tapel_id', $tapel->id)
            ->orderBy('tingkatan_id', 'ASC')
            ->get();

        $jumlah_anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->where('anggota_kelas.tapel_id', $tapel->id)
            ->where('siswa.status', 1)
            ->groupBy('anggota_kelas.kelas_id')
            ->select('anggota_kelas.kelas_id', DB::raw('COUNT(*) as jumlah_anggota'))
            ->get()
            ->keyBy('kelas_id');

        $data_guru = Guru::orderBy('id', 'ASC')->get();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
        $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();

        $jumlah_kelas_per_tingkatan = Kelas::select('tingkatan_id', DB::raw('count(*) as jumlah_kelas'))
            ->where('tapel_id', $tapel->id)
            ->groupBy('tingkatan_id')
            ->pluck('jumlah_kelas', 'tingkatan_id');

        return view('tu.kelas.index', compact(
            'title',
            'data_kelas',
            'tapel',
            'data_guru',
            'data_tingkatan',
            'data_jurusan',
            'jumlah_kelas_per_tingkatan',
            'jumlah_anggota_kelas'
        ));
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
            'tingkatan_id' => 'required',
            'jurusan_id' => 'required',
            'nama_kelas' => 'required|min:2|max:30',
            'guru_id' => 'required',
        ]);

        $tingkatan = Tingkatan::find($request->tingkatan_id);
        $jurusan = Jurusan::find($request->jurusan_id);

        if ($tingkatan->id != '6' && ($jurusan->id == '1' || $jurusan->id == '2')) {
            return back()->with('toast_error', $tingkatan->nama_tingkatan . ' Tidak boleh mengambil jurusan ' . $jurusan->nama_jurusan)->withInput();
        }

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $tapel = Tapel::where('status', 1)->first();
            $kelas = new Kelas([
                'tingkatan_id' => $request->tingkatan_id,
                'jurusan_id' => $request->jurusan_id,
                'tapel_id' => $tapel->id,
                'guru_id' => $request->guru_id,
                'nama_kelas' => strtoupper($request->nama_kelas),
            ]);
            $kelas->save();
            return back()->with('toast_success', 'Kelas berhasil ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Anggota Kelas';
        $tapel = Tapel::where('status', 1)->first();
        $kelas = Kelas::findorfail($id);
        $data_kelas = Kelas::where('tapel_id', $kelas->tapel_id)->where('tingkatan_id', $kelas->tingkatan_id)->get();
        $anggota_kelas = AnggotaKelas::where('kelas_id', $id)
            ->where('tapel_id', $tapel->id)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        $siswa_belum_masuk_kelas = Siswa::whereDoesntHave('anggota_kelas', function ($query) use ($tapel) {
            $query->where('tapel_id', $tapel->id);
        })->where('status', 1)->get();

        foreach ($siswa_belum_masuk_kelas as $belum_masuk_kelas) {
            // Ambil informasi Academic Year tapel sekarang
            $tahun_pelajaran_sekarang = $tapel->tahun_pelajaran;

            // Split Academic Year menjadi dua bagian (misalnya: '2023-2024' menjadi ['2023', '2024'])
            $parts = explode('-', $tahun_pelajaran_sekarang);

            // Hitung Academic Year sebelumnya
            $tahun_pelajaran_sebelumnya = ($parts[0] - 1) . '-' . ($parts[1] - 1);

            // Cari tapel sebelumnya berdasarkan Academic Year sebelumnya
            $tapel_sebelumnya = Tapel::where('tahun_pelajaran', $tahun_pelajaran_sebelumnya)->first();

            if (!is_null($tapel_sebelumnya)) {
                // Ambil kelas sebelumnya siswa jika ada
                $kelas_sebelumhya = AnggotaKelas::where('siswa_id', $belum_masuk_kelas->id)
                    ->where('tapel_id', $tapel_sebelumnya->id)
                    ->orderBy('id', 'DESC')
                    ->first();
            } else {
                $kelas_sebelumhya = null;
            }

            if (is_null($kelas_sebelumhya)) {
                $belum_masuk_kelas->kelas_sebelumhya = null;
            } else {
                $belum_masuk_kelas->kelas_sebelumhya = $kelas_sebelumhya->kelas->nama_kelas;
            }
        }

        return view('tu.kelas.show', compact('title', 'kelas', 'tapel', 'data_kelas', 'anggota_kelas', 'siswa_belum_masuk_kelas'));
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
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|min:1|max:30',
            'guru_id' => 'required',
            'tingkatan_id' => 'required',
            'jurusan_id' => 'required',
        ]);

        $tingkatan = Tingkatan::find($request->tingkatan_id);
        $jurusan = Jurusan::find($request->jurusan_id);

        if ($tingkatan->id != '6' && ($jurusan->id == '1' || $jurusan->id == '2')) {
            return back()->with('toast_error', $tingkatan->nama_tingkatan . ' Tidak boleh mengambil jurusan ' . $jurusan->nama_jurusan)->withInput();
        }

        // if (!preg_match('/[a-zA-Z]/', $request->nama_kelas) || !preg_match('/\d/', $request->nama_kelas)) {
        //     return back()->with('toast_error', 'Nama kelas harus mengandung setidaknya satu huruf dan satu angka')->withInput();
        // }

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $kelas = Kelas::findorfail($id);
            $data_kelas = [
                'tingkatan_id' => $request->tingkatan_id,
                'jurusan_id' => $request->jurusan_id,
                'nama_kelas' => $request->nama_kelas,
                'guru_id' => $request->guru_id,
            ];
            $kelas->update($data_kelas);
            return back()->with('toast_success', 'Kelas berhasil diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::findorfail($id);
        try {
            $kelas->delete();
            return back()->with('toast_success', 'Kelas berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Kosongkan anggota kelas terlebih dahulu');
        }
    }

    public function store_anggota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_warning', 'Tidak ada siswa yang dipilih');
        } else {
            $siswa_id = $request->input('siswa_id');
            $kelas = Kelas::find($request->input('kelas_id'));
            $tingkatan = Tingkatan::find($kelas->tingkatan_id);
            $jurusan = Jurusan::find($kelas->jurusan_id);

            for ($count = 0; $count < count($siswa_id); $count++) {
                $data = array(
                    'siswa_id' => $siswa_id[$count],
                    'tapel_id' => $request->tapel_id,
                    'kelas_id'  => $request->kelas_id,
                    'pendaftaran'  => $request->pendaftaran,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $insert_data[] = $data;

                $siswa = Siswa::find($siswa_id[$count]);
                if ($siswa->kelas_masuk == null && $siswa->tahun_masuk == null && $siswa->semester_masuk == null && $request->pendaftaran == 1 || $request->pendaftaran == 2) {
                    $siswa->update([
                        'kelas_masuk' => $kelas->nama_kelas,
                        'tahun_masuk' => Carbon::now()->year,
                        'semester_masuk' => $tingkatan->semester_id,
                    ]);
                }


                if ($siswa->kelas_id != $request->input('kelas_id') && $request->pendaftaran == 3 || $request->pendaftaran == 4 || $request->pendaftaran == 5) {
                    $siswa->update([
                        'kelas_id' => $request->kelas_id,
                        'tingkatan_id' => $tingkatan->id,
                        'jurusan_id' => $jurusan->id
                    ]);
                }
            }

            AnggotaKelas::insert($insert_data);
            Siswa::whereIn('id', $siswa_id)->update([
                'kelas_id' => $request->input('kelas_id'),
                'tingkatan_id' => $tingkatan->id,
                'jurusan_id' => $jurusan->id,
            ]);


            for ($count = 0; $count < count($siswa_id); $count++) {
                $siswa = Siswa::whereIn('id', $siswa_id)->first();
                if ($siswa->kelas_masuk === null && $siswa->tahun_masuk === null && $siswa->semester_masuk === null) {
                    $siswa->update([
                        'kelas_masuk' => $kelas->nama_kelas,
                        'tahun_masuk' => Carbon::now()->year,
                        'semester_masuk' => $tingkatan->semester_id
                    ]);
                }
            }

            return back()->with('toast_success', 'Anggota kelas berhasil ditambahkan');
        }
    }

    public function pindah_kelas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required',
            'kelas_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_warning', 'Tidak ada siswa yang dipilih');
        } else {
            $siswa_id = $request->input('siswa_id');
            $kelas = Kelas::find($request->kelas_id);

            $data = array(
                'siswa_id' => $siswa_id,
                'kelas_id'  => $request->kelas_id,
                'pendaftaran'  => 2,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            );
            $insert_data[] = $data;

            // Delete the existing record from the old class
            AnggotaKelas::where('siswa_id', $siswa_id)->delete();

            // Insert the record into the new class
            AnggotaKelas::insert($insert_data);
            Siswa::where('id', $siswa_id)->update([
                'kelas_id' => $request->kelas_id,
            ]);

            return back()->with('toast_success', 'Anggota kelas berhasil dipindahkan');
        }
    }

    // public function delete_anggota($id)
    // {
    //     try {
    //         $anggota_kelas = AnggotaKelas::findOrFail($id);
    //         $siswa = Siswa::findOrFail($anggota_kelas->siswa_id);

    //         $update = [
    //             'kelas_id' => null,
    //             'tingkatan_id' => null,
    //             'jurusan_id' => null,
    //         ];

    //         $siswa->update($update);

    //         $anggota_kelas->delete();
    //         return back()->with('toast_success', 'Anggota kelas berhasil dihapus');
    //     } catch (\Throwable $th) {
    //         return back()->with('toast_error', 'Anggota kelas tidak dapat dihapus');
    //     }
    // }

    public function delete_anggota($id)
    {
        $anggota_kelas = AnggotaKelas::findOrFail($id);

        try {
            // Set kelas_id to null
            $anggota_kelas->siswa->update([
                'kelas_id' => null,
                'tingkatan_id' => null,
                'jurusan_id' => null
            ]);

            // Delete the anggota_kelas record
            $anggota_kelas->delete();

            return back()->with('toast_success', 'Anggota Kelas berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus anggota kelas.');
        }
    }


    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanent($id)
    {
        $anggota_kelas = AnggotaKelas::withTrashed()->findOrFail($id);

        try {
            $anggota_kelas->forceDelete();

            return back()->with('toast_success', 'Anggota Kelas berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus siswa secara permanen.');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $anggota_kelas = AnggotaKelas::withTrashed()->findOrFail($id);

            $anggota_kelas_not_trashed = AnggotaKelas::where('siswa_id', $anggota_kelas->siswa_id)->where('id', '!=', $anggota_kelas->id)->get();

            // delete force
            $anggota_kelas_not_trashed->each(function ($anggota) {
                $anggota->forceDelete();
            });

            $anggota_kelas->restoreAnggotaKelas();



            return back()->with('toast_success', 'Anggota Kelas berhasil direstorasi');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi Anggota Kelas.');
        }
    }

    public function showTrash($id)
    {
        $title = "Data Trash Anggota Kelas";
        $anggotaKelasTrashed = AnggotaKelas::where('kelas_id', $id)->onlyTrashed()->get();

        return view('tu.kelas.trash', compact('title', 'anggotaKelasTrashed'));
    }
}
