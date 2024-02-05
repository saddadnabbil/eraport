<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UnitKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitKaryawanController extends Controller
{
    public function index()
    {
        $title = 'Unit Karyawan';
        $dataUnitKaryawan = UnitKaryawan::all();

        return view('admin.karyawan.unit.index', compact('title', 'dataUnitKaryawan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_kode' => 'required|string|max:255|unique:unit_karyawans',
            'unit_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            UnitKaryawan::create($request->all());

            return back()->with('success', 'Unit Karyawan berhasil ditambahkan.');
        }
    }

    public function update(Request $request, UnitKaryawan $UnitKaryawan)
    {
        $validator = Validator::make($request->all(), [
            'unit_nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $UnitKaryawan->update([
                'unit_nama' => $request->unit_nama,
            ]);

            return back()->with('success', 'Unit Karyawan berhasil diperbarui.');
        }
    }

    public function destroy($id)
    {
        $UnitKaryawan = UnitKaryawan::findorfail($id);
        try {
            $UnitKaryawan->forceDelete();
            return back()->with('toast_success', 'Unit Karyawan berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Unit Karyawan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
