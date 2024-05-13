<?php

namespace App\Http\Controllers\Admin\TK;

use App\Models\Term;
use App\Models\TkPoint;
use App\Models\TkTopic;
use App\Models\Tingkatan;
use App\Models\TkElement;
use App\Models\TkSubtopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TkPointController extends Controller
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
        $data_term = Term::orderBy('id', 'ASC')->get();

        return view('admin.tk.point.pilihtingkatan', compact('title', 'data_tingkatan', 'data_term'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tingkatan_id' => 'required|exists:tingkatans,id',
            'term_id' => 'required|exists:terms,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }
        $title = 'Point';
        $data_element = TkElement::where('tingkatan_id', $request->tingkatan_id)->get();
        $data_topic = TkTopic::whereIn('tk_element_id', $data_element->pluck('id'))->get();
        $data_subtopic = TkSubtopic::WhereIn('tk_topic_id', $data_topic->pluck('id'))->get();
        $data_point = TkPoint::WhereIn('tk_topic_id', $data_topic->pluck('id'))->orderBy('tk_topic_id')->where('term_id', $request->term_id)->orderBy('id')->get();

        $data_tingkatan = Tingkatan::whereIn('id', [1, 2, 3])->get();
        $tingkatan_id = Tingkatan::findorfail($request->tingkatan_id)->id;
        $data_term = Term::orderBy('id', 'ASC')->get();
        $term_id = Term::findorfail($request->term_id)->id;

        return view('admin.tk.point.index', compact('title', 'data_point', 'data_subtopic', 'data_topic', 'data_tingkatan', 'tingkatan_id', 'data_term', 'term_id'));
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
            'tk_subtopic_id' => 'nullable|exists:tk_subtopics,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        TkPoint::create($request->all());

        return back()->with('success', 'Point berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tk_topic_id' => 'required|exists:tk_subtopics,id',
            'tk_subtopic_id' => 'nullable|exists:tk_subtopics,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $tkPoint = TkPoint::findOrFail($id);

        $tkPoint->update([
            'tk_topic_id' => $request->tk_topic_id,
            'tk_subtopic_id' => $request->tk_subtopic_id,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Point berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tkPoint = TkPoint::findorfail($id);
        try {
            $tkPoint->forceDelete();
            return back()->with('toast_success', 'Point berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Point ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
