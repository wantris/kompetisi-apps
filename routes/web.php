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









// Dosen
Route::group(['prefix' => 'dosen', 'namespace' => 'Dosen'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dosen.index');

    Route::group(['prefix' => 'riwayat'], function () {
        Route::get('/', 'riwayatController@index')->name('riwayat.dosen.index');
    });
});
