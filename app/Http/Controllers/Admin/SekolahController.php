<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tapel;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Sekolah';
        $sekolahs = Sekolah::get();
        return view('admin.sekolah.index', compact('title', 'sekolahs'));
    }

    public function store(Request $request)
    {
        $tapel = Tapel::where('status', '1')->first();
        $validator = Validator::make(request()->all(), [
            'nama_sekolah' => 'required|min:5|max:100',
            'npsn' => 'required|numeric|digits_between:8,10',
            'nss' => 'nullable|numeric|digits:15',
            'alamat' => 'required|min:10|max:255',
            'kode_pos' => 'required|numeric|digits:5',
            'nomor_telpon' => 'required|numeric|digits_between:5,13',
            'website' => 'nullable|min:5|max:100',
            'email' => 'required|email|min:5|max:35',
            'kepala_sekolah' => 'required|min:3|max:100',
            'nip_kepala_sekolah' => 'required',
            'tdd_kepala_sekolah' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }


        $data_sekolah = [
            'nama_sekolah' => strtoupper($request->nama_sekolah),
            'npsn' => $request->npsn,
            'nss' => $request->nss,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'email' => $request->email,
            'nomor_telpon' => $request->nomor_telpon,
            'website' => $request->website,
            'kepala_sekolah' => strtoupper($request->kepala_sekolah),
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
            'tapel_id' => $tapel->id
        ];
        $sekolah = new Sekolah($data_sekolah);

        $sekolah->save();

        $this->saveUploadedFiles($request, $sekolah);


        return redirect()->back()->with('toast_success', 'Data sekolah berhasil ditambahkan');
    }

    private function saveUploadedFiles(Request $request, Sekolah $sekolah)
    {
        if ($request->hasFile('logo')) {
            $pasPhoto = $request->file('logo');
            $pasPhotoPath = $this->savePhoto($pasPhoto, 'logo', $request->npsn, '.jpg');
            $sekolah->logo = $pasPhotoPath;
        }

        $this->savePhotoField('ttd_kepala_sekolah', $request, $sekolah, $request->nip_kepala_sekolah, '.jpg');

        $sekolah->save();
    }

    private function savePhoto($file, $field, $kepala_sekolah, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $kepala_sekolah . $extension;
        return $file->storeAs($field, $filename, 'public');
    }

    private function savePhotoField($inputName, Request $request, Sekolah $sekolah, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $kodeKaryawan, $extension);
            $sekolah->$inputName = $path;
        }
    }

    public function show($id)
    {
        $title = 'Profil Sekolah';
        $sekolah = Sekolah::findorfail($id);
        return view('admin.sekolah.show', compact('title', 'sekolah'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tapel = Tapel::where('status', 1)->first();
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|min:5|max:100',
            'npsn' => 'required|numeric|digits_between:8,10',
            'nss' => 'nullable|numeric|digits:15',
            'alamat' => 'required|min:10|max:255',
            'kode_pos' => 'required|numeric|digits:5',
            'nomor_telpon' => 'required|numeric|digits_between:5,13',
            'website' => 'nullable|min:5|max:100',
            'email' => 'required|email|min:5|max:35',
            'kepala_sekolah' => 'required|min:3|max:100',
            'nip_kepala_sekolah' => 'required',
            'tdd_kepala_sekolah' => 'nullable|image|max:2048',
            'logo' => 'max:2048|image',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $sekolah = Sekolah::findOrFail($id);
        $data_sekolah = [
            'nama_sekolah' => strtoupper($request->nama_sekolah),
            'npsn' => $request->npsn,
            'nss' => $request->nss,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'email' => $request->email,
            'nomor_telpon' => $request->nomor_telpon,
            'website' => $request->website,
            'kepala_sekolah' => strtoupper($request->kepala_sekolah),
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
            'tapel_id' => $tapel->id
        ];

        $this->updateUploadedFiles($request, $sekolah);

        // Update data sekolah
        $sekolah->update($data_sekolah);

        return back()->with('toast_success', 'Data sekolah berhasil diedit');
    }

    private function updateUploadedFiles(Request $request, Sekolah $sekolah)
    {
        if ($request->hasFile('logo')) {
            $this->deletePhoto($sekolah->logo); // Hapus foto lama sebelum menyimpan yang baru
            $logo = $request->file('logo');
            $logoPath = $this->updatePhoto($logo, 'logo', $request->npsn, '.jpg');
            $sekolah->logo = $logoPath;
        }

        $this->updatePhotoField('ttd_kepala_sekolah', $request, $sekolah, $request->nip_kepala_sekolah, '.jpg');
    }

    private function deletePhoto($path)
    {
        // Hapus foto dari penyimpanan
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function updatePhoto($file, $field, $npsn, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $npsn . $extension;
        return $file->storeAs('logo', $filename, 'public');
    }

    private function updatePhotoField($inputName, Request $request, Sekolah $sekolah, $kepala_sekolah, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $kepala_sekolah, $extension);
            $sekolah->$inputName = $path;
        }
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findorfail($id);
        $sekolah->forceDelete();
        return back()->with('toast_success', 'Data sekolah berhasil dihapus');
    }
}
