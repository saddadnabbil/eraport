<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tapel;
use App\Models\TkElement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $title = 'Element ';
        $data_element = TkElement::get();

        return view('admin.tk.element.index', compact('title', 'data_element'));
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
