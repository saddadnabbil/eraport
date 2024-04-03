<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\TkTopic;
use App\Models\Tingkatan;
use App\Models\TkElement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TkTopicController extends Controller
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
        $data_guru = Guru::join('karyawans', 'karyawans.id', '=', 'guru.karyawan_id')
            ->join('unit_karyawans', 'unit_karyawans.id', '=', 'karyawans.unit_karyawan_id')
            ->where('unit_karyawans.unit_kode', 'G01')->get();

        return view('admin.tk.topic.pilihtingkatan', compact('title', 'data_tingkatan'));
    }

    public function create(Request $request)
    {
        $title = 'Topic';
        $data_element = TkElement::where('tingkatan_id', $request->tingkatan_id)->get();
        $data_topic = TkTopic::whereIn('tk_element_id', $data_element->pluck('id'))->get();
        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();
        $tingkatan_id = Tingkatan::findorfail($request->tingkatan_id)->id;

        $data_guru = Guru::with(['karyawan' => function ($query) {
            $query->whereHas('unitKaryawan', function ($subquery) {
                $subquery->where('unit_kode', 'G01');
            });
        }])->where('deleted_at', null)->get();

        return view('admin.tk.topic.index', compact('title', 'data_topic', 'data_element', 'data_tingkatan', 'tingkatan_id', 'data_guru'));
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
            'tk_element_id' => 'required|exists:tk_elements,id',
            'guru_id' => 'required|exists:guru,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        TkTopic::create($request->all());

        return back()->with('success', 'Topic berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tk_element_id' => 'required|exists:tk_elements,id',
            'guru_id' => 'required|exists:guru,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $tkTopic = TkTopic::findOrFail($id);

        $tkTopic->update([
            'name' => $request->name,
            'tk_element_id' => $request->tk_element_id,
            'guru_id' => $request->guru_id,
        ]);

        return back()->with('success', 'Topic berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tkTopic = TkTopic::findorfail($id);
        try {
            $tkTopic->forceDelete();
            return back()->with('toast_success', 'Topic berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Topic ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
