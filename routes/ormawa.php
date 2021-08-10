<?php

use Illuminate\Support\Facades\Route;

# ======= Ormawa =========== #
Route::group(['namespace' => 'ormawa'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@postLogin')->name('ormawa.login.post');
        Route::get('/logout', 'AuthController@logout')->name('ormawa.logout');
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => 'ormawa', 'prevent-back-history'], function () {
        Route::get('/page', 'HomeController@index')->name('ormawa.index');
    });

    # =========== Event Internal =========== #

    Route::group(['prefix' => 'eventinternal', 'middleware' => 'ormawa', 'optimizeImages'], function () {
        // CRUD BASIC
        Route::get('/', 'EventInternalController@index')->name('ormawa.eventinternal.index');
        Route::get('/add', 'EventInternalController@add')->name('ormawa.eventinternal.add');
        Route::get('/edit/{id_eventinternal}', 'EventInternalController@edit')->name('ormawa.eventinternal.edit');
        Route::patch('/edit/{id_eventinternal}', 'EventInternalController@update')->name('ormawa.eventinternal.update');
        Route::post('/add', 'EventInternalController@saveForm')->name('ormawa.eventinternal.save');
        Route::delete('/delete/{id_eventinternal}', 'EventInternalController@delete')->name('ormawa.eventinternal.delete');

        // ADDITIONAL CRUD
        Route::get('/pendaftar/{id_eventinternal}', 'EventInternalController@lihatPendaftar')->name('ormawa.eventinternal.pendaftar');
        Route::get('/publik/{id_eventinternal}', 'EventInternalController@lihatPublik')->name('ormawa.eventinternal.publik');
        Route::patch('/status', 'EventInternalController@updateStatus')->name('ormawa.eventinternal.statusupdate');

        Route::post('/pengajuan/save', 'EventInternalController@savePengajuan')->name('ormawa.eventinternal.save.pengajuan');
        Route::post('/pendaftaran/save', 'EventInternalController@savePendaftaran')->name('ormawa.eventinternal.save.pendaftaran');
        Route::delete('/pendaftaran/detele/{id_berkas}', 'EventInternalController@deletePendaftaran')->name('ormawa.eventinternal.delete.pendaftaran');
        Route::delete('/pengajuan/detele/{id_berkas}', 'EventInternalController@deletePengajuan')->name('ormawa.eventinternal.delete.pengajuan');

        // validate pembina
        Route::patch('/vallidasipembina', 'EventInternalController@updateValidasiPembina')->name('ormawa.eventinternal.validasi.pembina');

        // Registrasi
        Route::get('/pendaftar/export/{id_eventinternal}/{status}', 'EventInternalController@exportPendaftar')->name('ormawa.eventinternal.pendaftar.export');
        Route::get('/pendaftar/downloadberkas/{id_regis}', 'EventInternalController@downloadBerkas')->name('ormawa.eventinternal.pendaftar.downloadberkas');
        Route::get('/pendaftar/validasiregis/{id_regis}/{status}', 'EventInternalController@updateStatusRegis')->name('ormawa.eventinternal.pendaftar.updatestatus');
        Route::get('/pendaftar/validasisemua/{id_event}', 'EventInternalController@validasiSemua')->name('ormawa.eventinternal.pendaftar.validasisemua');
        Route::delete('/pendaftar/delete/{id_regis}', 'EventInternalController@deletePendaftar')->name('ormawa.eventinternal.pendaftar.hapus');
    });

    # =========== Event Eksternal =========== #

    Route::group(['prefix' => 'eventeksternal', 'middleware' => 'ormawa'], function () {
        // CRUD BASIC
        Route::get('/', 'EventEksternalController@index')->name('ormawa.eventeksternal.index');
        Route::get('/add', 'EventEksternalController@add')->name('ormawa.eventeksternal.add');
        Route::get('/edit/{id_eventeksternal}', 'EventEksternalController@edit')->name('ormawa.eventeksternal.edit');
        Route::patch('/edit/{id_eventeksternal}', 'EventEksternalController@update')->name('ormawa.eventeksternal.update');
        Route::post('/add', 'EventEksternalController@saveForm')->name('ormawa.eventeksternal.save');
        Route::delete('/delete/{id_eventeksternal}', 'EventEksternalController@delete')->name('ormawa.eventeksternal.delete');

        // ADDITIONAL CRUD
        Route::get('/pendaftar/{id_eventeksternal}', 'EventEksternalController@lihatPendaftar')->name('ormawa.eventeksternal.pendaftar');
        Route::get('detail/{event}/peserta', 'EventEksternalController@listPeserta')->name('ormawa.eventeksternal.peserta');
        Route::get('/publik/{id_eventeksternal}', 'EventEksternalController@lihatPublik')->name('ormawa.eventeksternal.publik');
        Route::patch('/status', 'EventEksternalController@updateStatus')->name('ormawa.eventeksternal.statusupdate');

        Route::post('/pengajuan/save', 'EventEksternalController@savePengajuan')->name('ormawa.eventeksternal.save.pengajuan');
        Route::post('/pendaftaran/save', 'EventEksternalController@savePendaftaran')->name('ormawa.eventeksternal.save.pendaftaran');
        Route::get('/pendaftaran/download/{id_berkas}', 'EventEksternalController@downloadPendaftaran')->name('ormawa.eventeksternal.download.pendaftaran');
        Route::delete('/pendaftaran/detele/{id_berkas}', 'EventEksternalController@deletePendaftaran')->name('ormawa.eventeksternal.delete.pendaftaran');
        Route::delete('/pengajuan/detele/{id_berkas}', 'EventEksternalController@deletePengajuan')->name('ormawa.eventeksternal.delete.pengajuan');

        // validate pembina
        Route::patch('/vallidasipembina', 'EventEksternalController@updateValidasiPembina')->name('ormawa.eventeksternal.validasi.pembina');

        // Registrasi
        Route::get('/pendaftar/export/{id_eventeksternal}/{status}', 'EventEksternalController@exportPendaftar')->name('ormawa.eventeksternal.pendaftar.export');
        Route::get('/pendaftar/downloadberkas/{id_regis}', 'EventEksternalController@downloadBerkas')->name('ormawa.eventeksternal.pendaftar.downloadberkas');
        Route::get('/pendaftar/validasiregis/{id_regis}/{status}', 'EventEksternalController@updateStatusRegis')->name('ormawa.eventeksternal.pendaftar.updatestatus');
        Route::get('/pendaftar/validasisemua/{id_event}', 'EventEksternalController@validasiSemua')->name('ormawa.eventeksternal.pendaftar.validasisemua');
        Route::delete('/pendaftar/delete/{id_regis}', 'EventEksternalController@deletePendaftar')->name('ormawa.eventeksternal.pendaftar.hapus');
    });

    # =========== Event Registration =========== #
    Route::group(['prefix' => 'registration', 'middleware' => 'ormawa'], function () {

        // Event Internal Registrations
        Route::get('/eventinternal', 'EventInternalRegisController@index')->name('ormawa.registration.eventinternal.index');
        Route::delete('/eventinternal/delete/{id_regis}', 'EventInternalRegisController@delete')->name('ormawa.registration.eventinternal.delete');
        Route::get('/eventinternal/validasiregis/{id_regis}/{status}', 'EventInternalRegisController@updateStatusRegis')->name('ormawa.registration.eventinternal.updatestatus');

        // Event Internal Registrations
        Route::get('/eventeksternal', 'EventEksternalRegisController@index')->name('ormawa.registration.eventeksternal.index');
        Route::delete('/eventeksternal/delete/{id_regis}', 'EventEksternalRegisController@delete')->name('ormawa.registration.eventeksternal.delete');
        Route::get('/eventeksternal/validasiregis/{id_regis}/{status}', 'EventEksternalRegisController@updateStatusRegis')->name('ormawa.registration.eventeksternal.updatestatus');
    });

    # =========== Prestasi peserta =========== #
    Route::group(['prefix' => 'prestasi', 'middleware' => 'ormawa'], function () {

        // event internal regis
        Route::post('/eventinternal', 'PrestasiEventInternalController@save')->name('ormawa.prestasi.eventinternal.add');

        // event eksetrnal regis
        Route::post('/eventeksternal', 'PrestasiEventEksternalController@save')->name('ormawa.prestasi.eventieksternal.add');
    });


    # =========== Team peserta =========== #
    Route::group(['prefix' => 'team', 'middleware' => 'ormawa'], function () {
        Route::get('/detail/{id_tim}', 'TeamController@detail')->name('ormawa.team.detail');
        Route::patch('/ajukanpembimbing/{id_tim}', 'TeamController@ajukanPembimbing')->name('ormawa.team.detail.ajukanpembimbing');
    });

    // Route::group(['prefix' => 'eventeksternal', 'middleware' => 'ormawa'], function () {
    //     Route::get('/', 'EventEksternalController@index')->name('ormawa.eventeksternal.index');
    //     Route::get('/add', 'EventEksternalController@add')->name('ormawa.eventeksternal.add');
    //     Route::post('/add', 'EventEksternalController@saveForm')->name('ormawa.eventeksternal.save');
    //     Route::get('detail/{event}/peserta', 'EventEksternalController@listPeserta')->name('ormawa.eventeksternal.peserta');
    // });


    # =========== Timeline =========== #

    Route::group(['prefix' => 'timeline', 'middleware' => 'ormawa'], function () {
        Route::get('/', 'timelineController@index')->name('ormawa.timeline.index');
        Route::get('/add/{type}', 'timelineController@add')->name('ormawa.timeline.add');
        Route::post('/add/{type}', 'timelineController@save')->name('ormawa.timeline.save');
        Route::get('/edit/eventinternal/{id_timeline}', 'timelineController@editInternal')->name('ormawa.timeline.editinternal');
        Route::get('/edit/eventeksternal/{id_timeline}', 'timelineController@editEksternal')->name('ormawa.timeline.editeksternal');
        Route::patch('/update/{type}', 'timelineController@update')->name('ormawa.timeline.update');
        Route::delete('/delete/{id_timeline}', 'timelineController@delete')->name('ormawa.timeline.delete');
    });

    # =========== Pengumuman =========== #

    Route::group(['prefix' => 'pengumuman', 'middleware' => 'ormawa'], function () {
        Route::get('/', 'PengumumanController@index')->name('ormawa.pengumuman.index');
        Route::get('/detail/{id_pengumuman}', 'PengumumanController@detail')->name('ormawa.pengumuman.detail');
        Route::post('/add/{type}', 'PengumumanController@save')->name('ormawa.pengumuman.save');
        Route::get('/edit/eventinternal/{id_pengumuman}', 'PengumumanController@editInternal')->name('ormawa.pengumuman.editinternal');
        Route::get('/edit/eventeksternal/{id_pengumuman}', 'PengumumanController@editEksternal')->name('ormawa.pengumuman.editeksternal');
        Route::patch('/update/{id_pengumuman}', 'PengumumanController@update')->name('ormawa.pengumuman.update');
        Route::delete('/delete/{id_pengumuman}', 'PengumumanController@delete')->name('ormawa.pengumuman.delete');
    });


    # =========== Setting =========== #


    Route::group(['prefix' => 'settings', 'middleware' => 'ormawa'], function () {
        Route::get('/profile', 'settingsController@index')->name('ormawa.settings.index');
        Route::patch('/profile', 'settingsController@updateProfile')->name('ormawa.settings.index.update');
        Route::post('/profile/pembina', 'settingsController@tambahPembina')->name('ormawa.settings.tambah.pembina');
        Route::get('/profile/pembina/{id_pembina}', 'settingsController@editPembina')->name('ormawa.settings.edit.pembina');
        Route::patch('/profile/pembina/{id_pembina}', 'settingsController@updatePembina')->name('ormawa.settings.update.pembina');
        Route::delete('/profile/pembina/{id_pembina}', 'settingsController@deletePembina')->name('ormawa.settings.delete.pembina');
        Route::get('/changepassword', 'settingsController@changePassword')->name('ormawa.settings.changepassword');
    });
});
