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

Route::get('/ormawa/{name}', 'Landing\ormawaController@index')->name('ormawa.index');

// Kompetisi
Route::group(['prefix' => 'kompetisi', 'namespace' => 'landing'], function () {
    Route::get('/', 'kompetisiController@index')->name('kompetisi.index');
    Route::get('/detail/{slug}', 'kompetisiController@detail')->name('kompetisi.detail');
    Route::get('/timeline/{slug}', 'kompetisiController@timeline')->name('kompetisi.timeline');
    Route::get('/registration/team/{slug}', 'kompetisiController@registrationTeam')->name('kompetisi.registration.team');
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
    Route::get('/mahasiswa', 'LoginController@index')->name('login.mahasiswa.index');
    Route::get('/ormawa', 'LoginController@index')->name('login.ormawa.index');
});

// Login 
Route::group(['prefix' => 'passwordreset', 'namespace' => 'auth'], function () {
    Route::get('/', 'PasswordResetController@index')->name('password.reset');
});


# ======= Mahasiswa =========== #
Route::group(['prefix' => 'mahasiswa'], function () {
    Route::group(['prefix' => 'dashboard', 'namespace' => 'mahasiswa'], function () {
        Route::get('/', 'HomeController@index')->name('mahasiswa.index');
    });

    Route::group(['prefix' => 'kompetisi', 'namespace' => 'mahasiswa'], function () {
        Route::get('/', 'KompetisiController@index')->name('mahasiswa.kompetisi.index');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/title/{slug}', 'KompetisiController@detail')->name('mahasiswa.kompetisi.detail');
            Route::get('/submission/{slug}/all', 'KompetisiController@submission')->name('mahasiswa.kompetisi.submission');
            Route::get('/submission/{slug}/info', 'KompetisiController@info')->name('mahasiswa.kompetisi.submission.info');

            Route::get('/notification/{slug}', 'KompetisiController@notification')->name('mahasiswa.kompetisi.notification');
            Route::get('/timeline/{slug}', 'KompetisiController@timeline')->name('mahasiswa.kompetisi.timeline');
        });
    });
});
