<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Pembelajaran;
use App\Models\Tingkatan;
use App\Models\TkPembelajaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TkPembelajaranExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $time_download = date('Y-m-d H:i:s');

        $tapel = Tapel::where('status', 1)->first();
        $id_tingkatan = Tingkatan::get('id');
        $data_pembelajaran = TkPembelajaran::whereIn('tingkatan_id', $id_tingkatan)->whereNotNull('guru_id')->orderBy('tingkatan_id', 'ASC')->get();

        return view('exports.pembelajarantk', compact('time_download', 'data_pembelajaran'));
    }
}
