<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Admin;
use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\Karyawan;
use App\Tingkatan;
use App\UnitKaryawan;
use App\StatusKaryawan;
use App\PositionKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Profile';
        if (Auth::user()->role == 1) {
            $admin = Admin::where('user_id', Auth::user()->id)->first();

            return view('admin.profile.index', compact('title', 'admin'));
        } elseif (Auth::user()->role == 2) {
            $karyawan = Karyawan::where('user_id', Auth::user()->id)->first();
            $dataStatusKaryawan = StatusKaryawan::all();
            $dataUnitKaryawan = UnitKaryawan::all();
            $dataPositionKaryawan = PositionKaryawan::all();

            return view('guru.profile.show', compact('title', 'karyawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan'));
        } elseif (Auth::user()->role == 3) {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            $tapel = Tapel::where('status', 1)->first();
            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
            $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');

            return view('siswa.profile.show', compact('title', 'siswa', 'data_tingkatan', 'tingkatan_terendah', 'tingkatan_akhir'));
        }
    }
}
