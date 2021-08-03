<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'ormawa'], function () {
        Route::get('/', 'Api\ormawaController@index')->name('ormawa.index');
        Route::get('/add', 'Api\ormawaController@add')->name('ormawa.add');
        Route::post('/add', 'ormawaController@save')->name('ormawa.save');
        Route::get('/detail/{id_ormawa}', 'Api\ormawaController@detail')->name('ormawa.detail');
        Route::get('/edit/{id_ormawa}', 'ormawaController@edit')->name('ormawa.edit');
        Route::post('/update/{id_ormawa}', 'Api\ormawaController@update')->name('ormawa.update');
        Route::delete('/delete/{id_ormawa}', 'ormawaController@edit')->name('ormawa.delete');
    });

    Route::group(['prefix' => 'participant'], function () {
        Route::get('/', 'Api\participantController@index')->name('participant.index');
        Route::get('/add', 'Api\participantController@add')->name('participant.add');
        Route::post('/add', 'Api\participantController@save')->name('participant.save');
        Route::get('/detail/{id_participant}', 'Api\participantController@detail')->name('participant.detail');
        Route::get('/edit/{id_participant}', 'Api\participantController@edit')->name('participant.edit');
        Route::post('/update/{id_participant}', 'Api\participantController@update')->name('participant.update');
        Route::delete('/delete/{id_participant}', 'Api\participantController@edit')->name('participant.delete');
    });

    Route::group(['prefix' => 'pengguna/mahasiswa'], function () {
        Route::get('/', 'Api\mahasiswaController@index')->name('mahasiswa.index');
        Route::get('/add', 'Api\mahasiswaController@add')->name('mahasiswa.add');
        Route::post('/add', 'Api\mahasiswaController@save')->name('mahasiswa.save');
        Route::get('/detail/{nim}', 'Api\mahasiswaController@detail')->name('mahasiswa.detail');
        Route::get('/edit/{nim}', 'Api\mahasiswaController@edit')->name('mahasiswa.edit');
        Route::post('/update/{nim}', 'Api\mahasiswaController@update')->name('mahasiswa.update');
        Route::delete('/delete/{nim}', 'Api\mahasiswaController@edit')->name('mahasiswa.delete');
    });

    Route::group(['prefix' => 'pengguna/dosen'], function () {
        Route::get('/', 'Api\dosenController@index')->name('dosen.index');
        Route::get('/add', 'Api\dosenController@add')->name('dosen.add');
        Route::post('/add', 'Api\dosenController@save')->name('dosen.save');
        Route::get('/detail/{nidn}', 'Api\dosenController@detail')->name('dosen.detail');
        Route::get('/edit/{nidn}', 'Api\dosenController@edit')->name('dosen.edit');
        Route::post('/update/{nidn}', 'Api\dosenController@update')->name('dosen.update');
        Route::delete('/delete/{nidn}', 'Api\dosenController@edit')->name('dosen.delete');
    });

    Route::group(['prefix' => 'eventinternal'], function () {
        Route::get('/', 'Api\eventInternalController@index')->name('eventinternal.index');
        Route::get('/add', 'Api\eventInternalController@add')->name('eventinternal.add');
        Route::post('/add', 'Api\eventInternalController@save')->name('eventinternal.save');
        Route::get('/detail/{id_eventinternal}', 'Api\eventInternalController@detail')->name('eventinternal.detail');
        Route::get('/edit/{id_eventinternal}', 'Api\eventInternalController@edit')->name('eventinternal.edit');
        Route::post('/update/{id_eventinternal}', 'Api\eventInternalController@update')->name('eventinternal.update');
        Route::delete('/delete/{id_eventinternal}', 'Api\eventInternalController@edit')->name('eventinternal.delete');

        Route::get('/pengajuan/{id_eventinternal}', 'Api\eventInternalController@seePengajuan')->name('eventinternal.pengajuan');
        Route::post('/pengajuan/{id_eventinternal}', 'Api\eventInternalController@terimaPengajuan')->name('eventinternal.pengajuan.update');
    });

    Route::group(['prefix' => 'eventeksternal'], function () {
        Route::get('/', 'Api\eventeksternalController@index')->name('eventeksternal.index');
        Route::get('/add', 'Api\eventeksternalController@add')->name('eventeksternal.add');
        Route::post('/add', 'Api\eventeksternalController@save')->name('eventeksternal.save');
        Route::get('/detail/{id_eventeksternal}', 'Api\eventeksternalController@detail')->name('eventeksternal.detail');
        Route::get('/edit/{id_eventeksternal}', 'Api\eventeksternalController@edit')->name('eventeksternal.edit');
        Route::post('/update/{id_eventeksternal}', 'Api\eventeksternalController@update')->name('eventeksternal.update');
        Route::delete('/delete/{id_eventeksternal}', 'Api\eventeksternalController@edit')->name('eventeksternal.delete');

        Route::get('/pengajuan/{id_eventeksternal}', 'Api\eventeksternalController@seePengajuan')->name('eventeksternal.pengajuan');
        Route::post('/pengajuan/{id_eventeksternal}', 'Api\eventeksternalController@terimaPengajuan')->name('eventeksternal.pengajuan.update');
    });

    Route::group(['prefix' => 'pengguna'], function () {
        Route::get('/', 'Api\penggunaController@index')->name('pengguna.index');
        Route::get('/add', 'Api\penggunaController@add')->name('pengguna.add');
        Route::post('/add', 'Api\penggunaController@save')->name('pengguna.save');
        Route::get('/detail/{id_pengguna}', 'Api\penggunaController@detail')->name('pengguna.detail');
        Route::get('/edit/{id_pengguna}', 'Api\penggunaController@edit')->name('pengguna.edit');
        Route::post('/update/{id_pengguna}', 'Api\penggunaController@update')->name('pengguna.update');
        Route::delete('/delete/{id_pengguna}', 'Api\penggunaController@edit')->name('pengguna.delete');
    });

    Route::group(['prefix' => 'team'], function () {
        Route::get('/', 'Api\teamController@index')->name('team.index');
        Route::get('/eventinternal', 'Api\teamController@getAllByEventInternal')->name('team.eventinternal.index');
        Route::get('/eventeksternal', 'Api\teamController@getAllByEventEksternal')->name('team.eventeksternal.index');
        Route::get('/add', 'Api\teamController@add')->name('team.add');
        Route::post('/add', 'Api\teamController@save')->name('team.save');
        Route::get('/detail/{id_team}', 'Api\teamController@detail')->name('team.detail');
        Route::get('/edit/{id_team}', 'Api\teamController@edit')->name('team.edit');
        Route::post('/update/{id_team}', 'Api\teamController@update')->name('team.update');
        Route::delete('/delete/{id_team}', 'Api\teamController@edit')->name('team.delete');
    });

    Route::group(['prefix' => 'registration'], function () {
        // eventinternal 
        Route::get('/eventinternal', 'Api\EventInternalRegisController@index')->name('registrations.eventinternal.index');

        Route::get('/eventeksternal', 'Api\EventEksternalRegisController@index')->name('registrations.eventeksternal.index');
    });
});
