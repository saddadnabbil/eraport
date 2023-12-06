<?php

namespace App\Http\Controllers\Admin;

use App\Kelas;
use App\Mapel;
use App\Sekolah;
use App\Silabus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class SilabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Silabus';
        $kelas    = Kelas::all();
        $mapel    = Mapel::all();
        $data_silabus = Silabus::with('kelas', 'mapel')->orderBy('kelas_id', 'asc')->get();

        return view('admin.silabus.index', compact('title', 'data_silabus', 'kelas', 'mapel'));
    }


public function store(Request $request)
{
    $this->validate($request, [
        'kelas_id'           => 'required',
        'mapel_id'           => 'required',
        'k_tigabelas'        => 'nullable|mimes:pdf',
        'cambridge'          => 'nullable|mimes:pdf',
        'edexcel'            => 'nullable|mimes:pdf',
        'book_indo_siswa'    => 'nullable|mimes:pdf',
        'book_english_siswa' => 'nullable|mimes:pdf',
        'book_indo_guru'     => 'nullable|mimes:pdf',
        'book_english_guru'  => 'nullable|mimes:pdf',
    ]);

    $k_tigabelas = $this->moveToPublic($request->file('k_tigabelas'));
    $cambridge = $this->moveToPublic($request->file('cambridge'));
    $edexcel = $this->moveToPublic($request->file('edexcel'));
    $book_indo_siswa = $this->moveToPublic($request->file('book_indo_siswa'));
    $book_english_siswa = $this->moveToPublic($request->file('book_english_siswa'));
    $book_indo_guru = $this->moveToPublic($request->file('book_indo_guru'));
    $book_english_guru = $this->moveToPublic($request->file('book_english_guru'));

    Silabus::Create(
        [
            'id' => $request->id,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'k_tigabelas' => $k_tigabelas,
            'cambridge' => $cambridge,
            'edexcel' => $edexcel,
            'book_indo_siswa' => $book_indo_siswa,
            'book_english_siswa' => $book_english_siswa,
            'book_indo_guru' => $book_indo_guru,
            'book_english_guru' => $book_english_guru,
        ]
    );

    return redirect()->back()->with('toast_success', 'Data syllabus berhasil ditambahkan!');
}

    /**
     * move file to public silabus
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $data = Silabus::findOrFail($id);
        
        $this->validate($request, [
            'kelas_id' => 'required',
            'mapel_id' => 'required',
            'k_tigabelas' => 'nullable|mimes:pdf',
            'cambridge' => 'nullable|mimes:pdf',
            'edexcel' => 'nullable|mimes:pdf',
            'book_indo_siswa' => 'nullable|mimes:pdf',
            'book_english_siswa' => 'nullable|mimes:pdf',
            'book_indo_guru' => 'nullable|mimes:pdf',
            'book_english_guru' => 'nullable|mimes:pdf',
        ]);

        $oldK_tigabelas = $data->k_tigabelas;
        $oldCambridge = $data->cambridge;
        $oldEdexcel = $data->edexcel;
        $oldBookIndoSiswa = $data->book_indo_siswa;
        $oldBookEnglishSiswa = $data->book_english_siswa;
        $oldBookIndoGuru = $data->book_indo_guru;
        $oldBookEnglishGuru = $data->book_english_guru;

        $data->kelas_id = $request->input('kelas_id');
        $data->mapel_id = $request->input('mapel_id');

        if ($request->hasFile('k_tigabelas')) {
            $newK_tigabelas = $this->moveToPublic($request->k_tigabelas);
            $data->k_tigabelas = $newK_tigabelas;
            \File::delete(public_path('img/k_tigabelas/' . $oldK_tigabelas));
        }

        if ($request->hasFile('cambridge')) {
            $newCambridge = $this->moveToPublic($request->cambridge);
            // dd($newCambridge);
            $data->cambridge = $newCambridge;
            \File::delete(public_path('img/cambridge/' . $oldCambridge));
        }

        if ($request->hasFile('edexcel')) {
            $newEdexcel = $this->moveToPublic($request->edexcel);
            // dd($newEdexcel);
            $data->edexcel = $newEdexcel;
            \File::delete(public_path('img/edexcel/' . $oldEdexcel));
        }

        if ($request->hasFile('book_indo_siswa')) {
            $newBookIndoSiswa = $this->moveToPublic($request->book_indo_siswa);
            $data->book_indo_siswa = $newBookIndoSiswa;
            \File::delete(public_path('img/syllabus/' . $oldBookIndoSiswa));
        }

        if ($request->hasFile('book_english_siswa')) {
            $newBookEnglishSiswa = $this->moveToPublic($request->book_english_siswa);
            $data->book_english_siswa = $newBookEnglishSiswa;
            \File::delete(public_path('img/syllabus/' . $oldBookEnglishSiswa));
        }

        if ($request->hasFile('book_indo_guru')) {
            $newBookIndoGuru = $this->moveToPublic($request->book_indo_guru);
            $data->book_indo_guru = $newBookIndoGuru;
            \File::delete(public_path('img/syllabus/' . $oldBookIndoGuru));
        }

        if ($request->hasFile('book_english_guru')) {
            $newBookEnglishGuru = $this->moveToPublic($request->book_english_guru);
            $data->book_english_guru = $newBookEnglishGuru;
            \File::delete(public_path('img/syllabus/' . $oldBookEnglishGuru));
        }

        $data->save();

        return back()->with('toast_success', 'Data silabus berhasil diedit!');
    }

    public function destroy($id)
    {
        $data = Silabus::findOrFail($id);
        if ($data->destroy($id)) {
            \File::delete(public_path('img/silabus/' . $data->k_tigabelas));
            \File::delete(public_path('img/silabus/' . $data->cambridge));
            \File::delete(public_path('img/silabus/' . $data->edexcel));
            \File::delete(public_path('img/silabus/' . $data->moe));
            \File::delete(public_path('img/silabus/' . $data->book_indo_siswa));
            \File::delete(public_path('img/silabus/' . $data->book_english_siswa));
            \File::delete(public_path('img/silabus/' . $data->book_indo_guru));
            \File::delete(public_path('img/silabus/' . $data->book_english_guru));
            return back()->with('toast_success', 'Silabus berhasil dihapus');
        }
    }

    public function moveToPublic($file)
    {
        if ($file) {
            $fileName = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $file->getClientOriginalName();
            $destination = public_path('img/silabus');
            $file->move($destination, $fileName);
    
            return $fileName;
        }
    
        return null;
    }
}
