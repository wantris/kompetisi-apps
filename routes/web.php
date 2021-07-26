<?php

use Illuminate\Support\Facades\Route;

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


# ======= Landing page =========== #
Route::get('/', 'landing\homeController@index')->name('project.index');

Route::get('/ormawa/detail/{name}', 'Landing\ormawaController@index')->name('ormawa.detail.index');

// Login khusus terima undangan
Route::get('/login', 'landing\homeController@login')->name('project.login.index');
Route::post('/login', 'landing\homeController@postLogin')->name('project.login.post');

// event
Route::group(['prefix' => 'event', 'namespace' => 'landing'], function () {
    Route::get('/', 'eventController@index')->name('event.index');
    Route::get('/detail/{slug}', 'eventController@detail')->name('event.detail');
    Route::get('/timeline/{slug}', 'eventController@timeline')->name('event.timeline');
    Route::get('/registration/{slug}', 'eventController@registration')->name('event.registration.get');
    Route::get('/registration/team/{slug}', 'eventController@registrationTeam')->name('event.registration.team');
    Route::get('/users/search/{id}', 'eventController@searchPengguna')->name('event.users.search');
    Route::post('/registration/team/save/{slug}', 'eventController@saveRegistrationTeam')->name('event.registration.team.save');
    Route::get('/registration/team/invite/sendmail', 'eventController@sendMail')->name('event.registration.team.sendmail');
    Route::get('/invitation/team/{id_detail}', 'eventController@lookInvitation')->name('event.invitation.look');
});

// Blog
Route::group(['prefix' => 'blog', 'namespace' => 'landing'], function () {
    Route::get('/', 'BlogController@index')->name('blog.index');
    Route::get('/{slug}', 'BlogController@detail')->name('blog.detail');
});

// contact
Route::group(['prefix' => 'contact', 'namespace' => 'landing'], function () {
    Route::get('/', 'ContactController@index')->name('contact.index');
});

// Login 
Route::group(['prefix' => 'login', 'namespace' => 'auth'], function () {
    Route::get('/peserta', 'LoginController@index')->name('login.peserta.index');
    Route::get('/ormawa', 'LoginController@index')->name('login.ormawa.index');
});

// Login 
Route::group(['prefix' => 'passwordreset', 'namespace' => 'auth'], function () {
    Route::get('/', 'PasswordResetController@index')->name('password.reset');
});


# ======= Admin =========== #
Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {
    Route::group(['prefix' => 'login'], function () {
        Route::get('/', 'adminLoginController@index')->name('admin.login.index');
    });
});


