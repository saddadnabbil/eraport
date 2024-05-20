<?php

namespace App\Http\Controllers\Guru\P5;

use App\Models\P5Dimensi;
use App\Models\P5Element;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class P5ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Data Element P5";
        $dataElement = P5Element::orderBy('p5_dimensi_id', 'ASC')->get();
        $dataDimensi = P5Dimensi::orderBy('id', 'ASC')->get();

        return view('guru.p5.element.index', compact('title', 'dataElement', 'dataDimensi'));
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
            'p5_dimensi_id' => 'required|exists:p5_dimensis,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        P5Element::create($request->all());

        return back()->with('success', 'Element P5 berhasil ditambahkan.');
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
            'p5_dimensi_id' => 'required|exists:p5_dimensis,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        P5Element::find($id)->update($request->all());

        return back()->with('success', 'Element P5 berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dimensi = P5Element::findorfail($id);
        $dimensi->delete();
        return back()->with('toast_success', 'Element P5 Berhasil Dihapus');
    }
}
