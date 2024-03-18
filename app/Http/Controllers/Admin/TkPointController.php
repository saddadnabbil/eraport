<?php

namespace App\Http\Controllers\Admin;

use App\Models\TkPoint;
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
        $title = 'Point';
        $data_subtopic = TkSubtopic::get();
        $data_topic = TkSubtopic::get();
        $data_point = TkPoint::get();

        return view('admin.tk.point.index', compact('title', 'data_point', 'data_subtopic', 'data_topic'));
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
            'tk_subtopic_id' => 'required|exists:tk_subtopics,id',
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
            'tk_subtopic_id' => 'required|exists:tk_subtopics,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        $tkPoint = TkPoint::findOrFail($id);

        $tkPoint->update([
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
