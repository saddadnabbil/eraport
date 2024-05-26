<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guru;
use App\Models\Term;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Tapel;
use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\RiwayatLogin;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->hasAnyRole(['Teacher', 'Curriculum', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG'])) {
                return redirect()->route('guru.dashboard');
            } elseif (Auth::user()->hasRole('Student')) {
                return redirect()->route('siswa.dashboard');
            }
        }

        $data_tapel = Tapel::orderBy('id', 'DESC')->get();
        if (count($data_tapel) == 0) {
            $title = 'Setting Tahun Pelajaran';
            return view('auth.setting_tapel', compact('title'));
        } else {
            $title = 'Login';
            return view('auth.login', compact('title'));
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

            return back()->with('toast_success', 'Registration successful');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthRequest $request)
    {
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

            if (Auth::user()->hasAnyRole(['Admin'])) {
                return redirect()->route('admin.dashboard')->with('toast_success', 'Login successful');
            } elseif (Auth::user()->hasRole('Curriculum') && !Auth::user()->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG'])) {
                return redirect()->route('curriculum.dashboard')->with('toast_success', 'Login successful');
            } elseif (Auth::user()->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG', 'Curriculum'])) {
                return redirect()->route('guru.dashboard')->with('toast_success', 'Login successful');
            } elseif (Auth::user()->hasRole('Student')) {
                return redirect()->route('siswa.dashboard')->with('toast_success', 'Login successful');
            } else {
                return redirect()->back()->with('toast_error', 'Please contact your administrator')->withInput();
            }
        } else {
            return redirect()->back()->with('toast_error', 'There is no account matching that username/password.')->withInput();
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
        $user = Auth::user();

        if ($user->hasAnyRole(['Teacher', 'Co-Teacher', 'Teacher PG-KG', 'Co-Teacher PG-KG'])) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();
            // check permission name if homeroom-km true
            if ($user->getRoleNames()->contains('Teacher')) {
                session([
                    'akses_sebagai' => 'teacher-km',
                ]);
            } elseif ($user->getRoleNames()->contains('Teacher PG-KG')) {
                session([
                    'akses_sebagai' => 'teacher-pg-kg',
                ]);
            }

            $cek_wali_kelas = Kelas::where('guru_id', $guru->id)
                ->whereNotIn('tingkatan_id', [1, 2, 3])
                ->first();
            $cek_wali_kelas_tk = Kelas::where('guru_id', $guru->id)
                ->whereIn('tingkatan_id', [1, 2, 3])
                ->get();

            if ($cek_wali_kelas) {
                session([
                    'cek_homeroom' => true,
                ]);
            }

            if ($cek_wali_kelas_tk && count($cek_wali_kelas_tk) > 0) {
                session([
                    'cek_homeroom_tk' => true,
                ]);
            }
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
        return redirect('/')->with('toast_success', 'Logout successful');
    }

    public function view_ganti_password()
    {
        $title = 'Ganti Password';
        return view('auth.ganti_password', compact('title'));
    }

    public function ganti_password(UpdateAuthRequest $request)
    {
        $user = User::findorfail(Auth::id());
        $data = [
            'password' => bcrypt($request->password_baru),
        ];
        $user->update($data);
        RiwayatLogin::where('user_id', Auth::id())->update(['status_login' => false]);
        Auth::logout();
        return redirect('/')->with('toast_success', 'Password has been changed successfully, please log in!');
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
            return redirect('/')->with('toast_success', 'Password has been changed successfully, please log in!');
        }
    }

    public function ganti_akses()
    {
        $user = Auth::user();
        if ($user->hasRole(['Teacher'])) {
            if (session()->get('akses_sebagai') == 'teacher-km') {
                session()->put([
                    'akses_sebagai' => 'homeroom-km',
                    'cek_homeroom' => true,
                ]);
                return redirect(route('guru.dashboard'))->with('toast', 'Homeroom access was successful');
            } elseif (session()->get('akses_sebagai') == 'homeroom-km') {
                session()->put([
                    'akses_sebagai' => 'teacher-km',
                ]);
                return redirect(route('guru.dashboard'))->with('toast_success', 'Teacher access was successful');
            }
        }
    }

    public function redirect()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->hasAnyRole(['Teacher', 'Curriculum', 'Teacher PG-KG', 'Co-Teacher', 'Co-Teacher PG-KG'])) {
                return redirect()->route('guru.dashboard');
            } elseif (Auth::user()->hasRole('Student')) {
                return redirect()->route('siswa.dashboard');
            }
        }
    }
}
