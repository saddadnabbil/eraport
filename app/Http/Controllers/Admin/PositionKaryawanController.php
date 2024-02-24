<?php

namespace App\Http\Controllers\Admin;

use App\Models\PositionKaryawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PositionKaryawanController extends Controller
{
    public function index()
    {
        $title = 'Position Karyawan';
        $dataPositionKaryawan = PositionKaryawan::all();

        return view('admin.karyawan.position.index', compact('title', 'dataPositionKaryawan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position_kode' => 'required|string|max:255|unique:position_karyawans',
            'position_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            PositionKaryawan::create([
                'position_kode' => $request->position_kode,
                'position_nama' => $request->position_nama,
            ]);

            return back()->with('success', 'Position Karyawan berhasil ditambahkan.');
        }
    }

    public function update(Request $request, PositionKaryawan $PositionKaryawan)
    {
        $validator = Validator::make($request->all(), [
            'position_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $PositionKaryawan->update([
                'position_nama' => $request->position_nama,
            ]);

            return back()->with('success', 'Position Karyawan berhasil diperbarui.');
        }
    }

    public function destroy($id)
    {
        $PositionKaryawan = PositionKaryawan::findorfail($id);
        try {
            $PositionKaryawan->forceDelete();
            return back()->with('toast_success', 'Position Karyawan berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Position Karyawan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
