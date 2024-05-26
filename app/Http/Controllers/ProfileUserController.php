<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tapel;
use App\Models\Karyawan;
use App\Models\Tingkatan;
use App\Models\UnitKaryawan;
use Illuminate\Http\Request;
use App\Models\StatusKaryawan;
use App\Models\PositionKaryawan;
use Spatie\Permission\Models\Role;
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
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $karyawan = Karyawan::where('user_id', Auth::user()->id)->first();
            $dataStatusKaryawan = StatusKaryawan::all();
            $dataUnitKaryawan = UnitKaryawan::all();
            $dataPositionKaryawan = PositionKaryawan::all();
            $dataRoles = Role::get();

            return view('admin.karyawan.employee.show', compact('title', 'karyawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan', 'dataRoles'));
        } elseif ($user->hasRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum'])) {
            $karyawan = Karyawan::where('user_id', Auth::user()->id)->first();
            $dataStatusKaryawan = StatusKaryawan::all();
            $dataUnitKaryawan = UnitKaryawan::all();
            $dataPositionKaryawan = PositionKaryawan::all();
            $dataRoles = Role::get();

            return view('guru.profile.show', compact('title', 'karyawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan', 'dataRoles'));
        } elseif ($user->hasRole('Student')) {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();
            $tapel = Tapel::where('status', 1)->first();
            $data_tingkatan = Tingkatan::orderBy('id', 'ASC')->get();
            $tingkatan_terendah = Kelas::where('tapel_id', $tapel->id)->min('tingkatan_id');
            $tingkatan_akhir = Kelas::where('tapel_id', $tapel->id)->max('tingkatan_id');

            return view('siswa.profile.show', compact('title', 'siswa', 'data_tingkatan', 'tingkatan_terendah', 'tingkatan_akhir'));
        }
    }
}
