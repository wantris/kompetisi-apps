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
Route::get('/', function () {
    return view('home');
});

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
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/page', 'HomeController@index')->name('ormawa.index');
    });

    Route::group(['prefix' => 'event'], function () {
        Route::get('/', 'eventController@index')->name('ormawa.event.index');
        Route::get('/add', 'eventController@add')->name('ormawa.event.add');
        Route::post('/add', 'eventController@saveForm')->name('ormawa.event.save');
        Route::get('detail/{event}/peserta', 'eventController@listPeserta')->name('ormawa.event.peserta');
    });

    Route::group(['prefix' => 'steps'], function () {
        Route::get('/list', 'stepController@index')->name('ormawa.step.index');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/profile', 'settingsController@index')->name('ormawa.settings.index');
        Route::get('/changepassword', 'settingsController@changePassword')->name('ormawa.settings.changepassword');
    });
});
