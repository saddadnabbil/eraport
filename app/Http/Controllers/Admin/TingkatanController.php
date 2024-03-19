<?php

namespace App\Http\Controllers\Admin;

use App\Models\Term;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TingkatanController extends Controller
{
    public function index()
    {
        $title = 'Data Tingkatan';
        $tapel = Tapel::where('status', 1)->first();

        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();

        return view('admin.tingkatan.index', compact('title', 'data_tingkatan', 'tapel'));
    }

    public function create()
    {
        return view('tingkatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tingkatan' => 'required|string|max:255',
            'term_id' => 'required|exists:terms,id',
            'semester_id' => 'required|exists:semesters,id',
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
            $tingkatan->forceDelete();
            return back()->with('toast_success', 'Tingkatan berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Tingkatan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
