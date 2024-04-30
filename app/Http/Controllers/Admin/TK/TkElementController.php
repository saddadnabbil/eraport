<?php

namespace App\Http\Controllers\Admin\TK;

use App\Models\Tapel;
use App\Models\TkElement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tingkatan;
use Illuminate\Support\Facades\Validator;

class TkElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pilih tingkatan';
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();

        return view('admin.tk.element.pilihtingkatan', compact('title', 'data_tingkatan'));
    }

    public function create(Request $request)
    {
        $title = 'Element ';
        $data_element = TkElement::where('tingkatan_id', $request->tingkatan_id)->get();
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();
        $tingkatan_id = Tingkatan::findorfail($request->tingkatan_id)->id;


        return view('admin.tk.element.index', compact('title', 'data_element', 'data_tingkatan', 'tingkatan_id'));
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
            'name' => 'required|string|max:255',
            'tingkatan_id' => 'required|exists:tingkatans,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        TkElement::create($request->all());

        return back()->with('success', 'Element berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tingkatan_id' => 'required|exists:tingkatans,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        // Find the Karyawan instance by ID
        $tkElement = TkElement::findOrFail($id);

        $tkElement->update([
            'name' => $request->name,
            'tingkatan_id' => $request->tingkatan_id,
        ]);

        return back()->with('success', 'Element berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tkElement = TkElement::findorfail($id);
        try {
            $tkElement->forceDelete();
            return back()->with('toast_success', 'Element berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Element ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
