<?php

namespace App\Http\Controllers\Guru\MD;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Jurusan;
use App\Models\Tingkatan;
use Carbon\Carbon;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;
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
        $data_mapel = Mapel::where('tapel_id', $tapel->id)->get();

        $title = 'Data Kelas';
        $data_kelas = Kelas::where('tapel_id', $tapel->id)->orderBy('tingkatan_id', 'ASC')->get();

        foreach ($data_kelas as $kelas) {
            $jumlah_anggota =  AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
                ->where('anggota_kelas.kelas_id', $kelas->id)
                ->where('siswa.status', 1)
                ->orderBy('siswa.nama_lengkap', 'ASC')
                ->count();
            $kelas->jumlah_anggota = $jumlah_anggota;
        }

        $data_guru = Guru::orderBy('id', 'ASC')->get();
        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
        $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();

        $jumlah_kelas_play_group = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '1')
            ->count();
        $jumlah_kelas_kinder_garten_a = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '2')
            ->count();
        $jumlah_kelas_kinder_garten_b = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '3')
            ->count();
        $jumlah_kelas_primary_school = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '4')
            ->count();
        $jumlah_kelas_junior_high_school = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '5')
            ->count();
        $jumlah_kelas_senior_high_school = Kelas::where('tapel_id', $tapel->id)
            ->where('tingkatan_id', '6')
            ->count();

        return view('guru.md.kelas.index', compact('title', 'data_kelas', 'tapel', 'data_guru', 'data_tingkatan', 'data_jurusan', 'jumlah_kelas_play_group', 'jumlah_kelas_kinder_garten_a', 'jumlah_kelas_kinder_garten_b', 'jumlah_kelas_primary_school', 'jumlah_kelas_junior_high_school', 'jumlah_kelas_senior_high_school'));
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

        // if (!preg_match('/[a-zA-Z]/', $request->nama_kelas) || !preg_match('/\d/', $request->nama_kelas)) {
        //     return back()->with('toast_error', 'Nama kelas harus mengandung setidaknya satu huruf dan satu angka')->withInput();
        // }

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
        $kelas = Kelas::findorfail($id);
        $data_kelas = Kelas::where('tingkatan_id', $kelas->tingkatan_id)->get();
        $anggota_kelas = AnggotaKelas::where('kelas_id', $id)
            ->orderBy('id', 'DESC')
            ->whereHas('siswa', function ($query) {
                $query->where('status', 1);
            })
            ->get();
        $siswa_belum_masuk_kelas = Siswa::where('status', 1)->where('kelas_id', null)->get();

        foreach ($siswa_belum_masuk_kelas as $belum_masuk_kelas) {
            $kelas_sebelumhya = AnggotaKelas::where('siswa_id', $belum_masuk_kelas->id)->orderBy('id', 'DESC')->first();
            if (is_null($kelas_sebelumhya)) {
                $belum_masuk_kelas->kelas_sebelumhya = null;
            } else {
                $belum_masuk_kelas->kelas_sebelumhya = $kelas_sebelumhya->kelas->nama_kelas;
            }
        }
        return view('guru.md.kelas.show', compact('title', 'kelas', 'data_kelas', 'anggota_kelas', 'siswa_belum_masuk_kelas'));
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
                    'kelas_id'  => $request->kelas_id,
                    'pendaftaran'  => $request->pendaftaran,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $insert_data[] = $data;

                $siswa = Siswa::find($siswa_id[$count]);
                if ($siswa->kelas_masuk == null && $siswa->tahun_masuk == null && $siswa->semester_masuk == null) {
                    $siswa->update([
                        'kelas_masuk' => $kelas->nama_kelas,
                        'tahun_masuk' => Carbon::now()->year,
                        'semester_masuk' => $tingkatan->semester_id,
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

        return view('guru.md.kelas.trash', compact('title', 'anggotaKelasTrashed'));
    }
}
