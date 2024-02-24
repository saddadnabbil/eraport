<?php

namespace App\Http\Controllers\Admin;

use App\Models\StatusKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StatusKaryawanController extends Controller
{
    public function index()
    {
        $title = 'Status Karyawan';
        $dataStatusKaryawan = StatusKaryawan::all();

        return view('admin.karyawan.status.index', compact('title', 'dataStatusKaryawan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_kode' => 'required|string|max:255|unique:status_karyawans',
            'status_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            StatusKaryawan::create($request->all());

            return back()->with('success', 'Status Karyawan berhasil ditambahkan.');
        }
    }

    public function update(Request $request, StatusKaryawan $statusKaryawan)
    {
        $validator = Validator::make($request->all(), [
            'status_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $statusKaryawan->update([
                'status_nama' => $request->status_nama,
            ]);

            return back()->with('success', 'Status Karyawan berhasil diperbarui.');
        }
    }

    public function destroy($id)
    {
        $statusKaryawan = StatusKaryawan::findorfail($id);
        try {
            $statusKaryawan->forceDelete();
            return back()->with('toast_success', 'Status Karyawan berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Status Karyawan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
