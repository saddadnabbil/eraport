<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guru;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\UnitKaryawan;
use Illuminate\Http\Request;
use App\Models\StatusKaryawan;
use App\Imports\KaryawanImport;
use App\Rules\MatchOldPassword;
use App\Models\PositionKaryawan;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data Karyawan';

        $dataKaryawan = Karyawan::with('statusKaryawan', 'unitKaryawan', 'positionKaryawan')
            ->orderBy('kode_karyawan', 'desc')
            ->orderBy('status', 'desc')
            ->select('id', 'nama_lengkap', 'jenis_kelamin', 'kode_karyawan', 'status_karyawan_id', 'unit_karyawan_id', 'position_karyawan_id', 'status')
            ->get();

        $dataStatusKaryawan = StatusKaryawan::all();
        $dataUnitKaryawan = UnitKaryawan::all();
        $dataPositionKaryawan = PositionKaryawan::all();
        $dataRoles = Role::get();
        $dataPermission = Permission::get();

        $totalKaryawanActive = Karyawan::where('status', true)->count();
        $totalKaryawanNonActive = Karyawan::where('status', false)->count();

        return view('admin.karyawan.employee.index', compact('title', 'dataKaryawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan', 'dataRoles', 'dataPermission', 'totalKaryawanActive', 'totalKaryawanNonActive'));
    }

    public function data()
    {
        $dataKaryawan = Karyawan::with('statusKaryawan', 'unitKaryawan', 'positionKaryawan')
            ->orderBy('kode_karyawan', 'desc')
            ->orderBy('status', 'desc')
            ->select('id', 'nama_lengkap', 'jenis_kelamin', 'kode_karyawan', 'status_karyawan_id', 'unit_karyawan_id', 'position_karyawan_id', 'status')
            ->get();

        return DataTables::of($dataKaryawan)
            ->addColumn('status_karyawan.nama_status_karyawan', function ($karyawan) {
                return $karyawan->statusKaryawan->status_nama;
            })
            ->addColumn('unit_karyawan.nama_unit_karyawan', function ($karyawan) {
                return $karyawan->unitKaryawan->unit_nama;
            })
            ->addColumn('position_karyawan.nama_position_karyawan', function ($karyawan) {
                return $karyawan->positionKaryawan->position_nama;
            })
            ->addColumn('status', function ($karyawan) {
                $statusBadge = $karyawan->status ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Non Aktif</span>';
                return $statusBadge;
            })
            ->addColumn('action', function ($karyawan) {
                $deleteButton = view('components.actions.delete-button', [
                    'route' => route('karyawan.destroy', $karyawan->id),
                    'id' => $karyawan->id,
                    'isPermanent' => true,
                    'withEdit' => false,
                    'withShow' => true,
                    'showRoute' => route('karyawan.show', $karyawan->id),
                ])->render();

                return $deleteButton;
            })
            ->rawColumns(['status', 'action'])
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
            'role' => 'required|array',
            'role*' => 'required|exists:roles,id',
            'status_karyawan_id' => 'required|exists:status_karyawans,id',
            'unit_karyawan_id' => 'required|exists:unit_karyawans,id',
            'position_karyawan_id' => 'required|exists:position_karyawans,id',
            'resign_date' => 'nullable|date',
            'join_date' => 'required|date',
            'permanent_date' => 'nullable|date',
            'kode_karyawan' => 'required|string|max:25',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'nomor_akun' => 'nullable|string|max:255',
            'nomor_fingerprint' => 'required|integer',
            'nomor_taxpayer' => 'nullable|string|max:255',
            'nama_taxpayer' => 'nullable|string|max:255',
            'nomor_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'iuran_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'nomor_bpjs_yayasan' => 'nullable|string|max:255',
            'nomor_bpjs_pribadi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:MALE,FEMALE',
            'agama' => 'required|in:1,2,3,4,5,6,7',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'alamat_sekarang' => 'nullable|string',
            'kota' => 'nullable|string',
            'kode_pos' => 'nullable|integer',
            'nomor_phone' => 'nullable|string',
            'nomor_hp' => 'required|string',
            'email' => 'required|email',
            'email_sekolah' => 'nullable|email',
            'warga_negara' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'nama_pasangan' => 'nullable|string|max:255',
            'jumlah_anak' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimum 2 MB
            'photo_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_taxpayer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        }

        try {
            $user = new User([
                'username' => $request->kode_karyawan,
                'password' => bcrypt(date('d-m-Y', strtotime($request->tanggal_lahir))),
                'status' => true,
            ]);

            $user->save();

            // add role
            foreach ($request->role as $roleId) {
                $role = Role::findOrFail($roleId);
                $user->assignRole($role);
            }
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Username telah digunakan');
        }

        // Validation passed, create a new Karyawan instance and fill it with request data
        $karyawan = new Karyawan([
            'user_id' => $user->id,
            'status_karyawan_id' => $request->status_karyawan_id,
            'unit_karyawan_id' => $request->unit_karyawan_id,
            'position_karyawan_id' => $request->position_karyawan_id,
            'resign_date' => $request->resign_date,
            'join_date' => $request->join_date,
            'permanent_date' => $request->permanent_date,
            'kode_karyawan' => $request->kode_karyawan,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_akun' => $request->nomor_akun,
            'nomor_fingerprint' => $request->nomor_fingerprint,
            'nomor_taxpayer' => $request->nomor_taxpayer,
            'nama_taxpayer' => $request->nama_taxpayer,
            'nomor_bpjs_ketenagakerjaan' => $request->nomor_bpjs_ketenagakerjaan,
            'iuran_bpjs_ketenagakerjaan' => $request->iuran_bpjs_ketenagakerjaan,
            'nomor_bpjs_yayasan' => $request->nomor_bpjs_yayasan,
            'nomor_bpjs_pribadi' => $request->nomor_bpjs_pribadi,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'alamat_sekarang' => $request->alamat_sekarang,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'nomor_phone' => $request->nomor_phone,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'email_sekolah' => $request->email_sekolah,
            'warga_negara' => $request->warga_negara,
            'status_pernikahan' => $request->status_pernikahan,
            'nama_pasangan' => $request->nama_pasangan,
            'jumlah_anak' => $request->jumlah_anak,
            'keterangan' => $request->keterangan,
            'status' => true,
            'avatar' => 'default.png',
        ]);

        // Save the Karyawan instance to the database
        $karyawan->save();

        if ($request->unit_karyawan_id == 2 || $request->unit_karyawan_id == 3 || $request->unit_karyawan_id == 4 || $request->unit_karyawan_id == 5) {
            $guru = new Guru([
                'karyawan_id' => $karyawan->id,
            ]);

            $guru->save();
        }

        // Optionally, you can attach any uploaded files to the model
        $this->saveUploadedFiles($request, $karyawan);

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' telah ditambahkan');
    }

    private function saveUploadedFiles(Request $request, Karyawan $karyawan)
    {
        // Handle and save the uploaded files (if any) associated with the Karyawan model
        // Example: Assuming 'pas_photo' is the name of the file input for pas_photo
        if ($request->hasFile('pas_photo')) {
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $pasPhoto->store('pas_photo', 'public'); // Assuming 'pas_photo' is your storage disk

            // Save the file path to the model attribute
            $karyawan->pas_photo = $pasPhotoPath;
        }

        // Repeat the process for other uploaded files
        // Example: 'photo_kartu_identitas', 'photo_taxpayer', 'photo_kk', 'other_document', etc.

        $this->savePhoto('photo_kartu_identitas', $request, $karyawan, 'photo_kartu_identitas');
        $this->savePhoto('photo_taxpayer', $request, $karyawan, 'photo_taxpayer');
        $this->savePhoto('photo_kk', $request, $karyawan, 'photo_kk');
        $this->savePhoto('other_document', $request, $karyawan, 'other_document');

        // Save the Karyawan model after handling files
        $karyawan->save();
    }

    private function savePhoto($inputName, Request $request, Karyawan $karyawan, $attributeName)
    {
        if ($request->hasFile($inputName)) {
            $photo = $request->file($inputName);
            $photoPath = $photo->store($attributeName, 'public'); // Assuming $attributeName is your storage disk

            // Save the file path to the model attribute
            $karyawan->$attributeName = $photoPath;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Detail Karyawan';
        if (Auth::user()->hasRole('Curriculum')) {
            $karyawan = Karyawan::with('guru')->findorfail($id);
        } elseif (Auth::user()->hasRole('Admin')) {
            $karyawan = Karyawan::findorfail($id);
        }

        $dataStatusKaryawan = StatusKaryawan::all();
        $dataUnitKaryawan = UnitKaryawan::all();
        $dataPositionKaryawan = PositionKaryawan::all();
        $dataRoles = Role::get();

        return view('admin.karyawan.employee.show', compact('title', 'karyawan', 'dataStatusKaryawan', 'dataUnitKaryawan', 'dataPositionKaryawan', 'dataRoles'));
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
        // Find the Karyawan instance by ID
        $karyawan = Karyawan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'password_lama' => ['nullable', new MatchOldPassword],
            'password_baru' => ['nullable', Password::min(8)
                ->numbers()],
            'status_karyawan_id' => 'required|exists:status_karyawans,id',
            'unit_karyawan_id' => 'required|exists:unit_karyawans,id',
            'position_karyawan_id' => 'required|exists:position_karyawans,id',
            'resign_date' => 'nullable|date',
            'join_date' => 'required|date',
            'permanent_date' => 'nullable|date',
            'kode_karyawan' => 'required|string|max:25',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'nomor_akun' => 'nullable|string|max:255',
            'nomor_fingerprint' => 'required|integer',
            'nomor_taxpayer' => 'nullable|string|max:255',
            'nama_taxpayer' => 'nullable|string|max:255',
            'nomor_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'iuran_bpjs_ketenagakerjaan' => 'nullable|string|max:255',
            'nomor_bpjs_yayasan' => 'nullable|string|max:255',
            'nomor_bpjs_pribadi' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:MALE,FEMALE',
            'agama' => 'required|in:1,2,3,4,5,6,7',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'alamat_sekarang' => 'nullable|string',
            'kota' => 'nullable|string',
            'kode_pos' => 'nullable|integer',
            'nomor_phone' => 'nullable|string',
            'nomor_hp' => 'required|string',
            'email' => 'required|email',
            'email_sekolah' => 'nullable|email',
            'warga_negara' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'nama_pasangan' => 'nullable|string|max:255',
            'jumlah_anak' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'pas_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_taxpayer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_kk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $user = User::findOrFail($karyawan->user_id);

            $user->username = $request->username;

            if ($request->password_baru && $request->password_lama) {
                $user->password = Hash::make($request->password_baru);
            }
            $user->save();

            // Mengupdate role
            if ($request->has('role')) {
                $roles = Role::whereIn('id', $request->role)->get();
                $user->syncRoles($roles);
            } else {
                $user->syncRoles([]);
            }

            // Mengupdate status
            $karyawan->user->status = $request->status;
            $karyawan->user->save();

            // Update the Karyawan instance with the new request data
            $karyawan->update([
                'user_id' => $user->id,
                'status_karyawan_id' => $request->status_karyawan_id,
                'unit_karyawan_id' => $request->unit_karyawan_id,
                'position_karyawan_id' => $request->position_karyawan_id,
                'resign_date' => $request->resign_date,
                'join_date' => $request->join_date,
                'permanent_date' => $request->permanent_date,
                'kode_karyawan' => $request->kode_karyawan,
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'nomor_akun' => $request->nomor_akun,
                'nomor_fingerprint' => $request->nomor_fingerprint,
                'nomor_taxpayer' => $request->nomor_taxpayer,
                'nama_taxpayer' => $request->nama_taxpayer,
                'nomor_bpjs_ketenagakerjaan' => $request->nomor_bpjs_ketenagakerjaan,
                'iuran_bpjs_ketenagakerjaan' => $request->iuran_bpjs_ketenagakerjaan,
                'nomor_bpjs_yayasan' => $request->nomor_bpjs_yayasan,
                'nomor_bpjs_pribadi' => $request->nomor_bpjs_pribadi,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'alamat_sekarang' => $request->alamat_sekarang,
                'kota' => $request->kota,
                'kode_pos' => $request->kode_pos,
                'nomor_phone' => $request->nomor_phone,
                'nomor_hp' => $request->nomor_hp,
                'email' => $request->email,
                'email_sekolah' => $request->email_sekolah,
                'warga_negara' => $request->warga_negara,
                'status_pernikahan' => $request->status_pernikahan,
                'nama_pasangan' => $request->nama_pasangan,
                'jumlah_anak' => $request->jumlah_anak,
                'keterangan' => $request->keterangan,
            ]);


            // Optionally, you can update and save any uploaded files to the model
            $this->updateUploadedFiles($request, $karyawan);

            // Save the Karyawan instance to the database
            $karyawan->save();

            // Redirect or return a response as needed
            return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' berhasil diperbarui');
        }
    }

    private function updateUploadedFiles(Request $request, Karyawan $karyawan)
    {
        // Handle and update the uploaded files (if any) associated with the Karyawan model
        // Example: Assuming 'pas_photo' is the name of the file input for pas_photo
        $this->updatePhoto('pas_photo', $request, $karyawan, 'pas_photo');

        // Repeat the process for other uploaded files
        // Example: 'photo_kartu_identitas', 'photo_taxpayer', 'photo_kk', 'other_document', etc.

        $this->updatePhoto('photo_kartu_identitas', $request, $karyawan, 'photo_kartu_identitas');
        $this->updatePhoto('photo_taxpayer', $request, $karyawan, 'photo_taxpayer');
        $this->updatePhoto('photo_kk', $request, $karyawan, 'photo_kk');
        $this->updatePhoto('other_document', $request, $karyawan, 'other_document');
    }

    private function updatePhoto($inputName, Request $request, Karyawan $karyawan, $attributeName)
    {
        if ($request->hasFile($inputName)) {
            // Delete the existing file if it exists
            if ($karyawan->$attributeName) {
                Storage::disk('public')->delete($karyawan->$attributeName);
            }

            $photo = $request->file($inputName);
            $photoPath = $photo->store($attributeName, 'public'); // Assuming $attributeName is your storage disk

            // Update the file path to the model attribute
            $karyawan->$attributeName = $photoPath;
        }
    }

    // public function export()
    // {
    //     $filename = 'data_karyawan ' . date('Y-m-d H_i_s') . '.xls';
    //     return Excel::download(new KaryawanExport, $filename);
    // }

    public function format_import()
    {
        $file = public_path() . "/format_import/format_import_karyawan.xls";
        $fileName = 'format_import_karyawan_' . date('Y-m-d_H_i_s') . '.xls';
        return download($file, $fileName, [
            'Content-Type' => 'application/xls',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:2048', // Validasi untuk file upload
        ]);

        try {
            Excel::import(new KaryawanImport, $request->file('file_import'));
            return back()->with('toast_success', 'Data karyawan berhasil diimport');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return back()->with('toast_error', 'Maaf, format data tidak sesuai');
        }
    }

    public function activate(Request $request)
    {
        $id = $request->input('id');

        $karyawan = Karyawan::findorfail($id);
        $karyawan->update(['status' => 1]);
        $karyawan->user->update(['status' => 1]);

        return back()->with('toast_success', 'Karyawan ' . $karyawan->nama_lengkap . ' telah memberhasil diaktifkan');
    }

    public function nonActivate(Request $request)
    {
        $id = $request->input('id');

        $karyawan = Karyawan::findorfail($id);
        $karyawan->update(['status' => 0]);
        $karyawan->user->update(['status' => 0]);

        return back()->with('toast_success', 'Karyawan ' . $karyawan->nama_lengkap . ' telah memberhasil dinonaktifkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        try {
            $karyawan->update([
                'status' => 0,
            ]);
            $karyawan->user->update([
                'status' => 0,
            ]);

            $karyawan->delete();
            $karyawan->user->delete();

            return back()->with('toast_success', 'Karyawan & User berhasil dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus kay$karyawan.');
        }
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanent($id)
    {
        $karyawan = Karyawan::withTrashed()->findOrFail($id);

        try {
            $karyawan->user->forceDelete();
            $karyawan->forceDelete();

            return back()->with('toast_success', 'Karyawan & User berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus karyawan secara permanen.');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $karyawan = Karyawan::withTrashed()->findOrFail($id);

            $karyawan->restoreKaryawan();

            return back()->with('toast_success', 'Karyawan & User berhasil direstorasi');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi karyawan.');
        }
    }

    public function showTrash()
    {
        $title = 'Data Trash Karyawan';
        $karyawanTrashed = Karyawan::onlyTrashed()->get();

        return view('admin.karyawan.employee.trash', compact('title', 'karyawanTrashed'));
    }
}
