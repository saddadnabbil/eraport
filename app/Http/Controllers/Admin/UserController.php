<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\Guru;
use App\User;
use App\Admin;
use App\Siswa;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
        $data_user = User::orderBy('role', 'ASC')->orderBy('id', 'ASC')->get();
        // $data_user = User::where('id', '!=', Auth::user()->id)->orderBy('role', 'ASC')->orderBy('id', 'ASC')->get();
        return view('admin.user.index', compact('title', 'data_user'));
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
            'nama_lengkap' => 'required|min:3|max:100',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required|email|min:5|max:100|unique:admin',
            'nomor_hp' => 'required|numeric|digits_between:11,13|unique:admin',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {
            $user = new User([
                'username' => strtolower(str_replace(' ', '', $request->nama_lengkap)),
                'password' => bcrypt(strtolower(str_replace(' ', '', $request->nama_lengkap))),
                'role' => 1,
                'status' => true
            ]);
            $user->save();

            $admin = new Admin([
                'user_id' => $user->id,
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'avatar' => 'default.png'
            ]);
            $admin->save();
            return back()->with('toast_success', 'User berhasil ditambahkan');
        }
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
            'password' => 'nullable|min:8|max:100',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        } else {

            $user = User::findorfail($id);
            if (is_null($request->password)) {
                $data = [
                    'status' => $request->status
                ];
                $user->karyawan->update($data);
            } else {
                $data = [
                    'password' => bcrypt($request->password),
                    'status' => $request->status
                ];
            }
            $user->update($data);
            return back()->with('toast_success', 'User berhasil diedit');
        }
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

            if (!is_null($user->guru)) {
                $user->guru->delete();
            }

            if (!is_null($user->admin)) {
                $user->admin->delete();
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
            $user->guru()->forceDelete();
            $user->admin()->forceDelete();

            // Permanent delete the user and its User record
            $user->user->forceDelete();
            $user->forceDelete();

            return back()->with('toast_success', 'User berhasil dihapus secara permanen');
        } catch (\Throwable $th) {
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
