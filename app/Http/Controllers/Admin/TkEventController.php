<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tapel;
use App\Models\TkEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TkEventController extends Controller
{
    public function index()
    {
        $title = 'Event Data';
        $tapel = Tapel::where('status', 1)->first();

        $data_event = TkEvent::orderBy('id', 'ASC')->get();

        return view('admin.tk.event.index', compact('title', 'data_event', 'tapel'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tapel_id' => 'required|exists:tapels,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        TkEvent::create($request->all());

        return back()->with('success', 'Event berhasil ditambahkan.');
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
        $tkEvent = TkEvent::findOrFail($id);

        $tkEvent->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tkEvent = TkEvent::findorfail($id);
        try {
            $tkEvent->forceDelete();
            return back()->with('toast_success', 'Event berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', 'Event ini gagal dihapus karena memiliki relasi dengan data kelas');
        }
    }
}
