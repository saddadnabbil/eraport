<?php

namespace App\Http\Controllers\Admin;

use App\AnggotaKelas;
use App\CatatanWaliKelas;
use App\Guru;
use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Kelas;
use App\Mapel;
use App\Siswa;
use App\Tapel;
use App\Tingkatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        if (count($data_mapel) == 0) {
            return redirect('admin/mapel')->with('toast_warning', 'Mohon isikan data mata pelajaran');
        } else {
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

            $data_guru = Guru::orderBy('nama_lengkap', 'ASC')->get();
            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
            $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();

            return view('admin.kelas.index', compact('title', 'data_kelas', 'tapel', 'data_guru', 'data_tingkatan', 'data_jurusan'));
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
        $validator = Validator::make($request->all(), [
            'tingkatan_id' => 'required',
            'jurusan_id' => 'required',
            'nama_kelas' => 'required|min:2|max:30',
            'guru_id' => 'required',
        ]);

        $tingkatan = Tingkatan::find($request->tingkatan_id);
        $jurusan = Jurusan::find($request->jurusan_id);

        if ($tingkatan->id != '5' && ($jurusan->id == '1' || $jurusan->id == '2')) {
            return back()->with('toast_error', $tingkatan->nama_tingkatan . ' Tidak boleh mengambil jurusan ' . $jurusan->nama_jurusan)->withInput();
        }

        if (!preg_match('/[a-zA-Z]/', $request->nama_kelas) || !preg_match('/\d/', $request->nama_kelas)) {
            return back()->with('toast_error', 'Nama kelas harus mengandung setidaknya satu huruf dan satu angka')->withInput();
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
        $kelas = Kelas::findorfail($id);
        $anggota_kelas = AnggotaKelas::join('siswa', 'anggota_kelas.siswa_id', '=', 'siswa.id')
            ->where('anggota_kelas.kelas_id', $id)
            ->where('siswa.status', 1)
            ->orderBy('siswa.nama_lengkap', 'ASC')
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
        return view('admin.kelas.show', compact('title', 'kelas', 'anggota_kelas', 'siswa_belum_masuk_kelas'));
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

        if ($tingkatan->id != '5' && ($jurusan->id == '1' || $jurusan->id == '2')) {
            return back()->with('toast_error', $tingkatan->nama_tingkatan . ' Tidak boleh mengambil jurusan ' . $jurusan->nama_jurusan)->withInput();
        }

        if (!preg_match('/[a-zA-Z]/', $request->nama_kelas) || !preg_match('/\d/', $request->nama_kelas)) {
            return back()->with('toast_error', 'Nama kelas harus mengandung setidaknya satu huruf dan satu angka')->withInput();
        }

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
            for ($count = 0; $count < count($siswa_id); $count++) {
                $data = array(
                    'siswa_id' => $siswa_id[$count],
                    'kelas_id'  => $request->kelas_id,
                    'pendaftaran'  => $request->pendaftaran,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                );
                $insert_data[] = $data;
            }

            AnggotaKelas::insert($insert_data);
            Siswa::whereIn('id', $siswa_id)->update(['kelas_id' => $request->input('kelas_id')]);
            return back()->with('toast_success', 'Anggota kelas berhasil ditambahkan');
        }
    }

    public function delete_anggota($id)
    {
        try {
            $anggota_kelas = AnggotaKelas::findorfail($id);
            $siswa = Siswa::findorfail($anggota_kelas->siswa_id);
            $catatan_walikelas = CatatanWaliKelas::findorfail($anggota_kelas->id);

            $update_kelas_id = [
                'kelas_id' => null,
            ];

            $catatan_walikelas->delete();
            $siswa->update($update_kelas_id);
            $anggota_kelas->delete();
            return back()->with('toast_success', 'Anggota kelas berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Anggota kelas tidak dapat dihapus');
        }
    }
}