# ======= peserta =========== #
Route::group(['prefix' => 'peserta', 'namespace' => 'peserta'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@postLogin')->name('peserta.login.post');
        Route::get('/logout', 'AuthController@logout')->name('peserta.logout');
        Route::get('/register', 'AuthController@register')->name('peserta.register');
        Route::post('/register', 'AuthController@registerSave')->name('peserta.register.save');
        Route::get('/register/success', 'AuthController@registerSuccess')->name('peserta.register.success');
    });

    Route::get('/dashboard', 'HomeController@index')->name('peserta.index');


    Route::group(['prefix' => 'eventinternal'], function () {
        Route::get('/', 'eventInternalController@index')->name('peserta.eventinternal.index');

        Route::post('/filter/active', 'eventInternalController@filterEventAktif')->name('peserta.eventinternal.filterkategori.aktif');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/{slug}', 'eventInternalController@detail')->name('peserta.eventinternal.detail');
             Route::post('/uploadfile/{id_regis}', 'eventInternalController@uploadFile')->name('peserta.eventinternal.detail.upload');

            Route::get('/submission/{slug}/all', 'eventInternalController@submission')->name('peserta.event.submission');
            Route::get('/submission/{slug}/info', 'eventInternalController@info')->name('peserta.event.submission.info');

            Route::get('/notification/{slug}', 'eventInternalController@notification')->name('peserta.eventinternal.notification');
            Route::get('/notification/detail/{slug}', 'eventInternalController@detailNotification')->name('peserta.eventinternal.notification.detail');
            Route::get('/timeline/{slug}', 'eventInternalController@timeline')->name('peserta.eventinternal.timeline');
        });
    });

    Route::group(['prefix' => 'eventeksternal'], function () {
        Route::get('/', 'eventEksternalController@index')->name('peserta.eventeksternal.index');

        // Route::post('/filter/active', 'eventEksternalController@filterEventAktif')->name('peserta.eventeksternal.filterkategori.aktif');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/{slug}', 'eventEksternalController@detail')->name('peserta.eventeksternal.detail');
            Route::post('/uploadfile/{id_regis}', 'eventEksternalController@uploadFile')->name('peserta.eventeksternal.detail.upload');
            Route::post('/register/{slug}', 'eventEksternalController@register')->name('peserta.eventeksternal.register');
            Route::get('/submission/{slug}/all', 'eventEksternalController@submission')->name('peserta.event.submission');
            Route::get('/submission/{slug}/info', 'eventEksternalController@info')->name('peserta.event.submission.info');

            Route::get('/notification/{slug}', 'eventEksternalController@notification')->name('peserta.eventeksternal.notification');
            Route::get('/notification/detail/{slug}', 'eventEksternalController@detailNotification')->name('peserta.eventeksternal.notification.detail');
            Route::get('/timeline/{slug}', 'eventEksternalController@timeline')->name('peserta.eventeksternal.timeline');
        });
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index')->name('peserta.account.index');
        Route::patch('/save', 'AccountController@postAccount')->name('peserta.account.save');
        Route::patch('/savephoto', 'AccountController@savePhoto')->name('peserta.account.save.photo');
        Route::patch('/save/socialmedia', 'AccountController@saveSocialMedia')->name('peserta.account.save.socialmedia');
    });


    Route::group(['prefix' => 'team'], function () {
        Route::get('/', 'TeamController@index')->name('peserta.team.index');
        Route::get('/detail/{id}', 'TeamController@detail')->name('peserta.team.detail');
        Route::get('/users/search/{id}', 'TeamController@searchPengguna')->name('peserta.team.detail.search');
        Route::patch('/users/ajukanpembimbing/{id}', 'TeamController@ajukanPembimbing')->name('peserta.team.detail.ajukanpembimbing');
        Route::post('/users/invite/{id}', 'TeamController@invitePengguna')->name('peserta.team.detail.invite');
        Route::patch('/users/invite/accept/{id}', 'TeamController@acceptInvitation')->name('peserta.team.detail.invite.accept');
        Route::delete('/users/invite/denied/{id}', 'TeamController@deniedInvitation')->name('peserta.team.detail.invite.denied');
    });
});

