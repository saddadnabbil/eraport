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

Route::get('/404', function () {
    $title = 'Page Not Found';
    return view('errorpage.404', compact('title'));
})->name('404');

Route::get('forbidden', function () {
    return view('errorpage.403');
})->name('forbidden');

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

    // Start Route Admin
    Route::group(['middleware' => 'role:Admin'], function () {
        Route::prefix('admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas')->name('admin.get.kelas');
            Route::get('getKelas/penilaian-tk/{id}', 'AjaxController@getClassByTkTopic');
            Route::get('getKelasByTingkatan/ajax/{id}', 'AjaxController@ajax_kelas_by_tingkatan_id');
            Route::get('getAllSilabus/ajax/{id}', 'AjaxController@getAllSilabus')->name('admin.get.all.silabus');
            Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('get.pembelajaran.id');
            Route::get('getKelas/ekstra/{id}', 'AjaxController@ajax_kelas_ekstra')->name('admin.get.kelas.ekstra');
            // User 
            Route::prefix('user')->group(function () {
                Route::resource('user', 'Admin\UserController')
                    ->only(['index', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'user.index',
                        'store' => 'user.store',
                        'update' => 'user.update',
                        'destroy' => 'user.destroy',
                    ])
                    ->parameters([
                        'index' => '',
                        'store' => '',
                        'update' => '{user}',
                        'destroy' => '{user}',
                    ]);
                Route::get('user/data', 'Admin\UserController@data')->name('user.data');
                Route::get('user/{id}', 'Admin\UserController@getUser')->name('user.get');
                Route::get('user/export', 'Admin\UserController@export')->name('user.export');
                Route::get('user/trash', 'Admin\UserController@showTrash')->name('user.trash');
                Route::delete('user/{id}/permanent-delete', 'Admin\UserController@destroyPermanent')->name('user.permanent-delete');
                Route::patch('user/{id}/restore', 'Admin\UserController@restore')->name('user.restore');

                // Role Controller
                Route::resource('role', 'Admin\RoleController')->only(['index', 'store', 'update', 'destroy']);
                Route::resource('permission', 'Admin\PermissionController')->only(['index', 'store', 'update', 'destroy']);

                // Karyawan
                Route::prefix('karyawan')->group(function () {
                    Route::resource('statuskaryawan', 'Admin\StatusKaryawanController', [
                        'only' => ['index', 'update', 'destroy', 'store'],
                    ]);
                    Route::resource('unitkaryawan', 'Admin\UnitKaryawanController', [
                        'only' => ['index', 'update', 'destroy', 'store'],
                    ]);
                    Route::resource('positionkaryawan', 'Admin\PositionKaryawanController', [
                        'only' => ['index', 'update', 'destroy', 'store'],
                    ]);

                    Route::get('karyawan/data', 'Admin\KaryawanController@data')->name('karyawan.data');
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

            // Master Data
            Route::prefix('master-data')->group(function () {
                // Pengumuman Controller
                Route::resource('pengumuman', 'Admin\PengumumanController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'admin.pengumuman.index',
                    'store' => 'admin.pengumuman.store',
                    'update' => 'admin.pengumuman.update',
                    'destroy' => 'admin.pengumuman.destroy',
                ]);

                // Sekolah Controller
                Route::resource('sekolah', 'Admin\SekolahController')->only(['index', 'update'])->names([
                    'index' => 'admin.sekolah.index',
                    'update' => 'admin.sekolah.update',
                ]);

                // Academic Year Controller
                Route::resource('tapel', 'Admin\TapelController')->except(['create', 'edit'])->names([
                    'index' => 'admin.tapel.index',
                    'store' => 'admin.tapel.store',
                    'show' => 'admin.tapel.show',
                    'update' => 'admin.tapel.update',
                    'destroy' => 'admin.tapel.destroy',
                ]);
                Route::post('tapel/set', 'Admin\TapelController@setAcademicYear')->name('admin.tapel.setAcademicYear');

                // Siswa Controller
                Route::get('siswa/export', 'Admin\SiswaController@export')->name('admin.siswa.export');
                Route::get('siswa/data', 'Admin\SiswaController@data')->name('admin.siswa.data');
                Route::get('siswa/import', 'Admin\SiswaController@format_import')->name('admin.siswa.format_import');
                Route::post('siswa/import', 'Admin\SiswaController@import')->name('admin.siswa.import');
                Route::post('siswa/registrasi', 'Admin\SiswaController@registrasi')->name('admin.siswa.registrasi');
                Route::post('siswa/activate', 'Admin\SiswaController@activate')->name('admin.siswa.activate');
                Route::get('siswa/trash', 'Admin\SiswaController@showTrash')->name('admin.siswa.trash');
                Route::delete('siswa/{id}/permanent-delete', 'Admin\SiswaController@destroyPermanent')->name('admin.siswa.permanent-delete');
                Route::patch('siswa/{id}/restore', 'Admin\SiswaController@restore')->name('admin.siswa.restore');
                Route::resource('siswa', 'Admin\SiswaController', [
                    'only' => ['index', 'store', 'update', 'destroy', 'show'],
                ])->names([
                    'index' => 'admin.siswa.index',
                    'store' => 'admin.siswa.store',
                    'update' => 'admin.siswa.update',
                    'destroy' => 'admin.siswa.destroy',
                    'show' => 'admin.siswa.show',
                ]);

                // Guru Controller
                Route::get('teacher/data', 'Admin\GuruController@data')->name('admin.guru.data');
                Route::get('teacher/export', 'Admin\GuruController@export')->name('admin.guru.export');
                Route::get('teacher/import', 'Admin\GuruController@format_import')->name('admin.guru.format_import');
                Route::post('teacher/import', 'Admin\GuruController@import')->name('admin.guru.import');
                Route::resource('guru', 'Admin\GuruController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'admin.guru.index',
                    'store' => 'admin.guru.store',
                    'update' => 'admin.guru.update',
                    'destroy' => 'admin.guru.destroy',
                ]);
                Route::get('teacher/trash', 'Admin\GuruController@showTrash')->name('admin.guru.trash');
                Route::delete('teacher/{id}/permanent-delete', 'Admin\GuruController@destroyPermanent')->name('admin.guru.permanent-delete');
                Route::patch('teacher/{id}/restore', 'Admin\GuruController@restore')->name('admin.guru.restore');

                // Tingkatan Controller
                Route::resource('tingkatan', 'Admin\TingkatanController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'admin.tingkatan.index',
                    'store' => 'admin.tingkatan.store',
                    'update' => 'admin.tingkatan.update',
                    'destroy' => 'admin.tingkatan.destroy',
                ]);

                // Jurusan Controller
                Route::resource('jurusan', 'Admin\JurusanController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'admin.jurusan.index',
                    'store' => 'admin.jurusan.store',
                    'update' => 'admin.jurusan.update',
                    'destroy' => 'admin.jurusan.destroy',
                ]);

                // Mapel Controller
                Route::get('mapel/import', 'Admin\MapelController@format_import')->name('admin.mapel.format_import');
                Route::post('mapel/import', 'Admin\MapelController@import')->name('admin.mapel.import');
                Route::resource('mapel', 'Admin\MapelController', [
                    'only' => ['index', 'store', 'update', 'destroy'],
                ])->names([
                    'index' => 'admin.mapel.index',
                    'store' => 'admin.mapel.store',
                    'update' => 'admin.mapel.update',
                    'destroy' => 'admin.mapel.destroy',
                ]);

                Route::post('kelas/anggota', 'Admin\KelasController@store_anggota')->name('admin.kelas.anggota');
                Route::delete('kelas/anggota/{anggota}', 'Admin\KelasController@delete_anggota')->name('admin.kelas.anggota.delete');
                Route::post('kelas/anggota/{anggota}', 'Admin\KelasController@pindah_kelas')->name('admin.kelas.anggota.pindah_kelas');
                Route::get('kelas/{id}/trash', 'Admin\KelasController@showTrash')->name('admin.kelas.anggota_kelas.trash');
                Route::delete('kelas/{id}/permanent-delete', 'Admin\KelasController@destroyPermanent')->name('admin.kelas.anggota_kelas.permanent-delete');
                Route::patch('kelas/{id}/restore', 'Admin\KelasController@restore')->name('admin.kelas.anggota_kelas.restore');
                Route::resource('kelas', 'Admin\KelasController', [
                    'only' => ['index', 'store', 'show', 'destroy', 'update'],
                ])->names([
                    'index' => 'admin.kelas.index',
                    'store' => 'admin.kelas.store',
                    'show' => 'admin.kelas.show',
                    'destroy' => 'admin.kelas.destroy',
                    'update' => 'admin.kelas.update',
                ]);

                Route::get('pembelajaran/export', 'Admin\PembelajaranController@export')->name('admin.pembelajaran.export');
                Route::post('pembelajaran/settings', 'Admin\PembelajaranController@settings')->name('admin.pembelajaran.settings');
                Route::resource('pembelajaran', 'Admin\PembelajaranController', [
                    'only' => ['index', 'store'],
                ])->names([
                    'index' => 'admin.pembelajaran.index',
                    'store' => 'admin.pembelajaran.store',
                ]);

                Route::post('ekstrakulikuler/anggota', 'Admin\EkstrakulikulerController@store_anggota')->name('admin.ekstrakulikuler.anggota');
                Route::delete('ekstrakulikuler/anggota/{anggota}', 'Admin\EkstrakulikulerController@delete_anggota')->name('admin.ekstrakulikuler.anggota.delete');
                Route::resource('ekstrakulikuler', 'Admin\EkstrakulikulerController', [
                    'only' => ['index', 'store', 'show', 'destroy', 'update'],
                ])->names([
                    'index' => 'admin.ekstrakulikuler.index',
                    'store' => 'admin.ekstrakulikuler.store',
                    'show' => 'admin.ekstrakulikuler.show',
                    'destroy' => 'admin.ekstrakulikuler.destroy',
                    'update' => 'admin.ekstrakulikuler.update',
                ]);

                // Timeslot
                Route::get('timeslot', 'Admin\JadwalPelajaranController@timeSlot')->name('admin.timeslot.index');
                Route::post('timeslot', 'Admin\JadwalPelajaranController@storeTimeSlot')->name('admin.timeslot.store');
                Route::put('timeslot/update/{id}', 'Admin\JadwalPelajaranController@updateTimeSlot')->name('admin.timeslot.update');
                Route::delete('timeslot/{id}', 'Admin\JadwalPelajaranController@deleteTimeSlot')->name('admin.timeslot.destroy');

                Route::resource('jadwalpelajaran', 'Admin\JadwalPelajaranController', [
                    'only' => ['index', 'create', 'store', 'show'],
                ])->names([
                    'index' => 'admin.jadwalpelajaran.index',
                    'create' => 'admin.jadwalpelajaran.create',
                    'store' => 'admin.jadwalpelajaran.store',
                    'show' => 'admin.jadwalpelajaran.show',
                ]);

                Route::get('jadwalpelajaran/{id}/build', 'Admin\JadwalPelajaranController@build')->name('admin.jadwalpelajaran.build');
                Route::post('jadwalpelajaran/manage', 'Admin\JadwalPelajaranController@manage')->name('admin.jadwalpelajaran.manage');
                Route::put('jadwalpelajaran/{id}/manage', 'Admin\JadwalPelajaranController@manageUpdate')->name('admin.jadwalpelajaran.manage.update');
                Route::get('jadwalpelajaran/{id}/print', 'Admin\JadwalPelajaranController@print')->name('admin.jadwalpelajaran.print');

                Route::resource('jadwalmengajar', 'Admin\JadwalMengajarController', [
                    'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy'],
                ])->names([
                    'index' => 'admin.jadwalmengajar.index',
                    'create' => 'admin.jadwalmengajar.create',
                    'store' => 'admin.jadwalmengajar.store',
                    'show' => 'admin.jadwalmengajar.show',
                    'edit' => 'admin.jadwalmengajar.edit',
                    'destroy' => 'admin.jadwalmengajar.destroy',
                ]);

                Route::get('jadwalmengajar/{id}/build', 'Admin\JadwalMengajarController@build')->name('admin.jadwalmengajar.build');
                Route::post('jadwalmengajar/manage', 'Admin\JadwalMengajarController@manage')->name('admin.jadwalmengajar.manage');
                Route::put('jadwalmengajar/{id}/manage', 'Admin\JadwalMengajarController@manageUpdate')->name('admin.jadwalmengajar.manage.update');
                Route::get('jadwalmengajar/{id}/print', 'Admin\JadwalMengajarController@print')->name('admin.jadwalmengajar.print');

                // Silabus Controller
                Route::resource('silabus', 'Admin\SilabusController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'admin.silabus.index',
                    'store' => 'admin.silabus.store',
                    'update' => 'admin.silabus.update',
                    'destroy' => 'admin.silabus.destroy',
                ]);
                Route::delete('/silabus/{id}/destroy/{fileType}', 'Admin\SilabusController@destroyFile')->name('admin.silabus.destroyFile');
                Route::get('/silabus/pdf/{filename}', 'Admin\PdfController@viewSilabusPDF')->name('admin.silabus.pdf.view');
            });

            // Start KM
            Route::prefix('km')->group(function () {
                Route::resource('rekap-kehadiran', 'Admin\RekapKehadiranSiswaController', [
                    'only' => ['index', 'store'],
                ])->names([
                    'index' => 'km.rekapkehadiran.index',
                    'store' => 'km.rekapkehadiran.store',
                ]);

                Route::resource('kehadiran', 'Admin\KehadiranSiswaController', [
                    'only' => ['index', 'store', 'create'],
                ])->names([
                    'index' => 'km.kehadiran.index',
                    'store' => 'km.kehadiran.store',
                    'create' => 'km.kehadiran.create',
                ]);

                Route::resource('prestasi', 'Admin\PrestasiSiswaController', [
                    'only' => ['index', 'create', 'store', 'update', 'destroy'],
                ])->names([
                    'index' => 'km.prestasi.index',
                    'create' => 'km.prestasi.create',
                    'store' => 'km.prestasi.store',
                    'update' => 'km.prestasi.update',
                    'destroy' => 'km.prestasi.destroy',
                ]);

                Route::resource('catatan', 'Admin\CatatanWaliKelasController', [
                    'only' => ['index', 'store', 'create'],
                ])->names([
                    'index' => 'km.catatan.index',
                    'store' => 'km.catatan.store',
                    'create' => 'km.catatan.create',
                ]);

                Route::resource('kenaikan', 'Admin\KenaikanKelasController', [
                    'only' => ['index', 'store', 'create'],
                ])->names([
                    'index' => 'km.kenaikan.index',
                    'store' => 'km.kenaikan.store',
                    'create' => 'km.kenaikan.create',
                ]);

                // Start Raport KM
                Route::delete('cp/delete/{id}', 'Admin\KM\CapaianPembelajaranController@destroy')->name('km.cp.destroy');
                Route::resource('cp', 'Admin\KM\CapaianPembelajaranController')->only(['index', 'store', 'update', 'create'])->names([
                    'index' => 'km.cp.index',
                    'store' => 'km.cp.store',
                    'update' => 'km.cp.update',
                    'create' => 'km.cp.create',
                ]);

                Route::resource('rencanaformatif', 'Admin\KM\RencanaNilaiFormatifController')->only(['index', 'store', 'show', 'edit', 'update', 'destroy', 'create'])->names([
                    'index' => 'km.rencanaformatif.index',
                    'store' => 'km.rencanaformatif.store',
                    'show' => 'km.rencanaformatif.show',
                    'edit' => 'km.rencanaformatif.edit',
                    'update' => 'km.rencanaformatif.update',
                    'destroy' => 'km.rencanaformatif.destroy',
                    'create' => 'km.rencanaformatif.create',
                ]);

                Route::resource('rencanasumatif', 'Admin\KM\RencanaNilaiSumatifController')->only(['index', 'store', 'show', 'edit', 'update', 'destroy', 'create'])->names([
                    'index' => 'km.rencanasumatif.index',
                    'store' => 'km.rencanasumatif.store',
                    'show' => 'km.rencanasumatif.show',
                    'edit' => 'km.rencanasumatif.edit',
                    'update' => 'km.rencanasumatif.update',
                    'destroy' => 'km.rencanasumatif.destroy',
                    'create' => 'km.rencanasumatif.create',
                ]);

                Route::resource('penilaian', 'Admin\KM\PenilaianKurikulumMerdekaController')->only(['index', 'create', 'store', 'show', 'edit', 'update'])->names([
                    'index' => 'km.penilaian.index',
                    'create' => 'km.penilaian.create',
                    'store' => 'km.penilaian.store',
                    'show' => 'km.penilaian.show',
                    'edit' => 'km.penilaian.edit',
                    'update' => 'km.penilaian.update',
                ]);

                Route::resource('nilai-terkirim', 'Admin\KM\LihatNilaiTerkirimController')->only(['index', 'create'])->names([
                    'index' => 'km.nilaiterkirim.index',
                    'create' => 'km.nilaiterkirim.create',
                ]);

                Route::resource('mapping', 'Admin\KM\MapingMapelController')->only(['index', 'store'])->names([
                    'index' => 'km.mapping.index',
                    'store' => 'km.mapping.store',
                ]);

                Route::resource('tgl-raport', 'Admin\KM\TglRaportController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'km.tglraport.index',
                    'store' => 'km.tglraport.store',
                    'update' => 'km.tglraport.update',
                    'destroy' => 'km.tglraport.destroy',
                ]);

                Route::resource('kirim-nilai-akhir', 'Admin\KM\KirimNilaiAkhirController')->only(['index', 'create', 'store'])->names([
                    'index' => 'km.kirimnilaiakhir.index',
                    'create' => 'km.kirimnilaiakhir.create',
                    'store' => 'km.kirimnilaiakhir.store',
                ]);

                Route::resource('proses-deskripsi', 'Admin\KM\ProsesDeskripsiSiswaController')->only(['index', 'create', 'store'])->names([
                    'index' => 'km.prosesdeskripsi.index',
                    'create' => 'km.prosesdeskripsi.create',
                    'store' => 'km.prosesdeskripsi.store',
                ]);

                // Hasil Raport KM
                Route::resource('raport-status-penilaian', 'Admin\KM\StatusPenilaianController', [
                    'only' => ['index', 'store'],
                ])->names([
                    'index' => 'km.raport-status-penilaian.index',
                    'store' => 'km.raport-status-penilaian.store',
                ]);

                Route::resource('pengelolaannilai', 'Admin\KM\PengelolaanNilaiController', [
                    'only' => ['index', 'store'],
                ])->names([
                    'index' => 'km.pengelolaannilai.index',
                    'store' => 'km.pengelolaannilai.store',
                ]);

                Route::resource('nilairaport', 'Admin\KM\NilaiRaportSemesterController', [
                    'only' => ['index', 'store'],
                ])->names([
                    'index' => 'km.nilairaport.index',
                    'store' => 'km.nilairaport.store',
                ]);

                Route::resource('leger', 'Admin\KM\LegerNilaiSiswaController', [
                    'only' => ['index', 'store', 'show'],
                ])->names([
                    'index' => 'km.leger.index',
                    'store' => 'km.leger.store',
                    'show' => 'km.leger.show',
                ]);

                Route::resource('raportpts', 'Admin\KM\CetakRaportPTSController', [
                    'only' => ['index', 'store', 'show'],
                ])->names([
                    'index' => 'km.raportpts.index',
                    'store' => 'km.raportpts.store',
                    'show' => 'km.raportpts.show',
                ]);

                Route::resource('raportsemester', 'Admin\KM\CetakRaportSemesterController', [
                    'only' => ['index', 'store', 'show'],
                ])->names([
                    'index' => 'km.raportsemester.index',
                    'store' => 'km.raportsemester.store',
                    'show' => 'km.raportsemester.show',
                ]);

                Route::get('raportsemester/export/{id}', 'Admin\KM\CetakRaportSemesterController@export')->name('km.raportsemester.export');

                Route::resource('nilaiekstra', 'Admin\NilaiEkstrakulikulerController', [
                    'only' => ['index', 'create', 'store'],
                ])->names([
                    'index' => 'km.nilaiekstra.index',
                    'create' => 'km.nilaiekstra.create',
                    'store' => 'km.nilaiekstra.store',
                ]);

                Route::get('kkm/import', 'Admin\KM\KkmMapelController@format_import')->name('km.kkm.format_import');
                Route::post('kkm/import', 'Admin\KM\KkmMapelController@import')->name('km.kkm.import');
                Route::resource('kkm', 'Admin\KM\KkmMapelController', [
                    'only' => ['index', 'store', 'update', 'destroy'],
                ])->names([
                    'index' => 'km.kkm.index',
                    'store' => 'km.kkm.store',
                    'update' => 'km.kkm.update',
                    'destroy' => 'km.kkm.destroy',
                ]);

                // P5BK
                Route::prefix('p5bk')->group(function () {
                    Route::resource('p5/dimensi', 'Admin\P5\P5DimensiController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'p5.dimensi.index',
                        'store' => 'p5.dimensi.store',
                        'update' => 'p5.dimensi.update',
                        'destroy' => 'p5.dimensi.destroy',
                    ]);
                    Route::resource('p5/element', 'Admin\P5\P5ElementController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'p5.element.index',
                        'store' => 'p5.element.store',
                        'update' => 'p5.element.update',
                        'destroy' => 'p5.element.destroy',
                    ]);
                    Route::resource('p5/subelement', 'Admin\P5\P5SubelementController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'p5.subelement.index',
                        'store' => 'p5.subelement.store',
                        'update' => 'p5.subelement.update',
                        'destroy' => 'p5.subelement.destroy',
                    ]);
                    Route::get('p5/subelement/data', 'Admin\P5\P5SubelementController@data')->name('p5.subelement.data');

                    Route::resource('p5/tema', 'Admin\P5\P5TemaController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'p5.tema.index',
                        'store' => 'p5.tema.store',
                        'update' => 'p5.tema.update',
                        'destroy' => 'p5.tema.destroy',
                    ]);
                    Route::resource('p5/project', 'Admin\P5\P5ProjectController')->only(['index', 'store', 'update', 'destroy', 'edit', 'show'])->names([
                        'index' => 'p5.project.index',
                        'store' => 'p5.project.store',
                        'update' => 'p5.project.update',
                        'edit' => 'p5.project.edit',
                        'show' => 'p5.project.show',
                        'destroy' => 'p5.project.destroy',
                    ]);
                    Route::post('p5/project/nilai/{id}', 'Admin\P5\P5ProjectController@nilai')->name('p5.project.nilai');
                    Route::resource('p5/raport', 'Admin\P5\CetakRaportP5Controller')->only(['index', 'store', 'show'])->names([
                        'index' => 'p5.raport.index',
                        'store' => 'p5.raport.store',
                        'show' => 'p5.raport.show',
                    ]);
                    Route::get('p5/raport/export/{id}', 'Admin\KM\CetakRaportSemesterController@export')->name('p5.raport.export');
                });
            });
            // End Raport KM

            Route::prefix('tk')->group(function () {
                Route::resource('kehadiran', 'Admin\TK\TkKehadiranSiswaController')->names([
                    'index' => 'tk.kehadiran.index',
                    'store' => 'tk.kehadiran.store',
                    'create' => 'tk.kehadiran.create',
                ]);

                // Timeslot
                Route::get('timeslot', 'Admin\TK\TkJadwalPelajaranController@timeSlot')->name('admin.tk.timeslot.index');
                Route::post('timeslot', 'Admin\TK\TkJadwalPelajaranController@storeTimeSlot')->name('admin.tk.timeslot.store');
                Route::put('timeslot/update/{id}', 'Admin\TK\TkJadwalPelajaranController@updateTimeSlot')->name('admin.tk.timeslot.update');
                Route::delete('timeslot/{id}', 'Admin\TK\TkJadwalPelajaranController@deleteTimeSlot')->name('admin.tk.timeslot.destroy');

                Route::get('jadwalpelajaran/{id}/build', 'Admin\TK\TkJadwalPelajaranController@build')->name('admin.tk.jadwalpelajaran.build');
                Route::post('jadwalpelajaran/manage', 'Admin\TK\TkJadwalPelajaranController@manage')->name('admin.tk.jadwalpelajaran.manage');
                Route::put('jadwalpelajaran/{id}/manage', 'Admin\TK\TkJadwalPelajaranController@manageUpdate')->name('admin.tk.jadwalpelajaran.manage.update');
                Route::get('jadwalpelajaran/{id}/print', 'Admin\TK\TkJadwalPelajaranController@print')->name('admin.tk.jadwalpelajaran.print');

                Route::resource('jadwalpelajaran', 'Admin\TK\TkJadwalPelajaranController', [
                    'only' => ['index', 'create', 'store', 'show'],
                ])->names([
                    'index' => 'admin.tk.jadwalpelajaran.index',
                    'create' => 'admin.tk.jadwalpelajaran.create',
                    'store' => 'admin.tk.jadwalpelajaran.store',
                    'show' => 'admin.tk.jadwalpelajaran.show',
                ]);

                Route::get('jadwalmengajar/{id}/build', 'Admin\TK\TkJadwalMengajarController@build')->name('admin.tk.jadwalmengajar.build');
                Route::post('jadwalmengajar/manage', 'Admin\TK\TkJadwalMengajarController@manage')->name('admin.tk.jadwalmengajar.manage');
                Route::put('jadwalmengajar/{id}/manage', 'Admin\TK\TkJadwalMengajarController@manageUpdate')->name('admin.tk.jadwalmengajar.manage.update');
                Route::get('jadwalmengajar/{id}/print', 'Admin\TK\TkJadwalMengajarController@print')->name('admin.tk.jadwalmengajar.print');

                Route::resource('jadwalmengajar', 'Admin\TK\TkJadwalMengajarController', [
                    'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy'],
                ])->names([
                    'index' => 'admin.tk.jadwalmengajar.index',
                    'create' => 'admin.tk.jadwalmengajar.create',
                    'store' => 'admin.tk.jadwalmengajar.store',
                    'show' => 'admin.tk.jadwalmengajar.show',
                    'edit' => 'admin.tk.jadwalmengajar.edit',
                    'destroy' => 'admin.tk.jadwalmengajar.destroy',
                ]);

                Route::resource('event', 'Admin\TK\TkEventController')->names([
                    'index' => 'tk.event.index',
                    'store' => 'tk.event.store',
                    'create' => 'tk.event.create',
                    'update' => 'tk.event.update',
                    'destroy' => 'tk.event.destroy',
                ]);

                Route::resource('rekapevent', 'Admin\TK\TkEventAchivementGradeSiswaController')->names([
                    'index' => 'tk.rekapevent.index',
                    'store' => 'tk.rekapevent.store',
                    'create' => 'tk.rekapevent.create',
                ]);
                // Catatan resource
                Route::resource('catatan', 'Admin\TK\TkCatatanWaliKelasController')->names([
                    'index' => 'tk.catatan.index',
                    'store' => 'tk.catatan.store',
                    'create' => 'tk.catatan.create',
                ]);

                Route::resource('tgl-raport', 'Admin\TK\TglRaportController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'tk.tglraport.index',
                    'store' => 'tk.tglraport.store',
                    'update' => 'tk.tglraport.update',
                    'destroy' => 'tk.tglraport.destroy',
                ]);

                // Element resource
                Route::resource('element', 'Admin\TK\TkElementController')->names([
                    'index' => 'tk.element.index',
                    'store' => 'tk.element.store',
                    'create' => 'tk.element.create',
                    'update' => 'tk.element.update',
                    'destroy' => 'tk.element.destroy',
                ]);

                Route::resource('topic', 'Admin\TK\TkTopicController')->names([
                    'index' => 'tk.topic.index',
                    'store' => 'tk.topic.store',
                    'create' => 'tk.topic.create',
                    'update' => 'tk.topic.update',
                    'destroy' => 'tk.topic.destroy',
                ]);

                Route::resource('subtopic', 'Admin\TK\TkSubtopicController')->names([
                    'index' => 'tk.subtopic.index',
                    'store' => 'tk.subtopic.store',
                    'create' => 'tk.subtopic.create',
                    'update' => 'tk.subtopic.update',
                    'destroy' => 'tk.subtopic.destroy',
                ]);

                Route::resource('point', 'Admin\TK\TkPointController')->names([
                    'index' => 'tk.point.index',
                    'store' => 'tk.point.store',
                    'create' => 'tk.point.create',
                    'update' => 'tk.point.update',
                    'destroy' => 'tk.point.destroy',
                ]);

                Route::get('pembelajaran/export', 'Admin\TK\TkPembelajaranController@export')->name('tk.pembelajaran.export');

                Route::post('pembelajaran/settings', 'Admin\TK\TkPembelajaranController@settings')->name('tk.pembelajaran.settings');

                Route::resource('pembelajaran', 'Admin\TK\TkPembelajaranController')->only(['index', 'store'])->names([
                    'index' => 'tk.pembelajaran.index',
                    'store' => 'tk.pembelajaran.store',
                ]);

                Route::resource('penilaian', 'Admin\TK\PenilaianTkController')->only(['index', 'create', 'store', 'show', 'edit', 'update'])->names([
                    'index' => 'tk.penilaian.index',
                    'create' => 'tk.penilaian.create',
                    'store' => 'tk.penilaian.store',
                    'show' => 'tk.penilaian.show',
                    'edit' => 'tk.penilaian.edit',
                    'update' => 'tk.penilaian.update',
                ]);

                Route::resource('raport', 'Admin\TK\CetakRaportTKController')->only(['index', 'store', 'show'])->names([
                    'index' => 'tk.raport.index',
                    'store' => 'tk.raport.store',
                    'show' => 'tk.raport.show',
                ]);

                Route::get('raport/export/{id}', 'Admin\TK\CetakRaportTKController@export')->name('tk.raport.export');
            });
        });
    });
    // End Route Admin

    // Start Route Curriculum
    Route::group(['middleware' => 'role:Curriculum'], function () {
        Route::prefix('curriculum')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('curriculum.dashboard');
        });
    });
    // End Route Curriculum

    // Start Route Guru
    Route::group(['middleware' => 'role:Teacher|Teacher PG-KG|Co-Teacher|Co-Teacher PG-KG|Curriculum'], function () {
        Route::prefix('teacher')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('guru.dashboard');
            Route::get('akses', 'AuthController@ganti_akses')->name('ganti-akses');
            Route::resource('profile', 'Guru\ProfileController')->only(['update'])->names([
                'update' => 'guru.profile.update',
            ]);

            Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas')->name('guru.get.kelas');
            Route::get('getKelas/penilaian-tk/{id}', 'AjaxController@getClassByTkTopic');
            Route::get('getKelasByTingkatan/ajax/{id}', 'AjaxController@ajax_kelas_by_tingkatan_id');
            Route::get('getAllSilabus/ajax/{id}', 'AjaxController@getAllSilabus')->name('guru.get.all.silabus');
            Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('get.pembelajaran.id');

            Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('guru.get.pembelajaran.id');

            Route::get('getKelas/ekstra/{id}', 'AjaxController@ajax_kelas_ekstra')->name('guru.get.kelas.ekstra');

            // Curriculum
            Route::group(['middleware' => 'role:Curriculum'], function () {
                Route::prefix('master-data')->group(function () {

                    Route::get('karyawan/{id}', 'Admin\KaryawanController@show')->name('guru.karyawan.show');

                    // jadwal pelajaran -> siswa
                    Route::resource('jadwalpelajaran', 'Guru\MD\JadwalPelajaranController', [
                        'only' => ['index', 'create', 'store', 'show'],
                    ])->names([
                        'index' => 'guru.jadwalpelajaran.index',
                        'create' => 'guru.jadwalpelajaran.create',
                        'store' => 'guru.jadwalpelajaran.store',
                        'show' => 'guru.jadwalpelajaran.show',
                    ]);

                    Route::get('jadwalpelajaran/{id}/build', 'Guru\MD\JadwalPelajaranController@build')->name('guru.jadwalpelajaran.build');
                    Route::post('jadwalpelajaran/manage', 'Guru\MD\JadwalPelajaranController@manage')->name('guru.jadwalpelajaran.manage');
                    Route::put('jadwalpelajaran/{id}/manage', 'Guru\MD\JadwalPelajaranController@manageUpdate')->name('guru.jadwalpelajaran.manage.update');
                    Route::get('jadwalpelajaran/{id}/print', 'Guru\MD\JadwalPelajaranController@print')->name('guru.jadwalpelajaran.print');

                    Route::resource('jadwalmengajar', 'Guru\MD\JadwalMengajarController', [
                        'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy'],
                    ])->names([
                        'index' => 'guru.jadwalmengajar.index',
                        'create' => 'guru.jadwalmengajar.create',
                        'store' => 'guru.jadwalmengajar.store',
                        'show' => 'guru.jadwalmengajar.show',
                        'edit' => 'guru.jadwalmengajar.edit',
                        'destroy' => 'guru.jadwalmengajar.destroy',
                    ]);
                    Route::get('jadwalmengajar/{id}/build', 'Guru\MD\JadwalMengajarController@build')->name('guru.jadwalmengajar.build');
                    Route::post('jadwalmengajar/manage', 'Guru\MD\JadwalMengajarController@manage')->name('guru.jadwalmengajar.manage');
                    Route::put('jadwalmengajar/{id}/manage', 'Guru\MD\JadwalMengajarController@manageUpdate')->name('guru.jadwalmengajar.manage.update');
                    Route::get('jadwalmengajar/{id}/print', 'Guru\MD\JadwalMengajarController@print')->name('guru.jadwalmengajar.print');

                    // Pengumuman Controller
                    Route::resource('pengumuman', 'Guru\MD\PengumumanController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.pengumuman.index',
                        'store' => 'guru.pengumuman.store',
                        'update' => 'guru.pengumuman.update',
                        'destroy' => 'guru.pengumuman.destroy',
                    ]);

                    // Sekolah Controller
                    Route::resource('sekolah', 'Guru\MD\SekolahController')->only(['index', 'update'])->names([
                        'index' => 'guru.sekolah.index',
                        'update' => 'guru.sekolah.update',

                    ]);

                    // Academic Year Controller
                    Route::resource('tapel', 'Guru\MD\TapelController')->except(['create', 'edit'])->names([
                        'index' => 'guru.tapel.index',
                        'update' => 'guru.tapel.update',
                        'store' => 'guru.tapel.store',
                    ]);
                    Route::post('tapel/set', 'Guru\MD\TapelController@setAcademicYear')->name('guru.tapel.setAcademicYear');

                    Route::get('siswa/export', 'Guru\MD\SiswaController@export')->name('guru.siswa.export');
                    Route::get('siswa/data', 'Guru\MD\SiswaController@data')->name('guru.siswa.data');
                    Route::get('siswa/import', 'Guru\MD\SiswaController@format_import')->name('guru.siswa.format_import');
                    Route::post('siswa/import', 'Guru\MD\SiswaController@import')->name('guru.siswa.import');
                    Route::post('siswa/registrasi', 'Guru\MD\SiswaController@registrasi')->name('guru.siswa.registrasi');
                    Route::post('siswa/activate', 'Guru\MD\SiswaController@activate')->name('guru.siswa.activate');
                    Route::get('siswa/trash', 'Guru\MD\SiswaController@showTrash')->name('guru.siswa.trash');
                    Route::delete('siswa/{id}/permanent-delete', 'Guru\MD\SiswaController@destroyPermanent')->name('guru.siswa.permanent-delete');
                    Route::patch('siswa/{id}/restore', 'Guru\MD\SiswaController@restore')->name('guru.siswa.restore');
                    Route::resource('siswa', 'Guru\MD\SiswaController', [
                        'only' => ['index', 'store', 'update', 'destroy', 'show'],
                    ])->names([
                        'index' => 'guru.siswa.index',
                        'store' => 'guru.siswa.store',
                        'update' => 'guru.siswa.update',
                        'destroy' => 'guru.siswa.destroy',
                        'show' => 'guru.siswa.show',
                    ]);

                    // Guru Controller
                    Route::get('teacher/data', 'Guru\MD\GuruController@data')->name('guru.guru.data');
                    Route::get('teacher/export', 'Guru\MD\GuruController@export')->name('guru.guru.export');
                    Route::get('teacher/import', 'Guru\MD\GuruController@format_import')->name('guru.guru.format_import');
                    Route::post('teacher/import', 'Guru\MD\GuruController@import')->name('guru.guru.import');
                    Route::get('teacher/trash', 'Guru\MD\GuruController@showTrash')->name('guru.guru.trash');
                    Route::delete('teacher/{id}/permanent-delete', 'Guru\MD\GuruController@destroyPermanent')->name('guru.guru.permanent-delete');
                    Route::patch('teacher/{id}/restore', 'Guru\MD\GuruController@restore')->name('guru.guru.restore');
                    Route::resource('guru', 'Guru\MD\GuruController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.guru.index',
                        'store' => 'guru.guru.store',
                        'update' => 'guru.guru.update',
                        'destroy' => 'guru.guru.destroy',
                    ]);

                    // Tingkatan Controller
                    Route::resource('tingkatan', 'Guru\MD\TingkatanController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.tingkatan.index',
                        'store' => 'guru.tingkatan.store',
                        'update' => 'guru.tingkatan.update',
                        'destroy' => 'guru.tingkatan.destroy',
                    ]);

                    // Jurusan Controller
                    Route::resource('jurusan', 'Guru\MD\JurusanController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.jurusan.index',
                        'store' => 'guru.jurusan.store',
                        'update' => 'guru.jurusan.update',
                        'destroy' => 'guru.jurusan.destroy',
                    ]);

                    // Mapel Controller
                    Route::get('mapel/import', 'Guru\MD\MapelController@format_import')->name('guru.mapel.format_import');
                    Route::post('mapel/import', 'Guru\MD\MapelController@import')->name('guru.mapel.import');
                    Route::resource('mapel', 'Guru\MD\MapelController', [
                        'only' => ['index', 'store', 'update', 'destroy'],
                    ])->names([
                        'index' => 'guru.mapel.index',
                        'store' => 'guru.mapel.store',
                        'update' => 'guru.mapel.update',
                        'destroy' => 'guru.mapel.destroy',
                    ]);

                    Route::post('kelas/anggota', 'Guru\MD\KelasController@store_anggota')->name('guru.kelas.anggota');
                    Route::delete('kelas/anggota/{anggota}', 'Guru\MD\KelasController@delete_anggota')->name('guru.kelas.anggota.delete');
                    Route::post('kelas/anggota/{anggota}', 'Guru\MD\KelasController@pindah_kelas')->name('guru.kelas.anggota.pindah_kelas');
                    Route::get('kelas/{id}/trash', 'Guru\MD\KelasController@showTrash')->name('guru.kelas.anggota_kelas.trash');
                    Route::delete('kelas/{id}/permanent-delete', 'Guru\MD\KelasController@destroyPermanent')->name('guru.kelas.anggota_kelas.permanent-delete');
                    Route::patch('kelas/{id}/restore', 'Guru\MD\KelasController@restore')->name('guru.kelas.anggota_kelas.restore');
                    Route::resource('kelas', 'Guru\MD\KelasController', [
                        'only' => ['index', 'store', 'update', 'show', 'destroy'],
                    ])->names([
                        'index' => 'guru.kelas.index',
                        'store' => 'guru.kelas.store',
                        'update' => 'guru.kelas.update',
                        'show' => 'guru.kelas.show',
                        'destroy' => 'guru.kelas.destroy',
                    ]);

                    Route::get('pembelajaran/export', 'Guru\MD\PembelajaranController@export')->name('guru.pembelajaran.export');
                    Route::post('pembelajaran/settings', 'Guru\MD\PembelajaranController@settings')->name('guru.pembelajaran.settings');
                    Route::resource('pembelajaran', 'Guru\MD\PembelajaranController', [
                        'only' => ['index', 'store'],
                    ])->names([
                        'index' => 'guru.pembelajaran.index',
                        'store' => 'guru.pembelajaran.store',
                    ]);

                    Route::post('ekstrakulikuler/anggota', 'Guru\MD\EkstrakulikulerController@store_anggota')->name('guru.ekstrakulikuler.anggota');
                    Route::delete('ekstrakulikuler/anggota/{anggota}', 'Guru\MD\EkstrakulikulerController@delete_anggota')->name('guru.ekstrakulikuler.anggota.delete');
                    Route::resource('ekstrakulikuler', 'Guru\MD\EkstrakulikulerController', [
                        'only' => ['index', 'store', 'update', 'show', 'destroy'],
                    ])->names([
                        'index' => 'guru.ekstrakulikuler.index',
                        'store' => 'guru.ekstrakulikuler.store',
                        'update' => 'guru.ekstrakulikuler.update',
                        'show' => 'guru.ekstrakulikuler.show',
                        'destroy' => 'guru.ekstrakulikuler.destroy',
                    ]);

                    // Timeslot
                    Route::get('timeslot', 'Guru\MD\JadwalPelajaranController@timeSlot')->name('guru.timeslot.index');
                    Route::post('timeslot', 'Guru\MD\JadwalPelajaranController@storeTimeSlot')->name('guru.timeslot.store');
                    Route::put('timeslot/update/{id}', 'Guru\MD\JadwalPelajaranController@updateTimeSlot')->name('guru.timeslot.update');
                    Route::delete('timeslot/{id}', 'Guru\MD\JadwalPelajaranController@deleteTimeSlot')->name('guru.timeslot.destroy');

                    Route::resource('silabus', 'Guru\MD\SilabusController')
                        ->only(['index', 'store', 'update', 'destroy'])
                        ->names([
                            'index' => 'curriculum.silabus.index',
                            'store' => 'curriculum.silabus.store',
                            'update' => 'curriculum.silabus.update',
                            'destroy' => 'curriculum.silabus.destroy',
                        ]);
                    Route::delete('/silabus/{id}/destroy/{fileType}', 'Guru\MD\SilabusController@destroyFile')->name('curriculum.silabus.destroyFile');
                    Route::get('/silabus/pdf/{filename}', 'Guru\MD\PdfController@viewSilabusPDF')->name('curriculum.silabus.pdf.view');
                });
            });

            // Start Route Guru Mapel KM
            Route::group(['middleware' => ['role:Teacher|Co-Teacher|Curriculum']], function () {
                // Start KM
                Route::prefix('km')->group(function () {
                    Route::resource('silabus', 'Guru\SilabusController')
                        ->only(['index', 'store', 'update', 'destroy'])
                        ->names([
                            'index' => 'guru.silabus.index',
                            'store' => 'guru.silabus.store',
                            'update' => 'guru.silabus.update',
                            'destroy' => 'guru.silabus.destroy',
                        ]);
                    Route::delete('/silabus/{id}/destroy/{fileType}', 'Guru\MD\SilabusController@destroyFile')->name('guru.silabus.destroyFile');
                    Route::get('/silabus/pdf/{filename}', 'Guru\MD\PdfController@viewSilabusPDF')->name('guru.silabus.pdf.view');

                    Route::resource('rekap-kehadiran', 'Guru\KM\InputData\RekapKehadiranSiswaController')
                        ->only(['index', 'store'])->names([
                            'index' => 'guru.km.rekapkehadiran.index',
                            'store' => 'guru.km.rekapkehadiran.store',
                        ]);

                    Route::resource('kehadiran', 'Guru\KM\InputData\KehadiranSiswaController')
                        ->only(['index', 'store', 'create'])->names([
                            'index' => 'guru.km.kehadiran.index',
                            'store' => 'guru.km.kehadiran.store',
                            'create' => 'guru.km.kehadiran.create',
                        ]);

                    Route::resource('catatan', 'Guru\KM\InputData\CatatanWaliKelasController')
                        ->only(['index', 'store', 'create'])->names([
                            'index' => 'guru.km.catatan.index',
                            'store' => 'guru.km.catatan.store',
                            'create' => 'guru.km.catatan.create',
                        ]);

                    Route::resource('kenaikan', 'Guru\KM\InputData\KenaikanKelasController')
                        ->only(['index', 'store', 'create'])->names([
                            'index' => 'guru.km.kenaikan.index',
                            'store' => 'guru.km.kenaikan.store',
                            'create' => 'guru.km.kenaikan.create',
                        ]);

                    // Start Raport KM
                    Route::delete('cp/delete/{id}', 'Guru\KM\CapaianPembelajaranController@destroy')->name('guru.km.cp.destroy');
                    Route::resource('cp', 'Guru\KM\CapaianPembelajaranController')->only(['index', 'store', 'update', 'create'])->names([
                        'index' => 'guru.km.cp.index',
                        'store' => 'guru.km.cp.store',
                        'update' => 'guru.km.cp.update',
                        'create' => 'guru.km.cp.create',
                    ]);

                    Route::resource('rencanaformatif', 'Guru\KM\RencanaNilaiFormatifController')->only(['index', 'store', 'show', 'edit', 'update', 'destroy', 'create'])->names([
                        'index' => 'guru.km.rencanaformatif.index',
                        'store' => 'guru.km.rencanaformatif.store',
                        'show' => 'guru.km.rencanaformatif.show',
                        'edit' => 'guru.km.rencanaformatif.edit',
                        'update' => 'guru.km.rencanaformatif.update',
                        'destroy' => 'guru.km.rencanaformatif.destroy',
                        'create' => 'guru.km.rencanaformatif.create',
                    ]);

                    Route::resource('rencanasumatif', 'Guru\KM\RencanaNilaiSumatifController')->only(['index', 'store', 'show', 'edit', 'update', 'destroy', 'create'])->names([
                        'index' => 'guru.km.rencanasumatif.index',
                        'store' => 'guru.km.rencanasumatif.store',
                        'show' => 'guru.km.rencanasumatif.show',
                        'edit' => 'guru.km.rencanasumatif.edit',
                        'update' => 'guru.km.rencanasumatif.update',
                        'destroy' => 'guru.km.rencanasumatif.destroy',
                        'create' => 'guru.km.rencanasumatif.create',
                    ]);

                    Route::resource('penilaian', 'Guru\KM\PenilaianKurikulumMerdekaController')->only(['index', 'create', 'store', 'show', 'edit', 'update'])->names([
                        'index' => 'guru.km.penilaian.index',
                        'create' => 'guru.km.penilaian.create',
                        'store' => 'guru.km.penilaian.store',
                        'show' => 'guru.km.penilaian.show',
                        'edit' => 'guru.km.penilaian.edit',
                        'update' => 'guru.km.penilaian.update',
                    ]);

                    Route::resource('nilai-terkirim', 'Guru\KM\LihatNilaiTerkirimController')->only(['index', 'create'])->names([
                        'index' => 'guru.km.nilaiterkirim.index',
                        'create' => 'guru.km.nilaiterkirim.create',
                    ]);

                    Route::resource('mapping', 'Guru\KM\MapingMapelController')->only(['index', 'store'])->names([
                        'index' => 'guru.km.mapping.index',
                        'store' => 'guru.km.mapping.store',
                    ]);

                    Route::resource('tgl-raport', 'Guru\KM\TglRaportController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.km.tglraport.index',
                        'store' => 'guru.km.tglraport.store',
                        'update' => 'guru.km.tglraport.update',
                        'destroy' => 'guru.km.tglraport.destroy',
                    ]);

                    Route::resource('kirim-nilai-akhir', 'Guru\KM\KirimNilaiAkhirController')->only(['index', 'create', 'store'])->names([
                        'index' => 'guru.km.kirimnilaiakhir.index',
                        'create' => 'guru.km.kirimnilaiakhir.create',
                        'store' => 'guru.km.kirimnilaiakhir.store',
                    ]);

                    Route::resource('proses-deskripsi', 'Guru\KM\ProsesDeskripsiSiswaController')->only(['index', 'create', 'store'])->names([
                        'index' => 'guru.km.prosesdeskripsi.index',
                        'create' => 'guru.km.prosesdeskripsi.create',
                        'store' => 'guru.km.prosesdeskripsi.store',
                    ]);

                    // Hasil Raport KM
                    Route::resource('raport-status-penilaian', 'Guru\KM\StatusPenilaianController', [
                        'only' => ['index', 'store'],
                    ])->names([
                        'index' => 'guru.km.raport-status-penilaian.index',
                        'store' => 'guru.km.raport-status-penilaian.store',
                    ]);

                    Route::resource('pengelolaannilai', 'Guru\KM\PengelolaanNilaiController', [
                        'only' => ['index', 'store'],
                    ])->names([
                        'index' => 'guru.km.pengelolaannilai.index',
                        'store' => 'guru.km.pengelolaannilai.store',
                    ]);

                    Route::resource('nilairaport', 'Guru\KM\NilaiRaportSemesterController', [
                        'only' => ['index', 'store'],
                    ])->names([
                        'index' => 'guru.km.nilairaport.index',
                        'store' => 'guru.km.nilairaport.store',
                    ]);

                    Route::resource('leger', 'Guru\KM\LegerNilaiSiswaController', [
                        'only' => ['index', 'store', 'show'],
                    ])->names([
                        'index' => 'guru.km.leger.index',
                        'store' => 'guru.km.leger.store',
                        'show' => 'guru.km.leger.show',
                    ]);

                    Route::resource('raportpts', 'Guru\KM\CetakRaportPTSController', [
                        'only' => ['index', 'store', 'show'],
                    ])->names([
                        'index' => 'guru.km.raportpts.index',
                        'store' => 'guru.km.raportpts.store',
                        'show' => 'guru.km.raportpts.show',
                    ]);

                    Route::resource('raportsemester', 'Guru\KM\CetakRaportSemesterController', [
                        'only' => ['index', 'store', 'show'],
                    ])->names([
                        'index' => 'guru.km.raportsemester.index',
                        'store' => 'guru.km.raportsemester.store',
                        'show' => 'guru.km.raportsemester.show',
                    ]);

                    Route::get('raportsemester/export/{id}', 'Guru\KM\CetakRaportSemesterController@export')->name('guru.km.raportsemester.export');

                    Route::resource('nilaiekstra', 'Guru\NilaiEkstrakulikulerController', [
                        'only' => ['index', 'create', 'store'],
                    ])->names([
                        'index' => 'guru.km.nilaiekstra.index',
                        'create' => 'guru.km.nilaiekstra.create',
                        'store' => 'guru.km.nilaiekstra.store',
                    ]);

                    Route::get('kkm/import', 'Guru\KM\KkmMapelController@format_import')->name('guru.km.kkm.format_import');
                    Route::post('kkm/import', 'Guru\KM\KkmMapelController@import')->name('guru.km.kkm.import');
                    Route::resource('kkm', 'Guru\KM\KkmMapelController', [
                        'only' => ['index', 'store', 'update', 'destroy'],
                    ])->names([
                        'index' => 'guru.km.kkm.index',
                        'store' => 'guru.km.kkm.store',
                        'update' => 'guru.km.kkm.update',
                        'destroy' => 'guru.km.kkm.destroy',
                    ]);

                    // P5BK
                    Route::prefix('p5bk')->group(function () {
                        Route::resource('p5/dimensi', 'Guru\P5\P5DimensiController')->only(['index', 'store', 'update', 'destroy'])->names([
                            'index' => 'guru.p5.dimensi.index',
                            'store' => 'guru.p5.dimensi.store',
                            'update' => 'guru.p5.dimensi.update',
                            'destroy' => 'guru.p5.dimensi.destroy',
                        ]);
                        Route::resource('p5/element', 'Guru\P5\P5ElementController')->only(['index', 'store', 'update', 'destroy'])->names([
                            'index' => 'guru.p5.element.index',
                            'store' => 'guru.p5.element.store',
                            'update' => 'guru.p5.element.update',
                            'destroy' => 'guru.p5.element.destroy',
                        ]);
                        Route::resource('p5/subelement', 'Guru\P5\P5SubelementController')->only(['index', 'store', 'update', 'destroy'])->names([
                            'index' => 'guru.p5.subelement.index',
                            'store' => 'guru.p5.subelement.store',
                            'update' => 'guru.p5.subelement.update',
                            'destroy' => 'guru.p5.subelement.destroy',
                        ]);
                        Route::get('p5/subelement/data', 'Guru\P5\P5SubelementController@data')->name('guru.p5.subelement.data');

                        Route::resource('p5/tema', 'Guru\P5\P5TemaController')->only(['index', 'store', 'update', 'destroy'])->names([
                            'index' => 'guru.p5.tema.index',
                            'store' => 'guru.p5.tema.store',
                            'update' => 'guru.p5.tema.update',
                            'destroy' => 'guru.p5.tema.destroy',
                        ]);
                        Route::resource('p5/project', 'Guru\P5\P5ProjectController')->only(['index', 'store', 'update', 'destroy', 'edit', 'show'])->names([
                            'index' => 'guru.p5.project.index',
                            'store' => 'guru.p5.project.store',
                            'update' => 'guru.p5.project.update',
                            'edit' => 'guru.p5.project.edit',
                            'show' => 'guru.p5.project.show',
                            'destroy' => 'guru.p5.project.destroy',
                        ]);
                        Route::post('p5/project/nilai/{id}', 'Guru\P5\P5ProjectController@nilai')->name('guru.p5.project.nilai');
                        Route::resource('p5/raport', 'Guru\P5\CetakRaportP5Controller')->only(['index', 'store', 'show'])->names([
                            'index' => 'guru.p5.raport.index',
                            'store' => 'guru.p5.raport.store',
                            'show' => 'guru.p5.raport.show',
                        ]);
                        Route::get('p5/raport/export/{id}', 'Guru\KM\CetakRaportSemesterController@export')->name('guru.p5.raport.export');
                    });
                });
                // End Raport KM
            });
            // End Route Guru Mapel KM

            // Start Route Wali Kelas KM
            Route::group(['middleware' => ['checkAksesGuru:homeroom-km', 'role:Teacher|Co-Teacher']], function () {
                Route::prefix('km')->group(function () {
                    Route::resource('pesertadidik', 'WaliKelas\PesertaDidikController')->only(['index', 'show'])->names([
                        'index' => 'walikelas.pesertadidik.index',
                        'show' => 'walikelas.pesertadidik.show',
                    ]);

                    Route::resource('kehadiran', 'WaliKelas\KehadiranSiswaController')->only(['index', 'store'])->names([
                        'index' => 'walikelas.kehadiran.index',
                        'store' => 'walikelas.kehadiran.store',
                    ]);

                    Route::resource('prestasi', 'WaliKelas\PrestasiSiswaController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'walikelas.prestasi.index',
                        'store' => 'walikelas.prestasi.store',
                        'update' => 'walikelas.prestasi.update',
                        'destroy' => 'walikelas.prestasi.destroy',
                    ]);

                    Route::resource('catatan', 'WaliKelas\CatatanWaliKelasController')->only(['index', 'store'])->names([
                        'index' => 'walikelas.catatan.index',
                        'store' => 'walikelas.catatan.store',
                    ]);

                    Route::resource('kenaikan', 'WaliKelas\KenaikanKelasController')->only(['index', 'store'])->names([
                        'index' => 'walikelas.kenaikan.index',
                        'store' => 'walikelas.kenaikan.store',
                    ]);

                    Route::resource('statusnilai', 'WaliKelas\KM\StatusPenilaianController')->only(['index'])->names([
                        'index' => 'walikelas.statusnilaiguru.index',
                    ]);

                    Route::resource('hasilnilai', 'WaliKelas\KM\PengelolaanNilaiController')->only(['index'])->names([
                        'index' => 'walikelas.hasilnilai.index',
                    ]);

                    Route::resource('nilairaport', 'Admin\KM\NilaiRaportSemesterController')->only(['index', 'store'])->names([
                        'index' => 'walikelas.nilairaport.index',
                        'store' => 'walikelas.nilairaport.store',
                    ]);

                    Route::resource('leger', 'WaliKelas\KM\LegerNilaiSiswaController')->only(['index', 'show'])->names([
                        'index' => 'walikelas.leger.index',
                        'show' => 'walikelas.leger.show',
                    ]);

                    Route::resource('raportpts', 'WaliKelas\KM\CetakRaportPTSController')->only(['index', 'show', 'store'])->names([
                        'index' => 'walikelas.raportpts.index',
                        'show' => 'walikelas.raportpts.show',
                        'store' => 'walikelas.raportpts.store',
                    ]);

                    Route::resource('raportsemester', 'WaliKelas\KM\CetakRaportSemesterController')->only(['index', 'show', 'store'])->names([
                        'index' => 'walikelas.raportsemester.index',
                        'show' => 'walikelas.raportsemester.show',
                        'store' => 'walikelas.raportsemester.store',
                    ]);
                });
            });
            // End  Raport KM Wali Kelas


            // Start Route PG-KG
            Route::group(['middleware' => ['role:Teacher PG-KG|Co-Teacher PG-KG|Curriculum']], function () {
                Route::prefix('tk')->group(function () {
                    // Timeslot
                    Route::get('timeslot', 'Guru\TK\TkJadwalPelajaranController@timeSlot')->name('guru.tk.timeslot.index');
                    Route::post('timeslot', 'Guru\TK\TkJadwalPelajaranController@storeTimeSlot')->name('guru.tk.timeslot.store');
                    Route::put('timeslot/update/{id}', 'Guru\TK\TkJadwalPelajaranController@updateTimeSlot')->name('guru.tk.timeslot.update');
                    Route::delete('timeslot/{id}', 'Guru\TK\TkJadwalPelajaranController@deleteTimeSlot')->name('guru.tk.timeslot.destroy');

                    Route::get('jadwalpelajaran/{id}/build', 'Guru\TK\TkJadwalPelajaranController@build')->name('guru.tk.jadwalpelajaran.build');
                    Route::post('jadwalpelajaran/manage', 'Guru\TK\TkJadwalPelajaranController@manage')->name('guru.tk.jadwalpelajaran.manage');
                    Route::put('jadwalpelajaran/{id}/manage', 'Guru\TK\TkJadwalPelajaranController@manageUpdate')->name('guru.tk.jadwalpelajaran.manage.update');
                    Route::get('jadwalpelajaran/{id}/print', 'Guru\TK\TkJadwalPelajaranController@print')->name('guru.tk.jadwalpelajaran.print');

                    Route::resource('jadwalpelajaran', 'Guru\TK\TkJadwalPelajaranController', [
                        'only' => ['index', 'create', 'store', 'show'],
                    ])->names([
                        'index' => 'guru.tk.jadwalpelajaran.index',
                        'create' => 'guru.tk.jadwalpelajaran.create',
                        'store' => 'guru.tk.jadwalpelajaran.store',
                        'show' => 'guru.tk.jadwalpelajaran.show',
                    ]);

                    Route::get('jadwalmengajar/{id}/build', 'Guru\TK\TkJadwalMengajarController@build')->name('guru.tk.jadwalmengajar.build');
                    Route::post('jadwalmengajar/manage', 'Guru\TK\TkJadwalMengajarController@manage')->name('guru.tk.jadwalmengajar.manage');
                    Route::put('jadwalmengajar/{id}/manage', 'Guru\TK\TkJadwalMengajarController@manageUpdate')->name('guru.tk.jadwalmengajar.manage.update');
                    Route::get('jadwalmengajar/{id}/print', 'Guru\TK\TkJadwalMengajarController@print')->name('guru.tk.jadwalmengajar.print');

                    Route::resource('jadwalmengajar', 'Guru\TK\TkJadwalMengajarController', [
                        'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy'],
                    ])->names([
                        'index' => 'guru.tk.jadwalmengajar.index',
                        'create' => 'guru.tk.jadwalmengajar.create',
                        'store' => 'guru.tk.jadwalmengajar.store',
                        'show' => 'guru.tk.jadwalmengajar.show',
                        'edit' => 'guru.tk.jadwalmengajar.edit',
                        'destroy' => 'guru.tk.jadwalmengajar.destroy',
                    ]);

                    Route::resource('kehadiran', 'Guru\TK\TkKehadiranSiswaController')->only(['index', 'store', 'create'])->names([
                        'index' => 'guru.tk.kehadiran.index',
                        'store' => 'guru.tk.kehadiran.store',
                        'create' => 'guru.tk.kehadiran.create',
                    ]);
                    Route::resource('event', 'Guru\TK\TkEventController')->only(['index', 'store', 'create', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.event.index',
                        'store' => 'guru.tk.event.store',
                        'create' => 'guru.tk.event.create',
                        'update' => 'guru.tk.event.update',
                        'destroy' => 'guru.tk.event.destroy',
                    ]);

                    Route::resource('rekapevent', 'Guru\TK\TkEventAchivementGradeSiswaController')->only(['index', 'store', 'create'])->names([
                        'index' => 'guru.tk.rekapevent.index',
                        'store' => 'guru.tk.rekapevent.store',
                        'create' => 'guru.tk.rekapevent.create',
                    ]);
                    // Catatan resource
                    Route::resource('catatan', 'Guru\TK\TkCatatanWaliKelasController')->only(['index', 'store', 'create'])->names([
                        'index' => 'guru.tk.catatan.index',
                        'store' => 'guru.tk.catatan.store',
                        'create' => 'guru.tk.catatan.create',
                    ]);

                    Route::resource('tgl-raport', 'Admin\TK\TglRaportController')->only(['index', 'store', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.tglraport.index',
                        'store' => 'guru.tk.tglraport.store',
                        'update' => 'guru.tk.tglraport.update',
                        'destroy' => 'guru.tk.tglraport.destroy',
                    ]);

                    // Element resource
                    Route::resource('element', 'Guru\TK\TkElementController')->only(['index', 'store', 'create', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.element.index',
                        'store' => 'guru.tk.element.store',
                        'create' => 'guru.tk.element.create',
                        'update' => 'guru.tk.element.update',
                        'destroy' => 'guru.tk.element.destroy',
                    ]);

                    Route::resource('topic', 'Guru\TK\TkTopicController')->only(['index', 'store', 'create', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.topic.index',
                        'store' => 'guru.tk.topic.store',
                        'create' => 'guru.tk.topic.create',
                        'update' => 'guru.tk.topic.update',
                        'destroy' => 'guru.tk.topic.destroy',
                    ]);

                    Route::resource('subtopic', 'Guru\TK\TkSubtopicController')->only(['index', 'store', 'create', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.subtopic.index',
                        'store' => 'guru.tk.subtopic.store',
                        'create' => 'guru.tk.subtopic.create',
                        'update' => 'guru.tk.subtopic.update',
                        'destroy' => 'guru.tk.subtopic.destroy',
                    ]);

                    Route::resource('point', 'Guru\TK\TkPointController')->only(['index', 'store', 'create', 'update', 'destroy'])->names([
                        'index' => 'guru.tk.point.index',
                        'store' => 'guru.tk.point.store',
                        'create' => 'guru.tk.point.create',
                        'update' => 'guru.tk.point.update',
                        'destroy' => 'guru.tk.point.destroy',
                    ]);

                    Route::get('pembelajaran/export', 'Guru\TK\TkPembelajaranController@export')->name('guru.tk.pembelajaran.export');

                    Route::post('pembelajaran/settings', 'Guru\TK\TkPembelajaranController@settings')->name('guru.tk.pembelajaran.settings');

                    Route::resource('pembelajaran', 'Guru\TK\TkPembelajaranController')->only(['index', 'store'])->names([
                        'index' => 'guru.tk.pembelajaran.index',
                        'store' => 'guru.tk.pembelajaran.store',
                    ]);

                    Route::resource('penilaian', 'Guru\TK\PenilaianTkController')->only(['index', 'create', 'store', 'show', 'edit', 'update'])->names([
                        'index' => 'guru.tk.penilaian.index',
                        'create' => 'guru.tk.penilaian.create',
                        'store' => 'guru.tk.penilaian.store',
                        'show' => 'guru.tk.penilaian.show',
                        'edit' => 'guru.tk.penilaian.edit',
                        'update' => 'guru.tk.penilaian.update',
                    ]);

                    Route::resource('raport', 'Guru\TK\CetakRaportTKController')->only(['index', 'store', 'show'])->names([
                        'index' => 'guru.tk.raport.index',
                        'store' => 'guru.tk.raport.store',
                        'show' => 'guru.tk.raport.show',
                    ]);

                    Route::get('raport/export/{id}', 'Guru\TK\CetakRaportTKController@export')->name('guru.tk.raport.export');
                });
            });
            // End Route Guru Mapel PG
        });
    });
    // End Route Guru

    // Route User Siswa
    Route::group(['middleware' => 'role:Student'], function () {
        Route::prefix('student')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('siswa.dashboard');

            // jadwal pelajaran -> siswa
            Route::get('jadwalpelajaran', 'Siswa\JadwalPelajaranController@index')->name('siswa.jadwalpelajaran');
            Route::get('jadwalpelajaran/{id}/print', 'Siswa\JadwalPelajaranController@print')->name('siswa.jadwalpelajaran.print');

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

            Route::resource('nilaiakhir', 'Siswa\KM\NilaiAkhirSemesterController', [
                'uses' => ['index'],
            ]);
        });
    });
    // End Route User Siswa
});
