<?php

namespace App\Http\Controllers\Admin\P5;

use App\Models\Guru;
use App\Models\P5Project;
use App\Models\P5Subelement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class P5ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'P5 Project';
        $dataProject = P5Project::orderBy('kelas_id', 'ASC')->get();

        foreach ($dataProject as $project) {
            $subelement_data_array = json_decode($project->subelement_data, true);

            $subelement_active_count = 0;

            foreach ($subelement_data_array as $subelement) {
                if ($subelement['has_active']) {
                    $subelement_active_count++;
                }
            }

            $project->subelement_active_count = $subelement_active_count;
        }

        return view('admin.p5.project.index', compact('title', 'dataProject'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        $project = P5Project::find($id);
        $title = 'Edit ' . $project->kelas->nama_kelas . ' - ' . $project->p5_tema->name;
        $dataGuru = Guru::orderBy('id', 'ASC')->get();
        $dataSubelement = P5Subelement::orderBy('p5_element_id', 'ASC')->get();

        $subelement_data = json_decode($project->subelement_data, true);
        // Array to store corresponding P5Subelement models
        $subelements = [];

        // Loop through subelement_data
        foreach ($subelement_data as $data) {
            foreach ($dataSubelement as $subelement) {
                $subelement_data_item = collect($subelement_data)->firstWhere('subelement_id', $subelement->id);
                if ($subelement_data_item) {
                    $subelement->has_active = $subelement_data_item['has_active'];
                    $subelement->grade = $subelement_data_item['grade'];
                } else {
                    $subelement->has_active = false;
                    $subelement->grade = null;
                }
            }
        }

        $dataSubelement = $dataSubelement->sortBy(function ($subelement) {
            return [$subelement->has_active ? 0 : 1, $subelement->id];
        })->values();

        return view('admin.p5.project.edit', compact('title', 'project', 'dataGuru', 'dataSubelement'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