# ======= Ormawa =========== #
Route::group(['prefix' => 'ormawa', 'namespace' => 'ormawa'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@postLogin')->name('ormawa.login.post');
        Route::get('/logout', 'AuthController@logout')->name('ormawa.logout');
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => 'ormawa'], function () {
        Route::get('/page', 'HomeController@index')->name('ormawa.index');
    });

    Route::group(['prefix' => 'eventinternal', 'middleware' => 'ormawa'], function () {
        // CRUD BASIC
        Route::get('/', 'EventInternalController@index')->name('ormawa.eventinternal.index');
        Route::get('/add', 'EventInternalController@add')->name('ormawa.eventinternal.add');
        Route::get('/edit/{id_eventinternal}', 'EventInternalController@edit')->name('ormawa.eventinternal.edit');
        Route::patch('/edit/{id_eventinternal}', 'EventInternalController@update')->name('ormawa.eventinternal.update');
        Route::post('/add', 'EventInternalController@saveForm')->name('ormawa.eventinternal.save');
        Route::delete('/delete/{id_eventinternal}', 'EventInternalController@delete')->name('ormawa.eventinternal.delete');

        // ADDITIONAL CRUD
        Route::get('/pendaftar/{id_eventinternal}', 'EventInternalController@lihatPendaftar')->name('ormawa.eventinternal.pendaftar');        
        // Route::get('detail/{event}/peserta', 'EventInternalController@listPeserta')->name('ormawa.eventinternal.peserta');
        Route::get('/publik/{id_eventinternal}', 'EventInternalController@lihatPublik')->name('ormawa.eventinternal.publik');
        Route::patch('/status', 'EventInternalController@updateStatus')->name('ormawa.eventinternal.statusupdate');

        Route::post('/pengajuan/save', 'EventInternalController@savePengajuan')->name('ormawa.eventinternal.save.pengajuan');
        Route::post('/pendaftaran/save', 'EventInternalController@savePendaftaran')->name('ormawa.eventinternal.save.pendaftaran');
        Route::delete('/pendaftaran/detele/{id_berkas}', 'EventInternalController@deletePendaftaran')->name('ormawa.eventinternal.delete.pendaftaran');
        Route::delete('/pengajuan/detele/{id_berkas}', 'EventInternalController@deletePengajuan')->name('ormawa.eventinternal.delete.pengajuan');

        // validate pembina
        Route::patch('/vallidasipembina', 'EventInternalController@updateValidasiPembina')->name('ormawa.eventinternal.validasi.pembina');

        // Registrasi
        Route::get('/pendaftar/downloadberkas/{id_regis}', 'EventInternalController@downloadBerkas')->name('ormawa.eventinternal.pendaftar.downloadberkas');
        Route::get('/pendaftar/validasiregis/{id_regis}/{status}', 'EventInternalController@updateStatusRegis')->name('ormawa.eventinternal.pendaftar.updatestatus');
        Route::get('/pendaftar/validasisemua/{id_event}', 'EventInternalController@validasiSemua')->name('ormawa.eventinternal.pendaftar.validasisemua');
        Route::delete('/pendaftar/delete/{id_regis}', 'EventInternalController@deletePendaftar')->name('ormawa.eventinternal.pendaftar.hapus');
    });

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
        Route::get('/pendaftar/downloadberkas/{id_regis}', 'EventEksternalController@downloadBerkas')->name('ormawa.eventeksternal.pendaftar.downloadberkas');
        Route::get('/pendaftar/validasiregis/{id_regis}/{status}', 'EventEksternalController@updateStatusRegis')->name('ormawa.eventeksternal.pendaftar.updatestatus');
        Route::get('/pendaftar/validasisemua/{id_event}', 'EventEksternalController@validasiSemua')->name('ormawa.eventeksternal.pendaftar.validasisemua');
        Route::delete('/pendaftar/delete/{id_regis}', 'EventEksternalController@deletePendaftar')->name('ormawa.eventeksternal.pendaftar.hapus');
    });

    Route::group(['prefix' => 'team', 'middleware' => 'ormawa'], function () {
        Route::get('/detail/{id_tim}', 'TeamController@detail')->name('ormawa.team.detail');
         Route::patch('/ajukanpembimbing/{id_tim}', 'TeamController@ajukanPembimbing')->name('ormawa.team.detail.ajukanpembimbing');

    });

    Route::group(['prefix' => 'eventeksternal', 'middleware' => 'ormawa'], function () {
        Route::get('/', 'EventEksternalController@index')->name('ormawa.eventeksternal.index');
        Route::get('/add', 'EventEksternalController@add')->name('ormawa.eventeksternal.add');
        Route::post('/add', 'EventEksternalController@saveForm')->name('ormawa.eventeksternal.save');
        Route::get('detail/{event}/peserta', 'EventEksternalController@listPeserta')->name('ormawa.eventeksternal.peserta');
    });

    Route::group(['prefix' => 'timeline', 'middleware' => 'ormawa'], function () {
        Route::get('/', 'timelineController@index')->name('ormawa.timeline.index');
        Route::get('/add/{type}', 'timelineController@add')->name('ormawa.timeline.add');
        Route::post('/add/{type}', 'timelineController@save')->name('ormawa.timeline.save');
        Route::get('/edit/eventinternal/{id_timeline}', 'timelineController@editInternal')->name('ormawa.timeline.editinternal');
        Route::get('/edit/eventeksternal/{id_timeline}', 'timelineController@editEksternal')->name('ormawa.timeline.editeksternal');
        Route::patch('/update/{type}', 'timelineController@update')->name('ormawa.timeline.update');
        Route::delete('/delete/{id_timeline}', 'timelineController@delete')->name('ormawa.timeline.delete');
    });

    Route::group(['prefix' => 'pengumuman', 'middleware' => 'ormawa'], function () {
        Route::get('/', 'PengumumanController@index')->name('ormawa.pengumuman.index');
        Route::get('/detail/{id_pengumuman}', 'PengumumanController@detail')->name('ormawa.pengumuman.detail');
        Route::post('/add/{type}', 'PengumumanController@save')->name('ormawa.pengumuman.save');
        Route::get('/edit/eventinternal/{id_pengumuman}', 'PengumumanController@editInternal')->name('ormawa.pengumuman.editinternal');
        Route::get('/edit/eventeksternal/{id_pengumuman}', 'PengumumanController@editEksternal')->name('ormawa.pengumuman.editeksternal');
        Route::patch('/update/{id_pengumuman}', 'PengumumanController@update')->name('ormawa.pengumuman.update');
        Route::delete('/delete/{id_pengumuman}', 'PengumumanController@delete')->name('ormawa.pengumuman.delete');
    });

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

// Dosen
Route::group(['prefix' => 'dosen', 'namespace' => 'Dosen'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dosen.index');

    Route::group(['prefix' => 'riwayat'], function () {
        Route::get('/', 'riwayatController@index')->name('riwayat.dosen.index');
    });
});
