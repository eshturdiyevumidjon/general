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

Route::get('/', function () {
    return view('welcome');
});

Route::get('language/set', function () {

    $user = \Illuminate\Support\Facades\Auth::user();

    Session::put('locale', \Illuminate\Support\Facades\Input::get('lang'));
    $user->lang_prefix = \Illuminate\Support\Facades\Input::get('lang');
    $user->save();

    return redirect()->back();
})->name('minvodxoz.lang.set');

Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect(url('/login'));
})->name('logout');

Route::get('/login_general', function () {
    return view('auth/login_general');
});

Route::group(['prefix' => 'general', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('general.pages.dashboard');
    })->name('general.dashboard');


    Route::group(['prefix' => 'report'], function () {
        Route::get('/', 'App\Http\Controllers\General\WordExportController@index')->name('general.report.index');
        Route::post('/export', 'App\Http\Controllers\General\WordExportController@GenereteWord')->name('general.word.export');
    });

    Route::group(['prefix' => 'resources'], function () {
        Route::group(['prefix' => 'resource_regions'], function () {

            Route::get('/', 'General\ResourcesRegionsController@index')->name('general.resource');
            Route::get('/index_with', 'General\ResourcesRegionsController@Indexwith')->name('general.resource.resource_regions_with');
            Route::post('/update', 'General\ResourcesRegionsController@update')->name('general.resource.resource_regions.update');
            Route::post('/accept', 'General\ResourcesRegionsController@Accept')->name('general.resource.resource_regions.accept');
        });

        Route::group(['prefix' => 'uw_reserfs'], function () {
            Route::get('/', 'General\UwReserfController@index')->name('general.resource.uw_reserf');
            Route::post('/update', 'General\UwReserfController@update')->name('general.resource.uw_reserf.update');
            Route::post('/accept', 'General\UwReserfController@Accept')->name('general.resource.uw_reserf.accept');
        });

        Route::group(['prefix' => 'water_uses'], function () {
            Route::get('/', 'General\WaterUsesController@index')->name('general.resource.water_uses');
            Route::post('/update', 'General\WaterUsesController@update')->name('general.resource.water_uses.update');
            Route::post('/accept', 'General\WaterUsesController@Accept')->name('general.resource.water_uses.accept');
        });

        Route::group(['prefix' => 'river_recources'], function () {
            Route::get('/', 'General\RiverFlowRecourcesController@index')->name('general.resource.river_recources');
            Route::post('/update', 'General\RiverFlowRecourcesController@update')->name('general.resource.river_recources.update');
            Route::post('/accept', 'General\RiverFlowRecourcesController@Accept')->name('general.resource.river_recources.accept');
        });

        Route::group(['prefix' => 'ground_water'], function () {
            Route::get('/', 'General\GroundWaterController@index')->name('general.resource.ground_water');
            Route::post('/update', 'General\GroundWaterController@update')->name('general.resource.ground_water.update');
            Route::post('/accept', 'General\GroundWaterController@Accept')->name('general.resource.ground_water.accept');
        });

        Route::group(['prefix' => 'ground_water_use'], function () {
            Route::get('/', 'General\GroundWaterUseController@index')->name('general.resource.ground_water_use');
            Route::post('/update', 'General\GroundWaterUseController@update')->name('general.resource.ground_water_use.update');
            Route::post('/accept', 'General\GroundWaterUseController@Accept')->name('general.resource.ground_water_use.accept');
        });

        Route::group(['prefix' => 'water_use_various_needs'], function () {
            Route::get('/', 'General\WaterUseVariousController@index')->name('general.resource.water_use_various_needs');
            Route::post('/update', 'General\WaterUseVariousController@update')->name('general.resource.water_use_various_needs.update');
            Route::post('/accept', 'General\WaterUseVariousController@Accept')->name('general.resource.water_use_various_needs.accept');
        });

        Route::group(['prefix' => 'information_large_canals_irigation_system'], function () {
            Route::get('/', 'General\InformationLargeCanalsIrigationSystem@index')->name('general.resource.information_large_canals_irigation_system');
            Route::post('/update', 'General\InformationLargeCanalsIrigationSystem@update')->name('general.resource.information_large_canals_irigation_system.update');
            Route::post('/accept', 'General\InformationLargeCanalsIrigationSystem@Accept')->name('general.resource.information_large_canals_irigation_system.accept');
        });

        Route::group(['prefix' => 'change_water_reserves'], function () {
            Route::get('/', 'General\ChangeWaterReservesController@index')->name('general.resource.change_water_reserves');
            Route::post('/update', 'General\ChangeWaterReservesController@update')->name('general.resource.change_water_reserves.update');
            Route::post('/accept', 'General\ChangeWaterReservesController@Accept')->name('general.resource.change_water_reserves.accept');
        });

        Route::group(['prefix' => 'characteristics_water'], function () {
            Route::get('/', 'General\CharacteristicsWatersController@index')->name('general.resource.characteristics_water');
            Route::post('/update', 'General\CharacteristicsWatersController@update')->name('general.resource.characteristics_water.update');
            Route::post('/store', 'General\CharacteristicsWatersController@store')->name('general.resource.characteristics_water.store');
            Route::post('/accept', 'General\CharacteristicsWatersController@Accept')->name('general.resource.characteristics_water.accept');
        });
    });


    Route::prefix('/exchange')->group(function () {
        Route::get('/', 'General\DataExchangeController@index')->name('general.exchange-index');
        Route::post('/', 'General\DataExchangeController@index')->name('general.exchange-index-post');
        Route::get('/sird-form', 'General\DataExchangeController@SirdForm')->name('general.get-oper-form');
        Route::post('/delete-object-from-sird', 'General\DataExchangeController@deleteObjFromSird')->name('general.post-delete-object-from-sird');
        Route::post('/change-sird', 'General\DataExchangeController@AjaxChangeSird')->name('general.ajax-change-sird');
        Route::post('/select-element', 'General\DataExchangeController@AjaxSelectElement')->name('general.ajax-select-element');
        Route::get('/amu-form', 'General\DataExchangeController@AmuForm')->name('general.get-amu-form');
        Route::get('/reservoir-form', 'General\DataExchangeController@ReservoirForm')->name('general.get-reservoir-form');
        Route::post('/delete-object-from-res', 'General\DataExchangeController@deleteObjFromRes')->name('general.post-delete-object-from-res');
        Route::post('/delete-object-from-amu', 'General\DataExchangeController@deleteObjFromAmu')->name('general.post-delete-object-from-amu');
        Route::post('/add-object-res', 'General\DataExchangeController@AddObjectRes')->name('general.post-add-object-res');
        Route::get('/daily-form', 'General\DataExchangeController@DailyForm')->name('general.get-daily-form');
        Route::post('/delete-object-from-daily', 'General\DataExchangeController@deleteObjFromDaily')->name('general.post-delete-object-from-daily');
        Route::get('/add-value', 'General\DataExchangeController@AddValueAjax')->name('general.add-value-ajax');
        Route::post('/add-infoadd-object-info-ajax', 'General\DataExchangeController@AddInfoAjax')->name('general.add-object-info-ajax');
    });


    Route::group(['prefix' => 'directories'], function () {
        Route::group(['prefix' => 'list_posts'], function () {
            Route::get('/', 'App\Http\Controllers\General\ListPostsController@index')->name('general.directories.list_posts');
            Route::get('/edit', 'App\Http\Controllers\General\ListPostsController@edit')->name('general.directories.list_posts.edit');
            Route::post('/update', 'App\Http\Controllers\General\ListPostsController@update')->name('general.directories.list_posts.update');
            Route::post('/store', 'App\Http\Controllers\General\ListPostsController@store')->name('general.directories.list_posts.store');
            Route::get('/destroy/{id}', 'App\Http\Controllers\General\ListPostsController@destroy')->name('general.directories.list_posts.destroy');
        });

        Route::group(['prefix' => 'chemicil'], function () {
            Route::get('/', 'General\ChemicilController@index')->name('general.directories.chimicil');
            Route::get('/edit', 'General\ChemicilController@edit')->name('general.directories.chimicil.edit');
            Route::post('/update', 'General\ChemicilController@update')->name('general.directories.chimicil.update');
            Route::post('/store', 'General\ChemicilController@store')->name('general.directories.chimicil.store');
            Route::get('/destroy/{id}', 'General\ChemicilController@destroy')->name('general.directories.chimicil.destroy');
        });
    });

    Route::group(['prefix' => 'data'], function () {
        Route::get('/information', 'General\DataController@index')->name('general.information');
        Route::get('/getInfo', 'General\DataController@getInfo')->name('general.getinfo');
        Route::get('/getview', 'General\DataController@getView')->name('general.getview');
        Route::get('/getview-post', 'General\DataController@getViewPost')->name('general.getviewpost');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'UserController@index');
        Route::group(['prefix' => 'divisions'], function () {
            Route::get('/', 'DivisionsController@index')->name('general.admin.divisions');
            Route::get('/edit/{id}', 'DivisionsController@edit')->name('general.admin.divisions.edit');
            Route::get('/destroy/{id}', 'DivisionsController@destroy')->name('general.admin.divisions.delete');
            Route::get('/add', 'DivisionsController@create')->name('general.admin.divisions.create');
            Route::post('/store', 'DivisionsController@store')->name('general.admin.divisions.store');
            Route::post('/update,{id}', 'DivisionsController@update')->name('general.admin.divisions.update');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index')->name('general.admin.users');
            Route::get('/edit', 'UserController@edit')->name('general.admin.users.edit');
            Route::get('/destroy/{id}', 'UserController@destroy')->name('general.admin.users.delete');
            Route::get('/add', 'UserController@create')->name('general.admin.users.create');
            Route::post('/store', 'UserController@store')->name('general.admin.users.store');
            Route::post('/update', 'UserController@update')->name('general.admin.users.update');
            Route::get('/get/division', 'UserController@SelectPosition')->name('general.admin.users.get_division');
        });

        Route::group(['prefix' => 'language'], function () {
            Route::get('/', 'LanguageController@index')->name('general.langs');
            Route::post('/add', 'LanguageController@store')->name('general.langs.add.post');
            Route::post('/update', 'LanguageController@update')->name('general.langs.update.post');
            Route::get('/add', 'LanguageController@AddShow')->name('general.langs.add');
            Route::get('/update/{id}', 'LanguageController@UpdateShow')->name('general.langs.update');
            Route::get('/delete/{id}', 'LanguageController@delete')->name('general.langs.delete');
        });
        Route::group(['prefix' => 'metka'], function () {
            Route::get('/', 'MetkiController@index')->name('general.metki');
            Route::get('/list', 'MetkiController@indexlist')->name('general.metki.list');
            Route::get('/add', 'MetkiController@add')->name('general.add');
            Route::post('/add', 'MetkiController@addin')->name('general.metki.add.post');
            Route::get('/update/{id}', 'MetkiController@UpdateShow')->name('general.metki.update');
            Route::post('/update', 'MetkiController@Update')->name('general.metki.update.post');
            Route::get('/delete/{id}', 'MetkiController@delete')->name('general.metki.delete');
            Route::post('/allupload', 'MetkiController@Updateall')->name('general.metki.update.all');
            Route::post('/search', 'MetkiController@search')->name('general.metki.search');
            Route::post('/addmetka', 'MetkiController@AddMetka')->name('general.metki.addmetka');
        });
    });
    Route::group(['prefix' => 'map'], function () {
        Route::get('/', 'General\MapController@index')->name('general.map');
        Route::post('/search', 'General\MapController@search')->name('general.map.search');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
