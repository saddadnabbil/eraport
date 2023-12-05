<?php

namespace App\Http\Controllers\Admin;

use App\Tingkatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TingkatanController extends Controller
{
    public function index()
    {
        $title = 'Data Tingkatan';

        $data_tingkatan = Tingkatan::orderBy('id', 'DESC')->get();

        return view('admin.tingkatan.index', compact('title', 'data_tingkatan'));
    }

    public function create()
    {
        return view('tingkatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tingkatan' => 'required|string|max:255',
        ]);

        Tingkatan::create($request->all());

        return redirect()->route('tingkatan.index')->with('success', 'Tingkatan berhasil ditambahkan.');
    }

    public function edit(Tingkatan $tingkatan)
    {
        return view('tingkatan.edit', compact('tingkatan'));
    }

    public function update(Request $request, Tingkatan $tingkatan)
    {
        $request->validate([
            'nama_tingkatan' => 'required|string|max:255',
        ]);

        $tingkatan->update($request->all());

        return redirect()->route('tingkatan.index')->with('success', 'Tingkatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tingkatan = Tingkatan::findorfail($id);
        try {
            $tingkatan->delete();
            return back()->with('toast_success', 'Tingkatan berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Tingkatan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
