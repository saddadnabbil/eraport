<?php

namespace App\Http\Controllers\Admin\TK;

use App\Models\TkTopic;
use App\Models\Tingkatan;
use App\Models\TkElement;
use App\Models\TkSubtopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TkSubtopicController extends Controller
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

        return view('admin.tk.subtopic.pilihtingkatan', compact('title', 'data_tingkatan'));
    }

    public function create(Request $request)
    {
        $title = 'Sub Topic';
        $data_topic = TkTopic::get();
        $data_element = TkElement::where('tingkatan_id', $request->tingkatan_id)->get();
        $data_topic = TkTopic::whereIn('tk_element_id', $data_element->pluck('id'))->get();
        $data_subtopic = TkSubtopic::WhereIn('tk_topic_id', $data_topic->pluck('id'))->get();

        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();
        $tingkatan_id = Tingkatan::findorfail($request->tingkatan_id)->id;

        return view('admin.tk.subtopic.index', compact('title', 'data_topic', 'data_subtopic', 'data_tingkatan', 'tingkatan_id'));
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
            'tk_topic_id' => 'required|exists:tk_topics,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        TkSubtopic::create($request->all());

        return back()->with('success', 'Sub Topic berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tk_topic_id' => 'required|exists:tk_topics,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $tkTopic = TkSubtopic::findOrFail($id);

        $tkTopic->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Sub Topic berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tkTopic = TkSubtopic::findorfail($id);
        try {
            $tkTopic->forceDelete();
            return back()->with('toast_success', 'Sub Topic berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Sub Topic ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
