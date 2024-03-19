<?php

namespace App\Http\Controllers\Admin;

use App\Models\TkTopic;
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
        $title = 'Topic';
        $data_topic = TkTopic::get();
        $data_element = TkElement::get();

        return view('admin.tk.topic.index', compact('title', 'data_topic', 'data_element'));
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
