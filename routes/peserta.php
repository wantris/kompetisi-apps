<?php

use Illuminate\Support\Facades\Route;

# ======= peserta =========== #
Route::group(['namespace' => 'peserta'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@postLogin')->name('peserta.login.post');
        Route::get('/logout', 'AuthController@logout')->name('peserta.logout');
        Route::get('/register', 'AuthController@register')->name('peserta.register');
        Route::post('/register', 'AuthController@registerSave')->name('peserta.register.save');
        Route::get('/register/success', 'AuthController@registerSuccess')->name('peserta.register.success');
    });

    Route::get('/dashboard', 'HomeController@index')->name('peserta.index');
    Route::get('/dashboard/getalldata', 'HomeController@getAll')->name('peserta.index.getall');


    Route::group(['prefix' => 'eventinternal'], function () {
        Route::get('/', 'eventInternalController@index')->name('peserta.eventinternal.index');

        Route::post('/filter/active', 'eventInternalController@filterEventAktif')->name('peserta.eventinternal.filterkategori.aktif');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/{slug}', 'eventInternalController@detail')->name('peserta.eventinternal.detail');
            Route::get('/favourite/check/{id_eventinternal}', 'eventInternalController@checkIsFavourite')->name('peserta.eventinternal.favourite.check');
            Route::get('/favourite/add/{id_eventinternal}', 'eventInternalController@addFavourite')->name('peserta.eventinternal.favourite.add');
            Route::get('/favourite/remove/{id_eventinternal}', 'eventInternalController@removeFavourite')->name('peserta.eventinternal.favourite.remove');
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
        Route::get('/users/search/{id}', 'eventEksternalController@searchPengguna')->name('peserta.eventeksternal.search');


        // Route::post('/filter/active', 'eventEksternalController@filterEventAktif')->name('peserta.eventeksternal.filterkategori.aktif');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/{slug}', 'eventEksternalController@detail')->name('peserta.eventeksternal.detail');
            Route::get('/favourite/check/{id_eventeksternal}', 'eventEksternalController@checkIsFavourite')->name('peserta.eventeksternal.favourite.check');
            Route::get('/favourite/add/{id_eventeksternal}', 'eventEksternalController@addFavourite')->name('peserta.eventeksternal.favourite.add');
            Route::get('/favourite/remove/{id_eventeksternal}', 'eventEksternalController@removeFavourite')->name('peserta.eventeksternal.favourite.remove');

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

    Route::group(['prefix' => 'registration'], function () {
        // eventinternal
        Route::get('/eventinternal', 'EventInternalRegisController@index')->name('peserta.regis.eventinternal.index');
        Route::get('/eventinternal/list', 'EventInternalRegisController@getAllRegistration')->name('peserta.regis.eventinternal.list');
    });
});
