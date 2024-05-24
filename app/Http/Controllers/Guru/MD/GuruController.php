<?php

namespace App\Http\Controllers\Guru\MD;

use Excel;
use App\Models\Guru;
use App\Models\User;
use App\Exports\GuruExport;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Teacher Data';
        $data_guru = Guru::orderBy('id', 'ASC')->get();
        return view('guru.md.guru.index', compact('title', 'data_guru'));
    }

    public function data()
    {
        $dataGuru = Guru::orderBy('id', 'ASC')->get();

        return DataTables::of($dataGuru)
            ->addColumn('full_name', function ($guru) {
                return $guru->karyawan->nama_lengkap;
            })
            ->addColumn('unit_nama', function ($guru) {
                return $guru->karyawan->unitKaryawan->unit_nama;
            })
            ->addColumn('employee_code', function ($guru) {
                return $guru->karyawan->kode_karyawan;
            })
            ->addColumn('identity_card', function ($guru) {
                return $guru->karyawan->nik;
            })
            ->addColumn('number_phone', function ($guru) {
                return $guru->karyawan->nomor_phone;
            })
            ->addColumn('gender', function ($guru) {
                return $guru->jenis_kelamin == 'L' ? 'Male' : 'Female';
            })
            ->addColumn('action', function ($guru) {
                return '<a href="' . route('guru.karyawan.show', $guru->karyawan->id) . '" class="btn btn-info btn-sm mt-1"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['action']) // Untuk menginterpretasikan HTML dalam kolom action
            ->toJson();
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
            'nama_lengkap' => 'required|min:3|max:100|unique:guru',
            'gelar' => 'nullable|min:3|max:10',
            'nip' => 'nullable|digits:18|unique:guru',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|min:3',
            'tanggal_lahir' => 'required',
            'nuptk' => 'nullable|digits:16|unique:guru',
            'alamat' => 'required|min:4|max:255',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            try {
                $user = new User([
                    'username' => strtolower(str_replace(' ', '', $request->nama_lengkap)),
                    'password' => bcrypt('123456'),
                    'status' => true,
                ]);
                // assign role with spatie
                $user->assignRole('Teacher');
                $user->assignPermission('teacher');
                $user->save();
            } catch (\Throwable $th) {
                return back()->with('toast_error', 'Username telah digunakan');
            }

            $guru = new Guru([
                'user_id' => $user->id,
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'gelar' => $request->gelar,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nuptk' => $request->nuptk,
                'alamat' => $request->alamat,
                'avatar' => 'default.png',
            ]);
            $guru->save();
            return back()->with('toast_success', 'Teacher Data berhasil ditambahkan');
        }
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
            'gelar' => 'nullable|min:3|max:10',
            'nip' => 'nullable|digits:18',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|min:3',
            'tanggal_lahir' => 'required',
            'nuptk' => 'nullable|digits:16',
            'alamat' => 'required|min:4|max:255',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            $guru = Guru::findorfail($id);
            $data_guru = [
                'gelar' => $request->gelar,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nuptk' => $request->nuptk,
                'alamat' => $request->alamat,
            ];

            $guru->update($data_guru);
            return back()->with('toast_success', 'Teacher Data berhasil diedit');
        }
    }

    public function export()
    {
        $filename = 'data_guru ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new GuruExport(), $filename);
    }

    public function format_import()
    {
        $file = public_path() . '/format_import/format_import_guru.xls';
        $headers = ['Content-Type: application/xls'];
        return Response::download($file, 'format_import_guru ' . date('Y-m-d H_i_s') . '.xls', $headers);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new GuruImport(), $request->file('file_import'));
            return back()->with('toast_success', 'Teacher Data berhasil diimport');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Maaf, format data tidak sesuai');
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
        $guru = Guru::findOrFail($id);

        try {
            $guru->update([
                'status' => 0
            ]);
            $guru->delete();

            $guru->user->update([
                'status' => 0
            ]);
            $guru->user->delete();

            return back()->with('toast_success', 'Guru & User berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus Guru.');
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
        $guru = Guru::withTrashed()->findOrFail($id);

        try {
            // Permanent delete the Guru and its User record
            $guru->user->forceDelete();
            $guru->forceDelete();

            return back()->with('toast_success', 'Guru & User berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus Guru secara permanen.');
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
            $guru = Guru::withTrashed()->findOrFail($id);

            // Restore the Guru record and related AnggotaKelas records
            $guru->restoreGuru();

            return back()->with('toast_success', 'Guru & User berhasil direstorasi');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi Guru.');
        }
    }

    public function showTrash()
    {
        $title = "Data Trash Guru";
        $guruTrashed = Guru::onlyTrashed()->get();

        return view('guru.md.guru.trash', compact('title', 'guruTrashed'));
    }
}
