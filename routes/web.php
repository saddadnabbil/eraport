<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Your custom unauthorized page
Route::get('/unauthorized', function () {
    $title = 'Unauthorized';
    return view('errorpage.401', compact('title'));
});

// Rute Fallback untuk 404
Route::fallback(function () {
    $title = 'Page Not Found';
    return view('errorpage.404', compact('title'));
});

Route::get('/', 'AuthController@index')
    ->name('login.get')
    ->middleware('guest');
Route::post('/', 'AuthController@store')->name('login');
Route::post('/settingtapel', 'AuthController@setting_tapel')->name('setting.tapel');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'AuthController@redirect')->name('logout.redirect');

    Route::post('/logout', 'AuthController@logout')->name('logout');
    Route::get('/password', 'AuthController@view_ganti_password')->name('gantipassword.get');
    Route::post('/password', 'AuthController@ganti_password')->name('gantipassword');

    Route::get('/profile', 'ProfileUserController@index')->name('profile');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Route User Admin
    Route::group(['middleware' => 'checkRole:1'], function () {
        Route::prefix('admin')->group(function () {
            // Profile Controller
            Route::resource('profileadmin', 'Admin\ProfileController')->only(['update']);

            // Pengumuman Controller
            Route::resource('pengumuman', 'Admin\PengumumanController')->only(['index', 'store', 'update', 'destroy']);

            // User Controller
            Route::get('user/export', 'Admin\UserController@export')->name('user.export');
            Route::resource('user', 'Admin\UserController')->only(['index', 'store', 'update', 'destroy']);
            Route::get('user/trash', 'Admin\UserController@showTrash')->name('user.trash');
            Route::delete('user/{id}/permanent-delete', 'Admin\UserController@destroyPermanent')->name('user.permanent-delete');
            Route::patch('user/{id}/restore', 'Admin\UserController@restore')->name('user.restore');

            // Sekolah Controller
            Route::resource('sekolah', 'Admin\SekolahController')->only(['index', 'update']);

            // Guru Controller
            Route::get('guru/export', 'Admin\GuruController@export')->name('guru.export');
            Route::get('guru/import', 'Admin\GuruController@format_import')->name('guru.format_import');
            Route::post('guru/import', 'Admin\GuruController@import')->name('guru.import');
            Route::resource('guru', 'Admin\GuruController')->only(['index', 'store', 'update', 'destroy']);
            Route::get('guru/trash', 'Admin\GuruController@showTrash')->name('guru.trash');
            Route::delete('guru/{id}/permanent-delete', 'Admin\GuruController@destroyPermanent')->name('guru.permanent-delete');
            Route::patch('guru/{id}/restore', 'Admin\GuruController@restore')->name('guru.restore');

            // Tapel Controller
            Route::resource('tapel', 'Admin\TapelController')->except(['create', 'edit']);

            // Tingkatan Controller
            Route::resource('tingkatan', 'Admin\TingkatanController')->only(['index', 'store', 'update', 'destroy']);

            // Jurusan Controller
            Route::resource('jurusan', 'Admin\JurusanController')->only(['index', 'store', 'update', 'destroy']);

            // Silabus Controller
            Route::resource('silabus', 'Admin\SilabusController')
                ->only(['index', 'store', 'update', 'destroy'])
                ->names([
                    'index' => 'admin.silabus.index',
                    'store' => 'admin.silabus.store',
                    'update' => 'admin.silabus.update',
                    'destroy' => 'admin.silabus.destroy',
                ]);
            Route::delete('/silabus/{id}/destroy/{fileType}', 'Admin\SilabusController@destroyFile')->name('admin.silabus.destroyFile');
            Route::get('/silabus/pdf/{filename}', 'Admin\PdfController@viewSilabusPDF')->name('admin.silabus.pdf.view');

            Route::post('tapel/set', 'Admin\TapelController@setAcademicYear')->name('tapel.setAcademicYear');

            Route::post('kelas/anggota', 'Admin\KelasController@store_anggota')->name('kelas.anggota');
            Route::delete('kelas/anggota/{anggota}', 'Admin\KelasController@delete_anggota')->name('kelas.anggota.delete');
            Route::post('kelas/anggota/{anggota}', 'Admin\KelasController@pindah_kelas')->name('kelas.anggota.pindah_kelas');
            Route::get('kelas/trash', 'Admin\KelasController@showTrash')->name('kelas.anggota_kelas.trash');
            Route::delete('kelas/{id}/permanent-delete', 'Admin\KelasController@destroyPermanent')->name('kelas.anggota_kelas.permanent-delete');
            Route::patch('kelas/{id}/restore', 'Admin\KelasController@restore')->name('kelas.anggota_kelas.restore');
            Route::resource('kelas', 'Admin\KelasController', [
                'uses' => ['index', 'store', 'show', 'destroy'],
            ]);

            Route::get('siswa/export', 'Admin\SiswaController@export')->name('siswa.export');
            Route::get('siswa/import', 'Admin\SiswaController@format_import')->name('siswa.format_import');
            Route::post('siswa/import', 'Admin\SiswaController@import')->name('siswa.import');
            Route::post('siswa/registrasi', 'Admin\SiswaController@registrasi')->name('siswa.registrasi');
            Route::post('siswa/activate', 'Admin\SiswaController@activate')->name('siswa.activate');
            Route::get('siswa/trash', 'Admin\SiswaController@showTrash')->name('siswa.trash');
            Route::delete('siswa/{id}/permanent-delete', 'Admin\SiswaController@destroyPermanent')->name('siswa.permanent-delete');
            Route::patch('siswa/{id}/restore', 'Admin\SiswaController@restore')->name('siswa.restore');
            Route::resource('siswa', 'Admin\SiswaController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);

            Route::get('/pdf/{filename}', 'Admin\PdfController@viewDocumentSiswaPDF')->name('document.siswa.pdf.view');

            Route::get('mapel/import', 'Admin\MapelController@format_import')->name('mapel.format_import');
            Route::post('mapel/import', 'Admin\MapelController@import')->name('mapel.import');
            Route::resource('mapel', 'Admin\MapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);
            Route::resource('mapel', 'Admin\MapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);
            Route::get('pembelajaran/export', 'Admin\PembelajaranController@export')->name('pembelajaran.export');
            Route::post('pembelajaran/settings', 'Admin\PembelajaranController@settings')->name('pembelajaran.settings');
            Route::resource('pembelajaran', 'Admin\PembelajaranController', [
                'uses' => ['index', 'store'],
            ]);
            Route::post('ekstrakulikuler/anggota', 'Admin\EkstrakulikulerController@store_anggota')->name('ekstrakulikuler.anggota');
            Route::delete('ekstrakulikuler/anggota/{anggota}', 'Admin\EkstrakulikulerController@delete_anggota')->name('ekstrakulikuler.anggota.delete');
            Route::resource('ekstrakulikuler', 'Admin\EkstrakulikulerController', [
                'uses' => ['index', 'store', 'show', 'destroy'],
            ]);

            Route::resource('rekapkehadiran', 'Admin\RekapKehadiranSiswaController', [
                'uses' => ['index', 'store'],
            ]);

            Route::resource('kehadiranadmin', 'Admin\KehadiranSiswaController', [
                'uses' => ['index', 'store', 'create'],
            ]);

            Route::resource('prestasiadmin', 'Admin\PrestasiSiswaController', [
                'uses' => ['index', 'create', 'store', 'update', 'destroy'],
            ]);

            Route::resource('catatanadmin', 'Admin\CatatanWaliKelasController', [
                'uses' => ['index', 'store', 'create'],
            ]);
            Route::resource('kenaikanadmin', 'Admin\KenaikanKelasController', [
                'uses' => ['index', 'store', 'create'],
            ]);

            Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas');
            Route::get('getKelasByTingkatan/ajax/{id}', 'AjaxController@ajax_kelas_by_tingkatan_id');
            Route::get('getAllSilabus/ajax/{id}', 'AjaxController@getAllSilabus')->name('admin.get.all.silabus');
            Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('get.pembelajaran.id');

            // Raport K13 Admin
            // Setting Raport K13
            Route::resource('mapping', 'Admin\K13\MapingMapelController', [
                'uses' => ['index', 'store'],
            ]);
            Route::get('kkm/import', 'Admin\K13\KkmMapelController@format_import')->name('kkm.format_import');
            Route::post('kkm/import', 'Admin\K13\KkmMapelController@import')->name('kkm.import');
            Route::resource('kkm', 'Admin\K13\KkmMapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);

            Route::resource('interval', 'Admin\K13\IntervalPredikatController', [
                'uses' => ['index'],
            ]);
            Route::get('sikap/import', 'Admin\K13\ButirSikapController@format_import')->name('sikap.format_import');
            Route::post('sikap/import', 'Admin\K13\ButirSikapController@import')->name('sikap.import');
            Route::resource('sikap', 'Admin\K13\ButirSikapController', [
                'uses' => ['index', 'store', 'update'],
            ]);
            Route::resource('kd', 'Admin\K13\KdMapelController', [
                'uses' => ['index', 'create', 'store', 'update', 'destroy'],
            ]);
            Route::resource('tglraport', 'Admin\K13\TglRaportController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);
            Route::resource('validasi', 'Admin\K13\ValidasiController', [
                'uses' => ['index'],
            ]);

            // Hasil Raport K13
            Route::resource('raportstatuspenilaian', 'Admin\K13\StatusPenilaianController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('pengelolaannilai', 'Admin\K13\PengelolaanNilaiController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('nilairaport', 'Admin\K13\NilaiRaportSemesterController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('adminleger', 'Admin\K13\LegerNilaiSiswaController', [
                'uses' => ['index', 'store', 'show'],
            ]);
            Route::resource('adminraportpts', 'Admin\K13\CetakRaportPTSController', [
                'uses' => ['index', 'store', 'show'],
            ]);
            Route::resource('adminraportsemester', 'Admin\K13\CetakRaportSemesterController', [
                'uses' => ['index', 'store', 'show'],
            ]);
            // End  Raport K13 Admin

            // Start Raport KM
            Route::delete('/cp/delete/{id}', 'Admin\KM\CapaianPembelajaranController@destroy')->name('admin.cp.destroy');
            Route::resource('cp', 'Admin\KM\CapaianPembelajaranController')->only(['index', 'store', 'update', 'create']);

            Route::resource('rencanaformatif', 'Admin\KM\RencanaNilaiFormatifController')->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

            Route::resource('rencanasumatif', 'Admin\KM\RencanaNilaiSumatifController')->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

            Route::resource('penilaiankm', 'Admin\KM\PenilaianKurikulumMerdekaController')->only(['index', 'create', 'store', 'show', 'edit', 'update']);

            Route::resource('nilaiterkirimkmadmin', 'Admin\KM\LihatNilaiTerkirimController', [
                'uses' => ['index', 'create'],
            ]);

            Route::resource('mappingkm', 'Admin\KM\MapingMapelController', [
                'uses' => ['index', 'store'],
            ]);

            Route::resource('tglraportkm', 'Admin\KM\TglRaportController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);

            Route::resource('kirimnilaiakhirkmadmin', 'Admin\KM\KirimNilaiAkhirController', [
                'uses' => ['index', 'create', 'store'],
            ]);

            Route::resource('prosesdeskripsikmadmin', 'Admin\KM\ProsesDeskripsiSiswaController', [
                'uses' => ['index', 'create', 'store'],
            ]);

            // Hasil Raport KM
            Route::resource('raportstatuspenilaiankm', 'Admin\KM\StatusPenilaianController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('pengelolaannilaikm', 'Admin\KM\PengelolaanNilaiController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('nilairaportkm', 'Admin\KM\NilaiRaportSemesterController', [
                'uses' => ['index', 'store'],
            ]);
            Route::resource('adminlegerkm', 'Admin\KM\LegerNilaiSiswaController', [
                'uses' => ['index', 'store', 'show'],
            ]);
            Route::resource('adminraportptskm', 'Admin\KM\CetakRaportPTSController', [
                'uses' => ['index', 'store', 'show'],
            ]);
            Route::resource('adminraportsemesterkm', 'Admin\KM\CetakRaportSemesterController', [
                'uses' => ['index', 'store', 'show'],
            ]);

            Route::get('getKelas/ekstra/{id}', 'AjaxController@ajax_kelas_ekstra');
            Route::resource('nilaiekstraadmin', 'Admin\NilaiEkstrakulikulerController', [
                'uses' => ['index', 'create', 'store'],
            ]);

            Route::get('kkmadmin/import', 'Admin\KM\KkmMapelController@format_import')->name('kkmadmin.format_import');
            Route::post('kkmadmin/import', 'Admin\KM\KkmMapelController@import')->name('kkmadmin.import');
            Route::resource('kkmadmin', 'Admin\KM\KkmMapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);
            // End Raport KM

            // Karyawan
            Route::resource('statuskaryawan', 'Admin\StatusKaryawanController', [
                'uses' => ['index', 'update', 'destroy'],
            ]);
            Route::resource('unitkaryawan', 'Admin\UnitKaryawanController', [
                'uses' => ['index', 'update', 'destroy'],
            ]);
            Route::resource('positionkaryawan', 'Admin\PositionKaryawanController', [
                'uses' => ['index', 'update', 'destroy'],
            ]);

            Route::get('karyawan/export', 'Admin\KaryawanController@export')->name('karyawan.export');
            Route::get('karyawan/import', 'Admin\KaryawanController@format_import')->name('karyawan.format_import');
            Route::post('karyawan/import', 'Admin\KaryawanController@import')->name('karyawan.import');
            Route::get('karyawan/trash', 'Admin\KaryawanController@showTrash')->name('karyawan.trash');
            Route::delete('karyawan/{id}/permanent-delete', 'Admin\KaryawanController@destroyPermanent')->name('karyawan.permanent-delete');
            Route::post('karyawan/{id}/restore', 'Admin\KaryawanController@restore')->name('karyawan.restore');
            Route::post('karyawan/activate', 'Admin\KaryawanController@activate')->name('karyawan.activate');
            Route::post('karyawan/nonactivate', 'Admin\KaryawanController@nonActivate')->name('karyawan.nonactivate');

            Route::get('karyawan/{id}', 'Admin\KaryawanController@show')->name('karyawan.show');

            Route::resource('karyawan', 'Admin\KaryawanController', [
                'only' => ['index', 'store', 'update', 'destroy'],
            ]);
        });
    });
    // End Route User Admin

    // Route User Guru
    Route::group(['middleware' => 'checkRole:2'], function () {
        Route::group(['prefix' => 'guru'], function () {
            Route::resource('profileguru', 'Guru\ProfileController', [
                'uses' => ['update'],
            ]);

            Route::get('akses', 'AuthController@ganti_akses')->name('akses');

            // Route Guru Mapel
            Route::group(['middleware' => 'checkAksesGuru:Guru Mapel'], function () {
                Route::get('kkmguru/import', 'Guru\KM\KkmMapelController@format_import')->name('kkmguru.format_import');
                Route::post('kkmguru/import', 'Guru\KM\KkmMapelController@import')->name('kkmguru.import');
                Route::resource('kkmguru', 'Guru\KM\KkmMapelController', [
                    'uses' => ['index', 'store', 'update', 'destroy'],
                ]);

                Route::delete('/cp/delete/{id}', 'Guru\KM\CapaianPembelajaranController@destroy')->name('guru.cp.destroy');
                Route::resource('cp', 'Guru\KM\CapaianPembelajaranController')->names([
                    'index' => 'guru.cp.index',
                    'create' => 'guru.cp.create',
                    'store' => 'guru.cp.store',
                    'update' => 'guru.cp.update',
                ]);

                Route::resource('rencanaformatif', 'Guru\KM\RencanaNilaiFormatifController')->names([
                    'index' => 'guru.rencanaformatif.index',
                    'create' => 'guru.rencanaformatif.create',
                    'store' => 'guru.rencanaformatif.store',
                    'show' => 'guru.rencanaformatif.show',
                    'edit' => 'guru.rencanaformatif.edit',
                    'update' => 'guru.rencanaformatif.update',
                    'destroy' => 'guru.rencanaformatif.destroy',
                ]);

                Route::resource('rencanasumatif', 'Guru\KM\RencanaNilaiSumatifController')->names([
                    'index' => 'guru.rencanasumatif.index',
                    'create' => 'guru.rencanasumatif.create',
                    'store' => 'guru.rencanasumatif.store',
                    'show' => 'guru.rencanasumatif.show',
                    'edit' => 'guru.rencanasumatif.edit',
                    'update' => 'guru.rencanasumatif.update',
                    'destroy' => 'guru.rencanasumatif.destroy',
                ]);

                Route::resource('penilaiankm', 'Guru\KM\PenilaianKurikulumMerdekaController')->names([
                    'index' => 'guru.penilaiankm.index',
                    'create' => 'guru.penilaiankm.create',
                    'store' => 'guru.penilaiankm.store',
                    'show' => 'guru.penilaiankm.show',
                    'edit' => 'guru.penilaiankm.edit',
                    'update' => 'guru.penilaiankm.update',
                    'destroy' => 'guru.penilaiankm.destroy',
                ]);

                Route::resource('prosesdeskripsikm', 'Guru\KM\ProsesDeskripsiSiswaController', [
                    'uses' => ['index', 'create', 'store'],
                ]);

                Route::get('getKelas/ekstra/{id}', 'AjaxController@ajax_kelas_ekstra');

                Route::resource('nilaiekstra', 'Guru\NilaiEkstrakulikulerController', [
                    'uses' => ['index', 'create', 'store'],
                ]);

                // Raport K13 Guru
                Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas_silabus');
                Route::get('getAllSilabus/ajax/{id}', 'AjaxController@getAllSilabus')->name('guru.get.all.silabus');
                // Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas');

                Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('guru.get.pembelajaran.id');

                Route::resource('silabus', 'Guru\SilabusController')
                    ->only(['index', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'guru.silabus.index',
                        'store' => 'guru.silabus.store',
                        'update' => 'guru.silabus.update',
                        'destroy' => 'guru.silabus.destroy',
                    ]);
                Route::delete('/silabus/{id}/destroy/{fileType}', 'Guru\SilabusController@destroyFile')->name('guru.silabus.destroyFile');

                Route::get('/pdf/{filename}', 'Admin\PdfController@viewSilabusPDF')->name('silabus.guru.pdf.view');

                Route::resource('kdk13', 'Guru\K13\KdMapelController', [
                    'uses' => ['index', 'create', 'store', 'update', 'destroy'],
                ]);

                Route::resource('rencanapengetahuan', 'Guru\K13\RencanaNilaiPengetahuanController', [
                    'uses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
                ]);
                Route::resource('rencanaketerampilan', 'Guru\K13\RencanaNilaiKeterampilanController', [
                    'uses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
                ]);
                Route::resource('rencanaspiritual', 'Guru\K13\RencanaNilaiSpiritualController', [
                    'uses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
                ]);
                Route::resource('rencanasosial', 'Guru\K13\RencanaNilaiSosialController', [
                    'uses' => ['index', 'create', 'store', 'show', 'edit', 'update'],
                ]);
                Route::resource('bobotnilai', 'Guru\K13\RencanaBobotPenilaianController', [
                    'uses' => ['index', 'store', 'update'],
                ]);

                // Import Nilai
                Route::get('nilaipengetahuan/import', 'Guru\K13\NilaiPengetahuanController@format_import')->name('nilaipengetahuan.format_import');
                Route::post('nilaipengetahuan/import', 'Guru\K13\NilaiPengetahuanController@import')->name('nilaipengetahuan.import');

                Route::get('nilaiketerampilan/import', 'Guru\K13\NilaiKeterampilanController@format_import')->name('nilaiketerampilan.format_import');
                Route::post('nilaiketerampilan/import', 'Guru\K13\NilaiKeterampilanController@import')->name('nilaiketerampilan.import');

                Route::get('nilaispiritual/import', 'Guru\K13\NilaiSpiritualController@format_import')->name('nilaispiritual.format_import');
                Route::post('nilaispiritual/import', 'Guru\K13\NilaiSpiritualController@import')->name('nilaispiritual.import');

                Route::get('nilaisosial/import', 'Guru\K13\NilaiSosialController@format_import')->name('nilaisosial.format_import');
                Route::post('nilaisosial/import', 'Guru\K13\NilaiSosialController@import')->name('nilaisosial.import');

                Route::get('nilaiptspas/import', 'Guru\K13\NilaiPtsPasController@format_import')->name('nilaiptspas.format_import');
                Route::post('nilaiptspas/import', 'Guru\K13\NilaiPtsPasController@import')->name('nilaiptspas.import');

                // End Import Nilai
                Route::resource('nilaipengetahuan', 'Guru\K13\NilaiPengetahuanController', [
                    'uses' => ['index', 'create', 'store', 'update'],
                ]);
                Route::resource('nilaiketerampilan', 'Guru\K13\NilaiKeterampilanController', [
                    'uses' => ['index', 'create', 'store', 'update'],
                ]);
                Route::resource('nilaispiritual', 'Guru\K13\NilaiSpiritualController', [
                    'uses' => ['index', 'create', 'store', 'update'],
                ]);
                Route::resource('nilaisosial', 'Guru\K13\NilaiSosialController', [
                    'uses' => ['index', 'create', 'store', 'update'],
                ]);
                Route::resource('nilaiptspas', 'Guru\K13\NilaiPtsPasController', [
                    'uses' => ['index', 'create', 'store', 'update'],
                ]);

                Route::resource('kirimnilaiakhir', 'Guru\K13\KirimNilaiAkhirController', [
                    'uses' => ['index', 'create', 'store'],
                ]);

                Route::resource('kirimnilaiakhirkm', 'Guru\KM\KirimNilaiAkhirController', [
                    'uses' => ['index', 'create', 'store'],
                ]);

                Route::resource('nilaiterkirim', 'Guru\K13\LihatNilaiTerkirimController', [
                    'uses' => ['index', 'create'],
                ]);

                Route::resource('nilaiterkirimkm', 'Guru\KM\LihatNilaiTerkirimController', [
                    'uses' => ['index', 'create'],
                ]);

                Route::resource('prosesdeskripsi', 'Guru\K13\ProsesDeskripsiSiswaController', [
                    'uses' => ['index', 'create', 'store'],
                ]);
                // End  Raport K13 Guru
            });
            // End Route Guru Mapel

            //Route Wali Kelas
            Route::group(['middleware' => 'checkAksesGuru:Wali Kelas'], function () {
                Route::resource('pesertadidik', 'Walikelas\PesertaDidikController', [
                    'uses' => ['index'],
                ]);
                Route::resource('kehadiran', 'Walikelas\KehadiranSiswaController', [
                    'uses' => ['index', 'store'],
                ]);
                Route::resource('prestasi', 'Walikelas\PrestasiSiswaController', [
                    'uses' => ['index', 'store', 'update', 'destroy'],
                ]);
                Route::resource('catatan', 'Walikelas\CatatanWaliKelasController', [
                    'uses' => ['index', 'store'],
                ]);
                Route::resource('kenaikan', 'Walikelas\KenaikanKelasController', [
                    'uses' => ['index', 'store'],
                ]);

                // Raport K13 Wali Kelas
                // Route::resource('prosesdeskripsisikap', 'Walikelas\K13\ProsesDeskripsiSikapController',  [
                //   'uses' => ['index', 'store']
                // ]);
                // Route::resource('statusnilaiguru', 'Walikelas\K13\StatusPenilaianGuruController',  [
                //   'uses' => ['index']
                // ]);
                // Route::resource('hasilnilai', 'Walikelas\K13\HasilPengelolaanNilaiController',  [
                //   'uses' => ['index']
                // ]);
                // Route::get('leger/export', 'Walikelas\K13\LihatLegerNilaiController@export')->name('leger.export');
                // Route::resource('leger', 'Walikelas\K13\LihatLegerNilaiController',  [
                //   'uses' => ['index']
                // ]);

                Route::resource('raportpts', 'Walikelas\K13\CetakRaportPTSController', [
                    'uses' => ['index', 'store', 'show'],
                ]);
                Route::resource('raportsemester', 'Walikelas\K13\CetakRaportSemesterController', [
                    'uses' => ['index', 'store', 'show'],
                ]);
                // End  Raport K13 Wali Kelas

                // Raport KM Wali Kelas
                Route::resource('prosesdeskripsisikap', 'Walikelas\K13\ProsesDeskripsiSikapController', [
                    'uses' => ['index', 'store'],
                ]);
                Route::resource('statusnilaiguru', 'Walikelas\KM\StatusPenilaianController', [
                    'uses' => ['index'],
                ]);
                Route::resource('hasilnilai', 'Walikelas\KM\PengelolaanNilaiController', [
                    'uses' => ['index'],
                ]);
                Route::resource('nilairaportkmwalas', 'Admin\KM\NilaiRaportSemesterController', [
                    'uses' => ['index', 'store'],
                ]);

                Route::resource('leger', 'Walikelas\KM\LegerNilaiSiswaController', [
                    'uses' => ['index', 'show'],
                ]);

                Route::resource('raportptskm', 'Walikelas\KM\CetakRaportPTSController', [
                    'uses' => ['index', 'show'],
                ]);

                Route::resource('raportsemesterkm', 'Walikelas\KM\CetakRaportSemesterController', [
                    'uses' => ['index', 'show'],
                ]);
                // End  Raport KM Wali Kelas
            });
            // End Route Wali Kelas
        });
    });
    // End Route User Guru

    // Route User Siswa
    Route::resource('profilesiswa', 'Siswa\ProfileController', [
        'uses' => ['update'],
    ]);
    Route::resource('ekstra', 'Siswa\EkstrakulikulerController', [
        'uses' => ['index'],
    ]);
    Route::resource('presensi', 'Siswa\RekapKehadiranController', [
        'uses' => ['index'],
    ]);

    Route::resource('silabus', 'Siswa\SilabusController')
        ->only(['index'])
        ->names([
            'index' => 'siswa.silabus.index',
        ]);
    Route::get('/pdf/{filename}', 'Admin\PdfController@viewSilabusPDF')->name('silabus.siswa.pdf.view');

    // Raport K13 Siswa
    Route::resource('nilaiakhir', 'Siswa\K13\NilaiAkhirSemesterController', [
        'uses' => ['index'],
    ]);
    // End  Raport K13 Siswa
    // End Route User Siswa
});
