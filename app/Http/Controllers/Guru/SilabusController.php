<?php

// SilabusController.php
namespace App\Http\Controllers\Guru;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Silabus;
use App\Models\AnggotaKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $title = 'Syllabus';
        $tapel = Tapel::findorfail(session()->get('tapel_id'));


        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
        $id_kelas = Kelas::where('tapel_id', $tapel->id)
            ->where('guru_id', $guru->id)
            ->pluck('id');
        $data_pembelajaran = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->orderBy('mapel_id', 'ASC')->orderBy('kelas_id', 'ASC')->get();

        $kelas = Kelas::whereIn('id', $data_pembelajaran->pluck('kelas_id'))
            ->orderBy('nama_kelas', 'ASC')
            ->get();

        $mapel = Mapel::whereIn('id', $data_pembelajaran->pluck('mapel_id'))
            ->orderBy('nama_mapel', 'ASC')
            ->get();

        $data_silabus = $data_pembelajaran->pluck('silabus');

        return view('guru.silabus.index', compact('data_silabus', 'kelas', 'mapel', 'title', 'data_pembelajaran'));
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

        $nama_kelas = Kelas::find($request->input('kelas_id'))->nama_kelas;
        $nama_mapel = Mapel::find($request->input('mapel_id'))->nama_mapel;

        // Check if the combination of kelas_id, mapel_id, and pembelajaran_id already exists
        $existingRecord = Silabus::where('kelas_id', $request->input('kelas_id'))
            ->where('pembelajaran_id', $request->input('pembelajaran_id'))
            ->where('mapel_id', $request->input('mapel_id'))
            ->first();

        if ($existingRecord) {
            return back()->with('toast_error', 'Class ' . $nama_kelas . ' and Subject ' . $nama_mapel . ' ini sudah ada!');
        }

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

        return redirect()->back()->with('toast_success', 'Data silabus berhasil ditambahkan!');
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

        $data = Silabus::findOrFail($id);

        $nama_kelas = Kelas::find($request->input('kelas_id'))->nama_kelas;
        $nama_mapel = Mapel::find($request->input('mapel_id'))->nama_mapel;

        // Check if the combination of kelas_id, mapel_id, and pembelajaran_id already exists
        $existingRecord = Silabus::where('kelas_id', $request->input('kelas_id'))
            ->where('pembelajaran_id', $request->input('pembelajaran_id'))
            ->where('mapel_id', $request->input('mapel_id'))
            ->where('id', '!=', $id)
            ->first();

        if ($existingRecord) {
            return back()->with('toast_error', 'Class ' . $nama_kelas . ' and Subject ' . $nama_mapel . ' ini sudah ada!');
        }

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

    public function destroyFile(Request $request, $id, $fileType)
    {
        $silabus = Silabus::findOrFail($id);

        // Get the file name based on the file type
        $fileName = $silabus->{$fileType};

        // Delete the file from storage
        if ($this->deleteFile($fileName)) {
            // Set the file name to null in the database
            $silabus->{$fileType} = null;
            $silabus->save();

            // Flash a success message
            $request->session()->flash('toast_success', 'File deleted successfully');
            return response()->json(['success' => true]);
        } else {
            // Flash an error message
            $request->session()->flash('toast_error', 'Error deleting file');
            return response()->json(['success' => false]);
        }
    }

    protected function deleteFile($fileName)
    {
        // Assuming your files are stored in the 'public/silabus' directory
        $filePath = public_path('silabus/' . $fileName);

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                return true; // File deleted successfully
            } else {
                return false; // Error deleting file
            }
        } else {
            return true; // File does not exist, consider it deleted
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
