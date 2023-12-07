<?php

namespace App\Http\Controllers\Admin;

use App\Kelas;
use App\Mapel;
use App\Tapel;
use App\Sekolah;
use App\Silabus;
use App\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $tapel = Tapel::findorfail(session()->get('tapel_id'));

        $mapel    = Mapel::all();
        $id_kelas = Kelas::where('tapel_id', session()->get('tapel_id'))->get('id');

        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        $data_pembelajaran = Pembelajaran::whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        $kelas = Kelas::whereIn('id', $data_pembelajaran->pluck('kelas_id'))
            ->orderBy('nama_kelas', 'ASC')
            ->get();

        $mapel = Mapel::whereIn('id', $data_pembelajaran->pluck('mapel_id'))
            ->orderBy('nama_mapel', 'ASC')
            ->get();

        foreach ($data_pembelajaran as $data_silabus_filtered) {
            $data_pembelajaran = $data_silabus_filtered;

            $data_silabus = $data_silabus_filtered->silabus;

            // dd($data_silabus);
        }

        return view('admin.silabus.index', compact('title', 'data_silabus', 'kelas', 'mapel', 'data_pembelajaran'));
    }

    public function indexGuru()
    {
        $kelas    = Kelas::all();
        $mapel    = Mapel::all();
        $data_silabus = Silabus::with('kelas', 'mapel')->orderBy('kelas_id', 'asc')->get();
        return view('guru.silabus', compact('data_silabus', 'kelas', 'mapel'));
    }

    public function indexSiswa()
    {
        $kelas    = Kelas::all();
        $mapel    = Mapel::all();
        $data_silabus = Silabus::with('kelas', 'mapel')->orderBy('kelas_id', 'asc')->get();
        return view('siswa.silabus', compact('data_silabus', 'kelas', 'mapel'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'kelas_id'           => 'required',
            'pembelajaran_id'    => 'required',
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
                'pembelajaran_id' => $request->pembelajaran_id,
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
            'pembelajaran_id' => 'required',
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
        $data->mapel_id = $request->input('pembelajaran_id');

        if ($request->hasFile('k_tigabelas')) {
            $newK_tigabelas = $this->moveToPublic($request->file('k_tigabelas'));
            $data->k_tigabelas = $newK_tigabelas;
            Storage::delete('public/' . $oldK_tigabelas);
        }

        if ($request->hasFile('cambridge')) {
            $newCambridge = $this->moveToPublic($request->file('cambridge'));
            $data->cambridge = $newCambridge;
            Storage::delete('public/' . $oldCambridge);
        }

        if ($request->hasFile('edexcel')) {
            $newEdexcel = $this->moveToPublic($request->file('edexcel'));
            $data->edexcel = $newEdexcel;
            Storage::delete('public/' . $oldEdexcel);
        }

        if ($request->hasFile('book_indo_siswa')) {
            $newBookIndoSiswa = $this->moveToPublic($request->file('book_indo_siswa'));
            $data->book_indo_siswa = $newBookIndoSiswa;
            Storage::delete('public/' . $oldBookIndoSiswa);
        }

        if ($request->hasFile('book_english_siswa')) {
            $newBookEnglishSiswa = $this->moveToPublic($request->file('book_english_siswa'));
            $data->book_english_siswa = $newBookEnglishSiswa;
            Storage::delete('public/' . $oldBookEnglishSiswa);
        }

        if ($request->hasFile('book_indo_guru')) {
            $newBookIndoGuru = $this->moveToPublic($request->file('book_indo_guru'));
            $data->book_indo_guru = $newBookIndoGuru;
            Storage::delete('public/' . $oldBookIndoGuru);
        }

        if ($request->hasFile('book_english_guru')) {
            $newBookEnglishGuru = $this->moveToPublic($request->file('book_english_guru'));
            $data->book_english_guru = $newBookEnglishGuru;
            Storage::delete('public/' . $oldBookEnglishGuru);
        }

        $data->save();

        return back()->with('toast_success', 'Data silabus berhasil diedit!');
    }

    public function destroy($id)
    {
        $data = Silabus::findOrFail($id);
        if ($data->delete()) {
            \Storage::delete('public/' . $data->k_tigabelas);
            \Storage::delete('public/' . $data->cambridge);
            \Storage::delete('public/' . $data->edexcel);
            \Storage::delete('public/' . $data->moe);
            \Storage::delete('public/' . $data->book_indo_siswa);
            \Storage::delete('public/' . $data->book_english_siswa);
            \Storage::delete('public/' . $data->book_indo_guru);
            \Storage::delete('public/' . $data->book_english_guru);
            return back()->with('toast_success', 'Silabus berhasil dihapus');
        }
    }

    public function moveToPublic($file)
    {
        if ($file) {
            $fileName = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $file->getClientOriginalName();
            $destination = storage_path('app/public/silabus');
            $file->move($destination, $fileName);

            return $fileName;
        }

        return null;
    }
}
