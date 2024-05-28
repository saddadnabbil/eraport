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
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
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

        $dataKaryawan = Karyawan::with('statusKaryawan', 'unitKaryawan', 'positionKaryawan')->orderBy('kode_karyawan', 'desc')->orderBy('status', 'desc')->select('id', 'nama_lengkap', 'jenis_kelamin', 'kode_karyawan', 'status_karyawan_id', 'unit_karyawan_id', 'position_karyawan_id', 'status')->get();

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
        $dataKaryawan = Karyawan::with('statusKaryawan', 'unitKaryawan', 'positionKaryawan')->orderBy('kode_karyawan', 'desc')->orderBy('status', 'desc')->select('id', 'nama_lengkap', 'jenis_kelamin', 'kode_karyawan', 'status_karyawan_id', 'unit_karyawan_id', 'position_karyawan_id', 'status')->get();

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
    public function store(StoreKaryawanRequest $request)
    {
        try {
            // Image validation before upload
            $this->validateImageSize($request);

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
                return back()->with('toast_error', 'Username was already taken');
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

            if ($user->hasRole(['Curriculum', 'Teacher', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG'])) {
                $guru = new Guru([
                    'karyawan_id' => $karyawan->id,
                ]);

                $guru->save();
            }

            $this->saveUploadedFiles($request, $karyawan);

            return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' telah ditambahkan');
        } catch (\Throwable $th) {
            // Handle validation errors
            return back()->with('toast_error', 'File size exceeds limit (2 MB)');
        }
    }

    private function validateImageSize(Request $request)
    {
        $maxFileSizeKB = 2048; // 2 MB in kilobytes
        $images = ['pas_photo', 'photo_kartu_identitas', 'photo_taxpayer', 'photo_kk', 'other_document'];

        foreach ($images as $imageField) {
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $fileSizeKB = $file->getSize() / 1024; // Convert bytes to kilobytes
                if ($fileSizeKB > $maxFileSizeKB) {
                    throw new \Exception('File size exceeds limit for ' . $imageField);
                }
            }
        }
    }

    private function saveUploadedFiles(Request $request, Karyawan $karyawan)
    {
        if ($request->hasFile('pas_photo')) {
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $this->savePhoto($pasPhoto, 'karyawan', $request->kode_karyawan, '.jpg');
            $karyawan->pas_photo = $pasPhotoPath;
        }

        $this->savePhotoField('photo_kartu_identitas', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->savePhotoField('photo_taxpayer', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->savePhotoField('photo_kk', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->savePhotoField('other_document', $request, $karyawan, $request->kode_karyawan, '.jpg');

        $karyawan->save();
    }

    private function savePhoto($file, $field, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $kodeKaryawan . $extension;
        return $file->storeAs($field, $filename, 'public');
    }

    private function savePhotoField($inputName, Request $request, Karyawan $karyawan, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $kodeKaryawan, $extension);
            $karyawan->$inputName = $path;
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
    public function update(UpdateKaryawanRequest $request, $id)
    {
        try {
            // Image validation before upload
            $this->validateImageSize($request);
        } catch (\Throwable $th) {
            // Handle validation errors
            return back()->with('toast_error', 'File size exceeds limit (2 MB)');
        } // Find the Karyawan instance by ID

        $karyawan = Karyawan::findOrFail($id);

        $user = User::findOrFail($karyawan->user_id);

        $user->username = $request->username;

        if ($request->password_baru && $request->password_baru != null && $request->password_lama) {
            if (Hash::check($request->password_lama, $user->password)) {
                $user->password = Hash::make($request->password_baru);
            } else {
                return redirect()->back()->with('error', 'Password lama tidak sesuai');
            }
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

        if ($user->hasRole(['Curriculum', 'Teacher', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG'])) {
            // create or update guru
            $guru = [
                'karyawan_id' => $karyawan->id
            ];

            $guru = Guru::updateOrCreate($guru, $guru);
        }

        // Optionally, you can update and save any uploaded files to the model
        $this->updateUploadedFiles($request, $karyawan);

        // Redirect or return a response as needed
        return back()->with('toast_success', 'Karyawan ' . $request->nama_lengkap . ' berhasil diperbarui');
    }

    private function updateUploadedFiles(Request $request, Karyawan $karyawan)
    {
        if ($request->hasFile('pas_photo')) {
            $this->deletePhoto($karyawan->pas_photo); // Hapus foto lama sebelum menyimpan yang baru
            $pasPhoto = $request->file('pas_photo');
            $pasPhotoPath = $this->updatePhoto($pasPhoto, 'karyawan', $request->kode_karyawan, '.jpg');
            $karyawan->pas_photo = $pasPhotoPath;
        }

        $this->updatePhotoField('photo_kartu_identitas', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('photo_taxpayer', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('photo_kk', $request, $karyawan, $request->kode_karyawan, '.jpg');
        $this->updatePhotoField('other_document', $request, $karyawan, $request->kode_karyawan, '.jpg');

        $karyawan->save();
    }

    private function deletePhoto($path)
    {
        // Hapus foto dari penyimpanan
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function updatePhoto($file, $field, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        $filename = $kodeKaryawan . $extension;
        return $file->storeAs('karyawan', $filename, 'public');
    }

    private function updatePhotoField($inputName, Request $request, Karyawan $karyawan, $kodeKaryawan, $extension = '.jpg')
    {
        // Make extension optional with default
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $this->savePhoto($file, $inputName, $kodeKaryawan, $extension);
            $karyawan->$inputName = $path;
        }
    }

    // public function export()
    // {
    //     $filename = 'data_karyawan ' . date('Y-m-d H_i_s') . '.xls';
    //     return Excel::download(new KaryawanExport, $filename);
    // }

    public function format_import()
    {
        $file = public_path() . '/format_import/format_import_karyawan.xls';
        $headers = ['Content-Type: application/xls'];
        return Response::download($file, 'format_import_karyawan ' . date('Y-m-d H_i_s') . '.xls', $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:2048', // Validasi untuk file upload
        ]);

        try {
            Excel::import(new KaryawanImport(), $request->file('file_import'));
            return back()->with('toast_success', 'Data karyawan berhasil diimport');
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
