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


    Route::group(['middleware' => 'role:Admin'], function () {
        Route::prefix('admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            // User 
            Route::prefix('user')->group(function () {
                Route::group(['middleware' => 'permission:admin-access'], function () {
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
                });
            });

            // Karyawan
            Route::prefix('karyawan')->group(function () {
                Route::resource('statuskaryawan', 'Admin\StatusKaryawanController', [
                    'uses' => ['index', 'update', 'destroy'],
                ]);
                Route::resource('unitkaryawan', 'Admin\UnitKaryawanController', [
                    'uses' => ['index', 'update', 'destroy'],
                ]);
                Route::resource('positionkaryawan', 'Admin\PositionKaryawanController', [
                    'uses' => ['index', 'update', 'destroy'],
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
    });

    Route::group(['middleware' => 'role_or_permission:Admin|masterdata-management'], function () {
        // Master Data
        Route::prefix('master-data')->group(function () {
            // jadwal pelajaran -> siswa
            Route::resource('jadwalpelajaran', 'Admin\JadwalPelajaranController', [
                'only' => ['index', 'create', 'store', 'show'],
            ]);
            Route::get('jadwalpelajaran/{id}/build', 'Admin\JadwalPelajaranController@build')->name('jadwalpelajaran.build');
            Route::post('jadwalpelajaran/manage', 'Admin\JadwalPelajaranController@manage')->name('jadwalpelajaran.manage');
            Route::put('jadwalpelajaran/{id}/manage', 'Admin\JadwalPelajaranController@manageUpdate')->name('jadwalpelajaran.manage.update');
            Route::get('jadwalpelajaran/{id}/print', 'Admin\JadwalPelajaranController@print')->name('jadwalpelajaran.print');

            // jadwal mengajar -> guru
            Route::resource('jadwalmengajar', 'Admin\JadwalMengajarController', [
                'only' => ['index', 'create', 'store', 'show', 'edit', 'destroy'],
            ]);
            Route::get('jadwalmengajar/{id}/build', 'Admin\JadwalMengajarController@build')->name('jadwalmengajar.build');
            Route::post('jadwalmengajar/manage', 'Admin\JadwalMengajarController@manage')->name('jadwalmengajar.manage');
            Route::put('jadwalmengajar/{id}/manage', 'Admin\JadwalMengajarController@manageUpdate')->name('jadwalmengajar.manage.update');
            Route::get('jadwalmengajar/{id}/print', 'Admin\JadwalMengajarController@print')->name('jadwalmengajar.print');

            // Profile Controller
            Route::resource('profileadmin', 'Admin\ProfileController')->only(['update']);

            // Pengumuman Controller
            Route::resource('pengumuman', 'Admin\PengumumanController')->only(['index', 'store', 'update', 'destroy']);

            // Sekolah Controller
            Route::resource('sekolah', 'Admin\SekolahController')->only(['index', 'update']);

            // Academic Year Controller
            Route::resource('tapel', 'Admin\TapelController')->except(['create', 'edit']);
            Route::post('tapel/set', 'Admin\TapelController@setAcademicYear')->name('tapel.setAcademicYear');

            Route::get('siswa/export', 'Admin\SiswaController@export')->name('siswa.export');
            Route::get('siswa/data', 'Admin\SiswaController@data')->name('siswa.data');
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

            // Guru Controller
            Route::get('guru/data', 'Admin\GuruController@data')->name('guru.data');
            Route::get('guru/export', 'Admin\GuruController@export')->name('guru.export');
            Route::get('guru/import', 'Admin\GuruController@format_import')->name('guru.format_import');
            Route::post('guru/import', 'Admin\GuruController@import')->name('guru.import');
            Route::resource('guru', 'Admin\GuruController')->only(['index', 'store', 'update', 'destroy']);
            Route::get('guru/trash', 'Admin\GuruController@showTrash')->name('guru.trash');
            Route::delete('guru/{id}/permanent-delete', 'Admin\GuruController@destroyPermanent')->name('guru.permanent-delete');
            Route::patch('guru/{id}/restore', 'Admin\GuruController@restore')->name('guru.restore');

            // Tingkatan Controller
            Route::resource('tingkatan', 'Admin\TingkatanController')->only(['index', 'store', 'update', 'destroy']);

            // Jurusan Controller
            Route::resource('jurusan', 'Admin\JurusanController')->only(['index', 'store', 'update', 'destroy']);

            // Mapel Controller
            Route::get('mapel/import', 'Admin\MapelController@format_import')->name('mapel.format_import');
            Route::post('mapel/import', 'Admin\MapelController@import')->name('mapel.import');
            Route::resource('mapel', 'Admin\MapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);
            Route::resource('mapel', 'Admin\MapelController', [
                'uses' => ['index', 'store', 'update', 'destroy'],
            ]);

            Route::post('kelas/anggota', 'Admin\KelasController@store_anggota')->name('kelas.anggota');
            Route::delete('kelas/anggota/{anggota}', 'Admin\KelasController@delete_anggota')->name('kelas.anggota.delete');
            Route::post('kelas/anggota/{anggota}', 'Admin\KelasController@pindah_kelas')->name('kelas.anggota.pindah_kelas');
            Route::get('kelas/{id}/trash', 'Admin\KelasController@showTrash')->name('kelas.anggota_kelas.trash');
            Route::delete('kelas/{id}/permanent-delete', 'Admin\KelasController@destroyPermanent')->name('kelas.anggota_kelas.permanent-delete');
            Route::patch('kelas/{id}/restore', 'Admin\KelasController@restore')->name('kelas.anggota_kelas.restore');
            Route::resource('kelas', 'Admin\KelasController', [
                'uses' => ['index', 'store', 'show', 'destroy'],
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

            // Timeslot
            Route::get('timeslot', 'Admin\JadwalPelajaranController@timeSlot')->name('timeslot.index');
            Route::post('timeslot', 'Admin\JadwalPelajaranController@storeTimeSlot')->name('timeslot.store');
            Route::put('timeslot/update/{id}', 'Admin\JadwalPelajaranController@updateTimeSlot')->name('timeslot.update');
            Route::delete('timeslot/{id}', 'Admin\JadwalPelajaranController@deleteTimeSlot')->name('timeslot.destory');
        });
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
        Route::delete('cp/delete/{id}', 'Admin\KM\CapaianPembelajaranController@destroy')->name('admin.km.cp.destroy');
        Route::resource('cp', 'Admin\KM\CapaianPembelajaranController')->only(['index', 'store', 'update', 'create'])->names([
            'index' => 'km.cp.index',
            'store' => 'km.cp.store',
            'update' => 'km.cp.update',
            'create' => 'km.cp.create',
        ]);

        Route::resource('rencanaformatif', 'Admin\KM\RencanaNilaiFormatifController')->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->names([
            'index' => 'km.rencanaformatif.index',
            'create' => 'km.rencanaformatif.create',
            'store' => 'km.rencanaformatif.store',
            'show' => 'km.rencanaformatif.show',
            'edit' => 'km.rencanaformatif.edit',
            'update' => 'km.rencanaformatif.update',
            'destroy' => 'km.rencanaformatif.destroy',
        ]);

        Route::resource('rencanasumatif', 'Admin\KM\RencanaNilaiSumatifController')->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->names([
            'index' => 'km.rencanasumatif.index',
            'create' => 'km.rencanasumatif.create',
            'store' => 'km.rencanasumatif.store',
            'show' => 'km.rencanasumatif.show',
            'edit' => 'km.rencanasumatif.edit',
            'update' => 'km.rencanasumatif.update',
            'destroy' => 'km.rencanasumatif.destroy',
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

    Route::get('getKelas/ajax/{id}', 'AjaxController@ajax_kelas');
    Route::get('getKelas/penilaian-tk/{id}', 'AjaxController@getClassByTkTopic');
    Route::get('getKelasByTingkatan/ajax/{id}', 'AjaxController@ajax_kelas_by_tingkatan_id');
    Route::get('getAllSilabus/ajax/{id}', 'AjaxController@getAllSilabus')->name('admin.get.all.silabus');
    Route::get('getPembelajaranId/', 'AjaxController@getPembelajaranId')->name('get.pembelajaran.id');
    Route::get('getKelas/ekstra/{id}', 'AjaxController@ajax_kelas_ekstra');
    Route::get('/pdf/{filename}', 'Admin\PdfController@viewDocumentSiswaPDF')->name('document.siswa.pdf.view');
    // End Route User Admin

    // Route User Guru
    Route::group(['middleware' => 'role:Teacher'], function () {
        Route::group(['prefix' => 'guru'], function () {
            Route::get('dashboard', 'DashboardController@index')->name('guru.dashboard');

            Route::resource('profileguru', 'Guru\ProfileController', [
                'uses' => ['update'],
            ]);

            Route::get('akses', 'AuthController@ganti_akses')->name('akses');

            // Route Guru Mapel
            Route::group(['middleware' => 'checkAksesGuru:Guru Mapel'], function () {

                // jadwal mengajar -> guru
                Route::get('jadwalmengajar', 'Guru\JadwalMengajarController@index')->name('guru.jadwalmengajar');
                Route::get('jadwalmengajar/show', 'Guru\JadwalMengajarController@show')->name('guru.jadwalmengajar.show');
                Route::get('jadwalmengajar/{id}/print', 'Guru\JadwalMengajarController@print')->name('guru.jadwalmengajar.print');

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

                // End Import Nilai
                Route::resource('kirimnilaiakhirkm', 'Guru\KM\KirimNilaiAkhirController', [
                    'uses' => ['index', 'create', 'store'],
                ]);

                Route::resource('nilaiterkirimkm', 'Guru\KM\LihatNilaiTerkirimController', [
                    'uses' => ['index', 'create'],
                ]);
            });

            Route::group(['prefix' => 'tk'], function () {
                Route::resource('penilaian', 'Guru\KM\PenilaianTkController')->names([
                    'index' => 'tk.guru.penilaian.index',
                    'create' => 'tk.guru.penilaian.create',
                    'store' => 'tk.guru.penilaian.store',
                    'show' => 'tk.guru.penilaian.show',
                    'edit' => 'tk.guru.penilaian.edit',
                    'update' => 'tk.guru.penilaian.update',
                    'destroy' => 'tk.guru.penilaian.destroy',
                ]);
                Route::resource('raport', 'Guru\KM\CetakRaportTKController')->names([
                    'index' => 'tk.guru.raport.index',
                    'show' => 'tk.guru.raport.show',
                    'store' => 'tk.guru.raport.store',
                ]);
                Route::get('raport/export/{id}', 'Guru\KM\CetakRaportTKController@export')->name('tk.guru.raport.export');
            });

            // End Route Guru Mapel

            //Route Wali Kelas
            Route::group(['middleware' => 'checkAksesGuru:Wali Kelas'], function () {
                Route::resource('pesertadidik', 'Walikelas\PesertaDidikController')->only(['index', 'show'])->names([
                    'index' => 'walikelas.pesertadidik.index',
                    'show' => 'walikelas.pesertadidik.show',
                ]);

                Route::resource('kehadiran', 'Walikelas\KehadiranSiswaController')->only(['index', 'store'])->names([
                    'index' => 'walikelas.kehadiran.index',
                    'store' => 'walikelas.kehadiran.store',
                ]);

                Route::resource('prestasi', 'Walikelas\PrestasiSiswaController')->only(['index', 'store', 'update', 'destroy'])->names([
                    'index' => 'walikelas.prestasi.index',
                    'store' => 'walikelas.prestasi.store',
                    'update' => 'walikelas.prestasi.update',
                    'destroy' => 'walikelas.prestasi.destroy',
                ]);

                Route::resource('catatan', 'Walikelas\CatatanWaliKelasController')->only(['index', 'store'])->names([
                    'index' => 'walikelas.catatan.index',
                    'store' => 'walikelas.catatan.store',
                ]);

                Route::resource('kenaikan', 'Walikelas\KenaikanKelasController')->only(['index', 'store'])->names([
                    'index' => 'walikelas.kenaikan.index',
                    'store' => 'walikelas.kenaikan.store',
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
    Route::group(['middleware' => 'role:Student'], function () {
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
    // End Route User Siswa
});
