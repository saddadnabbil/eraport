<?php

namespace App\Http\Controllers\Guru\MD;

use App\Models\Term;
use App\Models\Tapel;
use App\Models\Semester;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTingkatanRequest;
use App\Http\Requests\UpdateTingkatanRequest;

class TingkatanController extends Controller
{
    public function index()
    {
        $title = 'Level Data';
        $tapel = Tapel::where('status', 1)->first();

        $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
        $data_sekolah = Sekolah::orderBy('id', 'ASC')->get();

        return view('guru.md.tingkatan.index', compact('title', 'data_tingkatan', 'data_sekolah', 'tapel'));
    }

    public function store(StoreTingkatanRequest $request): RedirectResponse
    {
        Tingkatan::create($request->all());

        return redirect()->back()->with('success', 'Level added successfully.');
    }

    public function update(UpdateTingkatanRequest $request, Tingkatan $tingkatan)
    {
        $tingkatan->update($request->all());

        return redirect()->back()->with('success', 'Level updated successfully.');
    }

    public function destroy($id)
    {
        $tingkatan = Tingkatan::findorfail($id);
        try {
            $tingkatan->forceDelete();
            return back()->with('toast_success', 'Level deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Level cannot be deleted because it has related data');
        }
    }
}
