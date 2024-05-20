<?php

namespace App\Http\Controllers\Guru\P5;

use App\Models\P5Element;
use App\Models\P5Subelement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class P5SubelementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Data Subelement P5";
        $dataSubelement = P5Subelement::orderBy('p5_element_id', 'ASC')->get();
        $dataElement = P5Element::orderBy('id', 'ASC')->get();

        return view('guru.p5.subelement.index', compact('title', 'dataElement', 'dataSubelement'));
    }

    public function data()
    {
        $dataSubelement = P5Subelement::orderBy('id', 'ASC')->get();

        return DataTables::of($dataSubelement)
            ->addColumn('full_name', function ($guru) {
                return $guru->karyawan->nama_lengkap;
            })
            ->addColumn('unit_nama', function ($guru) {
                return $guru->karyawan->unitKaryawan->unit_nama;
            })
            ->addColumn('employee_code', function ($guru) {
                return $guru->karyawan->kode_karyawan;
            })
            ->addColumn('identity_card', function ($guru) {
                return $guru->karyawan->nik;
            })
            ->addColumn('number_phone', function ($guru) {
                return $guru->karyawan->nomor_phone;
            })
            ->addColumn('gender', function ($guru) {
                return $guru->jenis_kelamin == 'L' ? 'Male' : 'Female';
            })
            ->addColumn('action', function ($guru) {
                return '<a href="' . route('karyawan.show', $guru->karyawan->id) . '" class="btn btn-info btn-sm mt-1"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['action']) // Untuk menginterpretasikan HTML dalam kolom action
            ->toJson();
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'p5_element_id' => 'required|exists:p5_elements,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        P5Element::create($request->all());

        return back()->with('success', 'Subelement P5 berhasil ditambahkan.');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'p5_element_id' => 'required|exists:p5_elements,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        P5Element::find($id)->update($request->all());

        return back()->with('success', 'Subelement P5 berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subelement = P5Element::findorfail($id);
        $subelement->delete();
        return back()->with('toast_success', 'Subelement P5 Berhasil Dihapus');
    }
}
