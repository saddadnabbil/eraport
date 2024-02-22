<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Term;
use App\Kelas;
use App\Siswa;
use App\Tapel;
use App\Sekolah;
use Carbon\Carbon;
use App\KmKkmMapel;
use App\Pengumuman;
use App\AnggotaKelas;
use App\NilaiSumatif;
use App\Pembelajaran;
use App\RiwayatLogin;
use App\NilaiFormatif;
use App\Ekstrakulikuler;
use App\KmNilaiAkhirRaport;
use App\RencanaNilaiSumatif;
use App\RencanaNilaiFormatif;
use App\KmDeskripsiNilaiSiswa;
use App\AnggotaEkstrakulikuler;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dashboard';
        $sekolah = Sekolah::first();
        $tapel = Tapel::where('status', 1)->first();
        $data_pengumuman = Pengumuman::latest()->take(3)->get();
        $data_riwayat_login = RiwayatLogin::where('user_id', '!=', Auth::user()->id)->where('updated_at', '>=', Carbon::today())->orderBy('status_login', 'DESC')->orderBy('updated_at', 'DESC')->get();

        if (Auth::user()->role == 1) {
            $jumlah_guru = Guru::all()->count();
            $jumlah_siswa = Siswa::where('status', 1)->count();

            $jumlah_siswa_shs = Siswa::where('status', 1)->where('tingkatan_id', 5)->count();
            $jumlah_siswa_jhs = Siswa::where('status', 1)->where('tingkatan_id', 4)->count();
            $jumlah_siswa_ps = Siswa::where('status', 1)->where('tingkatan_id', 3)->count();
            $jumlah_siswa_kg = Siswa::where('status', 1)->where('tingkatan_id', 2)->count();
            $jumlah_siswa_pg = Siswa::where('status', 1)->where('tingkatan_id', 2)->count();


            $jumlah_kelas = Kelas::where('tapel_id', $tapel->id)->count();

            $jumlah_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->count();

            return view('dashboard.admin', compact(
                'title',
                'data_pengumuman',
                'data_riwayat_login',
                'sekolah',
                'tapel',
                'jumlah_guru',
                'jumlah_siswa',
                'jumlah_siswa_shs',
                'jumlah_siswa_jhs',
                'jumlah_siswa_ps',
                'jumlah_siswa_kg',
                'jumlah_siswa_pg',
                'jumlah_kelas',
                'jumlah_ekstrakulikuler',
            ));
        } elseif (Auth::user()->role == 2) {
            $guru = Guru::where('karyawan_id', Auth::user()->karyawan->id)->first();

            // Dashboard Guru Mapel
            if (session()->get('akses_sebagai') == 'Guru Mapel') {
                $id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');

                $jumlah_kelas_diampu = count(Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->groupBy('kelas_id')->get());
                $jumlah_mapel_diampu = count(Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->groupBy('mapel_id')->get());

                $id_kelas_diampu = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->groupBy('kelas_id')->get('kelas_id');
                $jumlah_siswa_diampu = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->count();

                $jumlah_ekstrakulikuler_diampu = Ekstrakulikuler::where('pembina_id', $guru->id)->count();

                $data_capaian_penilaian = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->get();
                $data_capaian_penilaian_km = Pembelajaran::where('guru_id', $guru->id)->whereIn('kelas_id', $id_kelas)->where('status', 1)->get();

                // Capaian Penilaian KM
                foreach ($data_capaian_penilaian_km as $penilaian) {
                    $kkm = KmKkmMapel::where('mapel_id', $penilaian->mapel->id)->where('kelas_id', $penilaian->kelas_id)->first();

                    $term = Term::findorfail($penilaian->kelas->tingkatan->term_id);

                    $rencana_sumatif = RencanaNilaiSumatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get();
                    $penilaian->jumlah_rencana_sumatif = count($rencana_sumatif);

                    $rencana_formatif = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get();
                    $penilaian->jumlah_rencana_formatif = count($rencana_formatif);

                    $rencana_nilai_sumatif_id = RencanaNilaiSumatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get('id');
                    $sumatif_telah_dinilai = NilaiSumatif::whereIn('rencana_nilai_sumatif_id', $rencana_nilai_sumatif_id)->groupBy('rencana_nilai_sumatif_id')->get();
                    $penilaian->jumlah_sumatif_telah_dinilai = count($sumatif_telah_dinilai);

                    $rencana_nilai_formatif_id = RencanaNilaiFormatif::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->groupBy('kode_penilaian')->get('id');
                    $formatif_telah_dinilai = NilaiFormatif::whereIn('rencana_nilai_formatif_id', $rencana_nilai_formatif_id)->groupBy('rencana_nilai_formatif_id')->get();
                    $penilaian->jumlah_formatif_telah_dinilai = count($formatif_telah_dinilai);

                    $nilai_akhir_raport = KmNilaiAkhirRaport::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->get();
                    $penilaian->kirim_nilai_raport = count($nilai_akhir_raport);

                    $deskripsi_nilai_akhir = KmDeskripsiNilaiSiswa::where('term_id', $term->id)->where('pembelajaran_id', $penilaian->id)->get();
                    $penilaian->proses_deskripsi = count($deskripsi_nilai_akhir);

                    if (is_null($kkm)) {
                        $penilaian->kkm = null;
                    } else {
                        $penilaian->kkm = $kkm->kkm;
                    }
                }


                return view('dashboard.guru', compact(
                    'title',
                    'data_pengumuman',
                    'data_riwayat_login',
                    'sekolah',
                    'tapel',
                    'jumlah_kelas_diampu',
                    'jumlah_mapel_diampu',
                    'jumlah_siswa_diampu',
                    'jumlah_ekstrakulikuler_diampu',
                    'data_capaian_penilaian_km',
                    'data_capaian_penilaian',
                ));
            } elseif (session()->get('akses_sebagai') == 'Wali Kelas') {

                $id_kelas_diampu = Kelas::where('tapel_id', $tapel->id)->where('guru_id', $guru->id)->pluck('id')->toArray();
                $jumlah_anggota_kelas = count(AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)->get());

                $id_pembelajaran_kelas = Pembelajaran::whereIn('kelas_id', $id_kelas_diampu)->where('status', 1)->get('id');
                $jumlah_proses_deskripsi = count(KmDeskripsiNilaiSiswa::whereIn('pembelajaran_id', $id_pembelajaran_kelas)->groupBy('pembelajaran_id')->get());


                // Dashboard Wali Kelas
                return view('dashboard.walikelas', compact(
                    'title',
                    'data_pengumuman',
                    'data_riwayat_login',
                    'sekolah',
                    'tapel',
                    'jumlah_anggota_kelas',
                    'jumlah_kirim_nilai',
                    'jumlah_proses_deskripsi',
                    'id_kelas_diampu',
                ));
            }
        } elseif (Auth::user()->role == 3) {
            $siswa = Siswa::where('user_id', Auth::user()->id)->first();

            $data_id_kelas = Kelas::where('tapel_id', $tapel->id)->get('id');
            $data_id_ekstrakulikuler = Ekstrakulikuler::where('tapel_id', $tapel->id)->get('id');

            $anggota_kelas = AnggotaKelas::whereIn('kelas_id', $data_id_kelas)->where('siswa_id', $siswa->id)->first();
            if (is_null($anggota_kelas)) {
                $jumlah_ekstrakulikuler = '-';
                $jumlah_mapel = '-';
            } else {
                $jumlah_ekstrakulikuler = AnggotaEkstrakulikuler::where('anggota_kelas_id', $anggota_kelas->id)->whereIn('ekstrakulikuler_id', $data_id_ekstrakulikuler)->count();
                $jumlah_mapel = Pembelajaran::where('kelas_id', $anggota_kelas->kelas->id)->where('status', 1)->count();
            }

            return view('dashboard.siswa', compact(
                'title',
                'data_pengumuman',
                'data_riwayat_login',
                'sekolah',
                'tapel',
                'jumlah_ekstrakulikuler',
                'jumlah_mapel',
            ));
        }
    }
}
