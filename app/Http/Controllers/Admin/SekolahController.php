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
        $tapel = Tapel::where('status', 1)->first();
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
            'nip_kepala_sekolah' => 'nullable|digits:18',
            'tdd_kepala_sekolah' => 'nullable|image|max:2048',
            'logo' => 'image|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            if (request()->has('logo')) {
                $logo_file = request()->file('logo');
                $name_logo = 'logo.' . $logo_file->getClientOriginalExtension();
                $logo_file->move('assets/images/logo/', $name_logo);
            } else {
                $name_logo = null;
            }

            if (request()->has('tdd_kepala_sekolah')) {
                $tdd_kepala_sekolah_file = request()->file('tdd_kepala_sekolah');
                $name_tdd_kepala_sekolah = $request->input('kepala_sekolah') . '.' . $tdd_kepala_sekolah_file->getClientOriginalExtension();
                $tdd_kepala_sekolah_file->move('assets/images/ttd/', $name_tdd_kepala_sekolah);
                dd($name_tdd_kepala_sekolah);
            } else {
                $name_tdd_kepala_sekolah = null;
            }

            Sekolah::create([
                'nama_sekolah' => $request->input('nama_sekolah'),
                'npsn' => $request->input('npsn'),
                'nss' => $request->input('nss'),
                'alamat' => $request->input('alamat'),
                'kode_pos' => $request->input('kode_pos'),
                'email' => $request->input('email'),
                'nomor_telpon' => $request->input('nomor_telpon'),
                'website' => $request->input('website'),
                'kepala_sekolah' => $request->input('kepala_sekolah'),
                'nip_kepala_sekolah' => $request->input('nip_kepala_sekolah'),
                'tdd_kepala_sekolah' => $name_tdd_kepala_sekolah,
                'logo' => $name_logo,
                'tapel_id' => $tapel->id,
            ]);

            return redirect()->back()->with('toast_success', 'Data sekolah berhasil ditambahkan');
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
            'nip_kepala_sekolah' => 'nullable|digits:18',
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

        // Proses update gambar logo
        if ($request->hasFile('logo')) {
            $logo_file = $request->file('logo');
            $name_logo = 'logo.' . $logo_file->getClientOriginalExtension();
            $path_logo = $logo_file->storeAs('public/assets/images/logo', $name_logo);
            $data_sekolah['logo'] = str_replace('public/', '', $path_logo);

            // Hapus file lama jika ada
            if ($sekolah->logo) {
                Storage::delete('public/' . $sekolah->logo);
            }
        }

        // Proses update gambar ttd kepala sekolah
        if ($request->hasFile('ttd_kepala_sekolah')) {
            $tdd_kepala_sekolah_file = $request->file('ttd_kepala_sekolah');
            $name_tdd_kepala_sekolah = $sekolah->kepala_sekolah . $tdd_kepala_sekolah_file->getClientOriginalExtension();
            $path_tdd_kepala_sekolah = $tdd_kepala_sekolah_file->storeAs('ttd', $name_tdd_kepala_sekolah);
            $data_sekolah['tdd_kepala_sekolah'] = str_replace('public/', '', $path_tdd_kepala_sekolah);

            dd($data_sekolah['tdd_kepala_sekolah']);

            // Hapus file lama jika ada
            if ($sekolah->tdd_kepala_sekolah) {
                Storage::delete('public/' . $sekolah->tdd_kepala_sekolah);
            }
        }

        // Update data sekolah
        $sekolah->update($data_sekolah);

        return back()->with('toast_success', 'Data sekolah berhasil diedit');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findorfail($id);
        $sekolah->delete();
        return back()->with('toast_success', 'Data sekolah berhasil dihapus');
    }
}
