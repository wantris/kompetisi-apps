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

// event
Route::group(['prefix' => 'event', 'namespace' => 'landing'], function () {
    Route::get('/', 'eventController@index')->name('event.index');
    Route::get('/detail/{slug}', 'eventController@detail')->name('event.detail');
    Route::get('/timeline/{slug}', 'eventController@timeline')->name('event.timeline');
    Route::get('/registration/team/{slug}', 'eventController@registrationTeam')->name('event.registration.team');
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

    Route::get('/dashboard', 'HomeController@index')->name('peserta.index');


    Route::group(['prefix' => 'event'], function () {
        Route::get('/', 'eventController@index')->name('peserta.event.index');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/title/{slug}', 'eventController@detail')->name('peserta.event.detail');
            Route::get('/submission/{slug}/all', 'eventController@submission')->name('peserta.event.submission');
            Route::get('/submission/{slug}/info', 'eventController@info')->name('peserta.event.submission.info');

            Route::get('/notification/{slug}', 'eventController@notification')->name('peserta.event.notification');
            Route::get('/timeline/{slug}', 'eventController@timeline')->name('peserta.event.timeline');
        });
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index')->name('peserta.account.index');
    });


    Route::group(['prefix' => 'team'], function () {
        Route::get('/', 'TeamController@index')->name('peserta.team.index');
        Route::get('/detail/{id}', 'TeamController@detail')->name('peserta.team.detail');
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

    Route::group(['prefix' => 'eventinternal'], function () {
        Route::get('/', 'EventInternalController@index')->name('ormawa.eventinternal.index');
        Route::get('/add', 'EventInternalController@add')->name('ormawa.eventinternal.add');
        Route::get('/edit/{id_eventinternal}', 'EventInternalController@edit')->name('ormawa.eventinternal.edit');
        Route::get('/publik/{id_eventinternal}', 'EventInternalController@lihatPublik')->name('ormawa.eventinternal.publik');
        Route::get('/pendaftar/{id_eventinternal}', 'EventInternalController@lihatPendaftar')->name('ormawa.eventinternal.pendaftar');
        Route::post('/add', 'EventInternalController@saveForm')->name('ormawa.eventinternal.save');
        Route::patch('/status', 'EventInternalController@updateStatus')->name('ormawa.eventinternal.statusupdate');
        Route::delete('/delete/{id_eventinternal}', 'EventInternalController@delete')->name('ormawa.eventinternal.delete');
        Route::get('detail/{event}/peserta', 'EventInternalController@listPeserta')->name('ormawa.eventinternal.peserta');
    });

    Route::group(['prefix' => 'eventeksternal'], function () {
        Route::get('/', 'EventEksternalController@index')->name('ormawa.eventeksternal.index');
        Route::get('/add', 'EventEksternalController@add')->name('ormawa.eventeksternal.add');
        Route::post('/add', 'EventEksternalController@saveForm')->name('ormawa.eventeksternal.save');
        Route::get('detail/{event}/peserta', 'EventEksternalController@listPeserta')->name('ormawa.eventeksternal.peserta');
    });

    Route::group(['prefix' => 'timeline'], function () {
        Route::get('/', 'timelineController@index')->name('ormawa.timeline.index');
        Route::get('/add/{type}', 'timelineController@add')->name('ormawa.timeline.add');
        Route::post('/add/{type}', 'timelineController@save')->name('ormawa.timeline.save');
        Route::get('/edit/eventinternal/{id_timeline}', 'timelineController@editInternal')->name('ormawa.timeline.editinternal');
        Route::get('/edit/eventeksternal/{id_timeline}', 'timelineController@editEksternal')->name('ormawa.timeline.editeksternal');
        Route::patch('/update/{type}', 'timelineController@update')->name('ormawa.timeline.update');
        Route::delete('/delete/{id_timeline}', 'timelineController@delete')->name('ormawa.timeline.delete');
        Route::get('detail/{event}/peserta', 'timelineController@listPeserta')->name('ormawa.timeline.peserta');
    });

    Route::group(['prefix' => 'steps'], function () {
        Route::get('/list', 'stepController@index')->name('ormawa.step.index');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/profile', 'settingsController@index')->name('ormawa.settings.index');
        Route::patch('/profile', 'settingsController@updateProfile')->name('ormawa.settings.index.update');
        Route::post('/profile/pembina', 'settingsController@tambahPembina')->name('ormawa.settings.tambah.pembina');
        Route::get('/profile/pembina/{id_pembina}', 'settingsController@editPembina')->name('ormawa.settings.edit.pembina');
        Route::patch('/profile/pembina/{id_pembina}', 'settingsController@updatePembina')->name('ormawa.settings.update.pembina');
        Route::delete('/profile/pembina/{id_pembina}', 'settingsController@deletePembina')->name('ormawa.settings.delete.pembina');
        Route::get('/changepassword', 'settingsController@changePassword')->name('ormawa.settings.changepassword');
    });
});
