<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    public function index()
    {
        $title = 'Data Jurusan';

        $data_jurusan = Jurusan::orderBy('id', 'ASC')->get();

        return view('admin.jurusan.index', compact('title', 'data_jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $jurusan->update($request->all());

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findorfail($id);
        try {
            $jurusan->forceDelete();
            return back()->with('toast_success', 'Jurusan berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_warning', 'Jurusan ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
