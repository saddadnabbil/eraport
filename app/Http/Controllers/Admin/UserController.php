<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\Models\Guru;
use App\Models\User;
use App\Models\Admin;
use App\Models\Siswa;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Data User';
        $data_user = User::select('id', 'username', 'role', 'status')
            ->with(['siswa' => function ($query) {
                $query->select('user_id', 'nama_lengkap', 'id');
            }, 'karyawan' => function ($query) {
                $query->select('id', 'user_id', 'nama_lengkap', 'id');
            }])
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('role', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();
        $data_roles = Role::get();
        $data_permission = Permission::get();
        // $data_user = User::where('id', '!=', Auth::user()->id)->orderBy('role', 'ASC')->orderBy('id', 'ASC')->get();

        return view('admin.user.index', compact('title', 'data_user', 'data_roles', 'data_permission'));
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
            'username' => 'required|min:3|max:100|unique:user',
            'role' => 'required|exists:roles,id',
            'permission' => 'required|array',
            'permission.*' => 'exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $role = Role::findOrFail($request->role);

            $user = new User([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'status' => true
            ]);
            $user->save();

            if ($role->id == 3) {
                if ($user->siswa()->first() == null) {
                    $siswa = new Siswa([
                        'user_id' => $user->id,
                        'nama_lengkap' => $request->username,
                        'nama_panggilan' => $request->username
                    ]);

                    $user->siswa()->create([
                        'nama_lengkap' => $request->username,
                        'nama_panggilan' => $request->username
                    ]);
                }
                dd('siswa2');
            } else {
                if ($user->karyawan()->first() == null) {
                    $karyawan = new Karyawan([
                        'user_id' => $user->id,
                        'kode_karyawan' => 'K' . $user->id,
                        'nama_lengkap' => $request->username
                    ]);

                    $user->karyawan()->create([
                        'kode_karyawan' => 'K' . $user->id,
                        'nama_lengkap' => $request->username
                    ]);
                    dd('karyawan');
                }
            }

            // Assign each role to the user
            foreach ($request->permission as $permissionId) {
                $permission = Permission::findOrFail($permissionId);
                $user->givePermissionTo($permission);
            }

            return back()->with('toast_success', 'User berhasil ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|min:3|max:100',
            'status' => 'required',
            'role' => 'nullable|exists:roles,id',
            'permission' => 'nullable|array',
            'permission.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $user = User::findOrFail($id);
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        if ($request->has('permission')) {
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $user->syncPermissions($permissions);
        } else {
            $user->syncPermissions([]);
        }

        return back()->with('toast_success', 'User berhasil diupdate');
    }

    public function export()
    {
        $filename = 'user_e_raport ' . date('Y-m-d H_i_s') . '.xls';
        return Excel::download(new UserExport, $filename);
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);

        try {

            if (!is_null($user->siswa)) {
                $user->siswa->update([
                    'status' => 0
                ]);
                $user->siswa->delete();
            }

            if (!is_null($user->karyawan)) {
                $user->karyawan->update([
                    'status' => 0
                ]);
                $user->karyawan->delete();
            }

            $user->update([
                'status' => 0
            ]);

            $user->delete();

            return back()->with('toast_success', 'User berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus user.');
        }

        return back()->with('toast_success', 'User ' . $user->username . ' telah dihapus');
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPermanent($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        try {
            // Permanent delete the related Siswa records
            $user->siswa()->forceDelete();
            $user->karyawan()->forceDelete();

            // Permanent delete the user and its User record
            $user->forceDelete();

            return back()->with('toast_success', 'User berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat menghapus user secara permanen.');
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
            $user = User::withTrashed()->findOrFail($id);

            $user->restoreUser();

            return back()->with('toast_success', 'User berhasil direstore');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('toast_error', 'Terjadi kesalahan saat merestorasi user.');
        }
    }

    public function showTrash()
    {
        $title = "Data Trash User";
        $userTrashed = User::onlyTrashed()->get();

        return view('admin.user.trash', compact('title', 'userTrashed'));
    }
}
