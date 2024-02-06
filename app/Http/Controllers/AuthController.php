<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Term;
use App\User;
use App\Kelas;
use App\Tapel;
use App\Sekolah;
use App\Semester;
use Carbon\Carbon;
use App\RiwayatLogin;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $data_tapel = Tapel::orderBy('id', 'DESC')->get();
        if (count($data_tapel) == 0) {
            $title = 'Setting Tahun Pelajaran';
            return view('auth.setting_tapel', compact('title'));
        } else {
            $title = 'Login';
            return view('auth.login', compact('title', 'data_tapel'));
        }
    }

    public function setting_tapel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_pelajaran' => 'required|min:9|max:9',
            'semester' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            $semesterData = [['semester' => 1], ['semester' => 2]];

            $termData = [['term' => 1], ['term' => 2]];

            Semester::insert($semesterData);
            Term::insert($termData);

            $tapelData = [
                'tahun_pelajaran' => $request->tahun_pelajaran,
                'semester_id' => $request->semester,
                'term_id' => $request->term,
            ];

            Tapel::create($tapelData);

            return back()->with('toast_success', 'Registrasi berhasil');
        }
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
            'username' => 'required|exists:user,username',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('toast_error', $validator->errors()->first())
                ->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            // Login successful
            $this->updateLoginHistory();

            $tapel = Tapel::where('status', 1)->first();

            session([
                'tapel_id' => $tapel->id,
                'semester_id' => $tapel->semester_id,
                'term_id' => $tapel->term_id,
            ]);

            $this->handleGuruSession();

            // Redirect to the dashboard
            return redirect()
                ->route('dashboard')
                ->with('toast_success', 'Login berhasil');
        } else {
            return redirect()
                ->back()
                ->with('toast_error', 'Kombinasi username dan password tidak valid.')
                ->withInput();
        }
    }

    protected function updateLoginHistory()
    {
        $cek_riwayat = RiwayatLogin::where('user_id', Auth::id())->first();

        if (is_null($cek_riwayat)) {
            $riwayat_login = new RiwayatLogin([
                'user_id' => Auth::id(),
                'status_login' => true,
            ]);
            $riwayat_login->save();
        } else {
            $cek_riwayat->update(['status_login' => true]);
        }
    }

    protected function handleGuruSession()
    {
        $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

        if ($guru && Auth::user()->role == 2) {
            $cek_wali_kelas = Kelas::where('guru_id', $guru->id)->first();

            session([
                'akses_sebagai' => 'Guru Mapel',
                'cek_wali_kelas' => $cek_wali_kelas != null,
            ]);
        }
    }

    public function logout(Request $request)
    {
        RiwayatLogin::where('user_id', Auth::id())->update([
            'status_login' => false,
        ]);

        // Set remember_me ke null pada saat logout
        Auth::user()->update(['remember_me' => null]);

        $request->session()->flush();
        Auth::logout();
        return redirect('/')->with('toast_success', 'Logout berhasil');
    }

    public function view_ganti_password()
    {
        $title = 'Ganti Password';
        return view('auth.ganti_password', compact('title'));
    }

    public function ganti_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => ['required', new MatchOldPassword()],
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            $user = User::findorfail(Auth::id());
            $data = [
                'password' => bcrypt($request->password_baru),
            ];
            $user->update($data);
            RiwayatLogin::where('user_id', Auth::id())->update(['status_login' => false]);
            Auth::logout();
            return redirect('/')->with('toast_success', 'Password berhasil diganti, silahkan login !');
        }
    }

    public function admin_ganti_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => ['required', new MatchOldPassword()],
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all()[0])
                ->withInput();
        } else {
            $user = User::findorfail(Auth::id());
            $data = [
                'password' => bcrypt($request->password_baru),
            ];
            $user->update($data);
            RiwayatLogin::where('user_id', Auth::id())->update(['status_login' => false]);
            Auth::logout();
            return redirect('/')->with('toast_success', 'Password berhasil diganti, silahkan login !');
        }
    }

    public function ganti_akses()
    {
        if (session()->get('akses_sebagai') == 'Guru Mapel') {
            $guru = Guru::where('karyawan_id', Auth::id())->first();
            $cek_wali_kelas = Kelas::where('guru_id', $guru->id)->first();
            if (!is_null($cek_wali_kelas)) {
                session()->put([
                    'akses_sebagai' => 'Wali Kelas',
                ]);
                return redirect('/dashboard')->with('toast_success', 'Akses wali kelas berhasil');
            } else {
                return back()->with('toast_error', 'Anda tidak memiliki akses sebagai wali kelas');
            }
        } else {
            session()->put([
                'akses_sebagai' => 'Guru Mapel',
            ]);
            return redirect('/dashboard')->with('toast_success', 'Akses guru mapel berhasil');
        }
    }

    public function redirect()
    {
        return redirect('/dashboard');
    }
}
