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

Route::group([/*'prefix' => 'general', */'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('general.pages.dashboard');
    })->name('general.dashboard');


    Route::group(['prefix' => 'report'], function () {
        Route::get('/', 'App\Http\Controllers\General\WordExportController@index')->name('general.report.index');
        Route::post('/export', 'App\Http\Controllers\General\WordExportController@GenereteWord')->name('general.word.export');
    });

    Route::group(['prefix' => 'resources'], function () {
        Route::group(['prefix' => 'resource_regions'], function () {

            Route::get('/', 'App\Http\Controllers\General\ResourcesRegionsController@index')->name('general.resource');
            Route::get('/index_with', 'App\Http\Controllers\General\ResourcesRegionsController@Indexwith')->name('general.resource.resource_regions_with');
            Route::post('/update', 'App\Http\Controllers\General\ResourcesRegionsController@update')->name('general.resource.resource_regions.update');
            Route::post('/accept', 'App\Http\Controllers\General\ResourcesRegionsController@Accept')->name('general.resource.resource_regions.accept');
        });

        Route::group(['prefix' => 'uw_reserfs'], function () {
            Route::get('/', 'App\Http\Controllers\General\UwReserfController@index')->name('general.resource.uw_reserf');
            Route::post('/update', 'App\Http\Controllers\General\UwReserfController@update')->name('general.resource.uw_reserf.update');
            Route::post('/accept', 'App\Http\Controllers\General\UwReserfController@Accept')->name('general.resource.uw_reserf.accept');
        });

        Route::group(['prefix' => 'water_uses'], function () {
            Route::get('/', 'App\Http\Controllers\General\WaterUsesController@index')->name('general.resource.water_uses');
            Route::post('/update', 'App\Http\Controllers\General\WaterUsesController@update')->name('general.resource.water_uses.update');
            Route::post('/accept', 'App\Http\Controllers\General\WaterUsesController@Accept')->name('general.resource.water_uses.accept');
        });

        Route::group(['prefix' => 'river_recources'], function () {
            Route::get('/', 'App\Http\Controllers\General\RiverFlowRecourcesController@index')->name('general.resource.river_recources');
            Route::post('/update', 'App\Http\Controllers\General\RiverFlowRecourcesController@update')->name('general.resource.river_recources.update');
            Route::post('/accept', 'App\Http\Controllers\General\RiverFlowRecourcesController@Accept')->name('general.resource.river_recources.accept');
        });

        Route::group(['prefix' => 'ground_water'], function () {
            Route::get('/', 'App\Http\Controllers\General\GroundWaterController@index')->name('general.resource.ground_water');
            Route::post('/update', 'App\Http\Controllers\General\GroundWaterController@update')->name('general.resource.ground_water.update');
            Route::post('/accept', 'App\Http\Controllers\General\GroundWaterController@Accept')->name('general.resource.ground_water.accept');
        });

        Route::group(['prefix' => 'ground_water_use'], function () {
            Route::get('/', 'App\Http\Controllers\General\GroundWaterUseController@index')->name('general.resource.ground_water_use');
            Route::post('/update', 'App\Http\Controllers\General\GroundWaterUseController@update')->name('general.resource.ground_water_use.update');
            Route::post('/accept', 'App\Http\Controllers\General\GroundWaterUseController@Accept')->name('general.resource.ground_water_use.accept');
        });

        Route::group(['prefix' => 'water_use_various_needs'], function () {
            Route::get('/', 'App\Http\Controllers\General\WaterUseVariousController@index')->name('general.resource.water_use_various_needs');
            Route::post('/update', 'App\Http\Controllers\General\WaterUseVariousController@update')->name('general.resource.water_use_various_needs.update');
            Route::post('/accept', 'App\Http\Controllers\General\WaterUseVariousController@Accept')->name('general.resource.water_use_various_needs.accept');
        });

        Route::group(['prefix' => 'information_large_canals_irigation_system'], function () {
            Route::get('/', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@index')->name('general.resource.information_large_canals_irigation_system');
            Route::post('/update', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@update')->name('general.resource.information_large_canals_irigation_system.update');
            Route::post('/accept', 'App\Http\Controllers\General\InformationLargeCanalsIrigationSystem@Accept')->name('general.resource.information_large_canals_irigation_system.accept');
        });

        Route::group(['prefix' => 'change_water_reserves'], function () {
            Route::get('/', 'App\Http\Controllers\General\ChangeWaterReservesController@index')->name('general.resource.change_water_reserves');
            Route::post('/update', 'App\Http\Controllers\General\ChangeWaterReservesController@update')->name('general.resource.change_water_reserves.update');
            Route::post('/accept', 'App\Http\Controllers\General\ChangeWaterReservesController@Accept')->name('general.resource.change_water_reserves.accept');
        });

        Route::group(['prefix' => 'characteristics_water'], function () {
            Route::get('/', 'App\Http\Controllers\General\CharacteristicsWatersController@index')->name('general.resource.characteristics_water');
            Route::post('/update', 'App\Http\Controllers\General\CharacteristicsWatersController@update')->name('general.resource.characteristics_water.update');
            Route::post('/store', 'App\Http\Controllers\General\CharacteristicsWatersController@store')->name('general.resource.characteristics_water.store');
            Route::post('/accept', 'App\Http\Controllers\General\CharacteristicsWatersController@Accept')->name('general.resource.characteristics_water.accept');
        });
    });


    Route::prefix('/exchange')->group(function () {
        Route::get('/', 'App\Http\Controllers\General\DataExchangeController@index')->name('general.exchange-index');
        Route::post('/', 'App\Http\Controllers\General\DataExchangeController@index')->name('general.exchange-index-post');
        Route::get('/sird-form', 'App\Http\Controllers\General\DataExchangeController@SirdForm')->name('general.get-oper-form');
        Route::post('/delete-object-from-sird', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromSird')->name('general.post-delete-object-from-sird');
        Route::post('/change-sird', 'App\Http\Controllers\General\DataExchangeController@AjaxChangeSird')->name('general.ajax-change-sird');
        Route::post('/select-element', 'App\Http\Controllers\General\DataExchangeController@AjaxSelectElement')->name('general.ajax-select-element');
        Route::get('/amu-form', 'App\Http\Controllers\General\DataExchangeController@AmuForm')->name('general.get-amu-form');
        Route::get('/reservoir-form', 'App\Http\Controllers\General\DataExchangeController@ReservoirForm')->name('general.get-reservoir-form');
        Route::post('/delete-object-from-res', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromRes')->name('general.post-delete-object-from-res');
        Route::post('/delete-object-from-amu', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromAmu')->name('general.post-delete-object-from-amu');
        Route::post('/add-object-res', 'App\Http\Controllers\General\DataExchangeController@AddObjectRes')->name('general.post-add-object-res');
        Route::get('/daily-form', 'App\Http\Controllers\General\DataExchangeController@DailyForm')->name('general.get-daily-form');
        Route::post('/delete-object-from-daily', 'App\Http\Controllers\General\DataExchangeController@deleteObjFromDaily')->name('general.post-delete-object-from-daily');
        Route::get('/add-value', 'App\Http\Controllers\General\DataExchangeController@AddValueAjax')->name('general.add-value-ajax');
        Route::post('/add-infoadd-object-info-ajax', 'App\Http\Controllers\General\DataExchangeController@AddInfoAjax')->name('general.add-object-info-ajax');
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
            Route::get('/', 'App\Http\Controllers\General\ChemicilController@index')->name('general.directories.chimicil');
            Route::get('/edit', 'App\Http\Controllers\General\ChemicilController@edit')->name('general.directories.chimicil.edit');
            Route::post('/update', 'App\Http\Controllers\General\ChemicilController@update')->name('general.directories.chimicil.update');
            Route::post('/store', 'App\Http\Controllers\General\ChemicilController@store')->name('general.directories.chimicil.store');
            Route::get('/destroy/{id}', 'App\Http\Controllers\General\ChemicilController@destroy')->name('general.directories.chimicil.destroy');
        });
    });

    Route::group(['prefix' => 'data'], function () {
        Route::get('/information', 'App\Http\Controllers\General\DataController@index')->name('general.information');
        Route::get('/getInfo', 'App\Http\Controllers\General\DataController@getInfo')->name('general.getinfo');
        Route::get('/getview', 'App\Http\Controllers\General\DataController@getView')->name('general.getview');
        Route::get('/getview-post', 'App\Http\Controllers\General\DataController@getViewPost')->name('general.getviewpost');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'App\Http\Controllers\General\UserController@index')->name('general.admin');
        /*Route::group(['prefix' => 'divisions'], function () {
            Route::get('/', 'DivisionsController@index')->name('general.admin.divisions');
            Route::get('/edit/{id}', 'DivisionsController@edit')->name('general.admin.divisions.edit');
            Route::get('/destroy/{id}', 'DivisionsController@destroy')->name('general.admin.divisions.delete');
            Route::get('/add', 'DivisionsController@create')->name('general.admin.divisions.create');
            Route::post('/store', 'DivisionsController@store')->name('general.admin.divisions.store');
            Route::post('/update,{id}', 'DivisionsController@update')->name('general.admin.divisions.update');
        });*/
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'App\Http\Controllers\General\UserController@index')->name('general.admin.users');
            Route::get('/edit', 'App\Http\Controllers\General\UserController@edit')->name('general.admin.users.edit');
            Route::get('/destroy/{id}', 'App\Http\Controllers\General\UserController@destroy')->name('general.admin.users.delete');
            Route::post('/store', 'App\Http\Controllers\General\UserController@store')->name('general.admin.users.store');
            Route::post('/update', 'App\Http\Controllers\General\UserController@update')->name('general.admin.users.update');
            Route::get('/get/division', 'App\Http\Controllers\General\UserController@SelectPosition')->name('general.admin.users.get_division');
        });

        Route::group(['prefix' => 'language'], function () {
            Route::get('/', 'LanguageController@index')->name('general.langs');
            Route::post('/add', 'LanguageController@store')->name('general.langs.add.post');
            Route::post('/update', 'LanguageController@update')->name('general.langs.update.post');
            Route::get('/add', 'LanguageController@AddShow')->name('general.langs.add');
            Route::get('/update/{id}', 'LanguageController@UpdateShow')->name('general.langs.update');
            Route::get('/delete/{id}', 'LanguageController@delete')->name('general.langs.delete');
        });

        Route::prefix('/object/information')->group(function () {
            //Route::get('/', 'ObjectInformationController@cleanDouble')->name('clean-double');
            //Route::get('/', 'ObjectInformationController@index')->name('object-information');
            //Route::post('/', 'ObjectInformationController@index')->name('object-information-post');
            //Route::post('/add-info', 'ObjectInformationController@AddInfoAjax')->name('add-object-info-ajax');
            //Route::post('/add-area', 'ObjectInformationController@AddAreaAjax')->name('add-area-ajax');
            //Route::post('/add-in-value', 'ObjectInformationController@AddInValueAjax')->name('add-in-value-ajax');
            //Route::post('/add-out-value', 'ObjectInformationController@AddOutValueAjax')->name('add-out-value-ajax');
            Route::post('/import', 'ObjectInformationController@excelImport')->name('object-excel-import');
            Route::get('/export-information', 'ObjectInformationController@excelExport')->name('gvk-export-information');
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
        Route::get('/', 'App\Http\Controllers\General\MapController@index')->name('general.map');
        Route::post('/search', 'App\Http\Controllers\General\MapController@search')->name('general.map.search');
    
        Route::get('/getdistricts', 'App\Http\Controllers\General\WaterbodiesController@getdistricts')->name('wb.getdistricts');
    });

    Route::group(['prefix' => 'approval_plots'], function () {
        Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\ApprovalPlotController@edit')->name('gg.reestr.ap.edit');
        //Route::get('/', 'Gidrogeologiya\ApprovalPlotController@index')->name('gg.reestr.ap.index');
        /*Route::get('/add', 'Gidrogeologiya\ApprovalPlotController@create')->name('gg.reestr.ap.create');
        Route::post('/store', 'Gidrogeologiya\ApprovalPlotController@store')->name('gg.reestr.ap.store');
        Route::post('/update', 'Gidrogeologiya\ApprovalPlotController@update')->name('gg.reestr.ap.update');
        Route::get('/destroy/{id}', 'Gidrogeologiya\ApprovalPlotController@destroy')->name('gg.reestr.ap.destroy');
        Route::get('/getselectedregion', 'Gidrogeologiya\ApprovalPlotController@getSelectedRegions')->name('gg.reestr.ap.getselectedregion');
        Route::get('/export', 'Gidrogeologiya\ApprovalPlotController@Export')->name('gg.reestr.ap.export');
        Route::get('/export/template', 'Gidrogeologiya\ApprovalPlotController@ExportTemplate')->name('gg.reestr.ap.export.template');
        Route::post('/import', 'Gidrogeologiya\ApprovalPlotController@Import')->name('gg.reestr.ap.import');
        Route::get('/search', 'Gidrogeologiya\ApprovalPlotController@Search')->name('gg.reestr.ap.search');
        Route::post('/accept', 'Gidrogeologiya\ApprovalPlotController@Accept')->name('gg.reestr.ap.accept');
        Route::get('/acceptall', 'Gidrogeologiya\ApprovalPlotController@AcceptAll')->name('gg.reestr.ap.accept.all');*/
    });

    Route::group(['prefix' => 'birth_regions'], function () {
        Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\PlaceBirthController@edit')->name('gg.reestr.bp.edit');
        /*Route::get('/', 'Gidrogeologiya\PlaceBirthController@index')->name('gg.reestr.bp.index');
        Route::get('/add', 'Gidrogeologiya\PlaceBirthController@create')->name('gg.reestr.bp.create');
        Route::post('/store', 'Gidrogeologiya\PlaceBirthController@store')->name('gg.reestr.bp.store');
        Route::post('/update', 'Gidrogeologiya\PlaceBirthController@update')->name('gg.reestr.bp.update');
        Route::get('/destroy/{id}', 'Gidrogeologiya\PlaceBirthController@destroy')->name('gg.reestr.bp.destroy');
        Route::get('/getselectedregion', 'Gidrogeologiya\PlaceBirthController@getSelectedRegions')->name('gg.reestr.bp.getselectedregion');
        Route::get('/export', 'Gidrogeologiya\PlaceBirthController@Export')->name('gg.reestr.bp.export');
        Route::get('/export/template', 'Gidrogeologiya\PlaceBirthController@ExportTemplate')->name('gg.reestr.bp.export.template');
        Route::post('/import', 'Gidrogeologiya\PlaceBirthController@Import')->name('gg.reestr.bp.import');
        Route::get('/search', 'Gidrogeologiya\PlaceBirthController@Search')->name('gg.reestr.bp.search');
        Route::post('/accept', 'Gidrogeologiya\PlaceBirthController@Accept')->name('gg.reestr.bp.accept');
        Route::get('/acceptall', 'Gidrogeologiya\PlaceBirthController@AcceptAll')->name('gg.reestr.bp.accept.all');*/
    });

    Route::group(['prefix' => 'mountain_ranges'], function () {
        Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\MountainRangesController@edit')->name('gg.reestr.mr.edit');
        /*Route::get('/', 'Gidrogeologiya\MountainRangesController@index')->name('gg.reestr.mr.index');
        Route::get('/add', 'Gidrogeologiya\MountainRangesController@create')->name('gg.reestr.mr.create');
        Route::post('/store', 'Gidrogeologiya\MountainRangesController@store')->name('gg.reestr.mr.store');
        Route::post('/update', 'Gidrogeologiya\MountainRangesController@update')->name('gg.reestr.mr.update');
        Route::get('/destroy/{id}', 'Gidrogeologiya\MountainRangesController@destroy')->name('gg.reestr.mr.destroy');
        Route::get('/getselectedregion', 'Gidrogeologiya\MountainRangesController@getSelectedRegions')->name('gg.reestr.mr.getselectedregion');*/
    });

    Route::group(['prefix' => 'wells'], function () {
        Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\WellsController@edit')->name('gg.reestr.wells.edit');
        /*Route::get('/', 'Gidrogeologiya\WellsController@index')->name('gg.reestr.wells.index');
        Route::get('/add', 'Gidrogeologiya\WellsController@create')->name('gg.reestr.wells.create');
        Route::post('/store', 'Gidrogeologiya\WellsController@store')->name('gg.reestr.wells.store');
        Route::post('/update', 'Gidrogeologiya\WellsController@update')->name('gg.reestr.wells.update');
        Route::get('/destroy/{id}', 'Gidrogeologiya\WellsController@destroy')->name('gg.reestr.wells.destroy');
        Route::get('/getselectedregion', 'Gidrogeologiya\WellsController@getSelectedRegions')->name('gg.reestr.wells.getselectedregion');
        Route::get('/export', 'Gidrogeologiya\WellsController@Export')->name('gg.wells.export');
        Route::get('/export/template', 'Gidrogeologiya\WellsController@ExportTemplate')->name('gg.wells.export.template');
        Route::post('/import', 'Gidrogeologiya\WellsController@Import')->name('gg.wells.import');
        Route::get('/search', 'Gidrogeologiya\WellsController@Search')->name('gg.reestr.wells.search');
        Route::post('/accept', 'Gidrogeologiya\WellsController@Accept')->name('gg.reestr.wells.accept');
        Route::get('/acceptall', 'Gidrogeologiya\WellsController@AcceptAll')->name('gg.reestr.wells.accept.all');*/
    });

    Route::group(['prefix' => 'canals'], function () {
        Route::get('/edit', 'App\Http\Controllers\CanalsController@edit')->name('c.edit');
        /*Route::match(['GET', 'POST'], '/', 'CanalsController@index')->name('c.index');
        Route::get('/add', 'CanalsController@create')->name('c.create');
        Route::get('/destroy/{id}', 'CanalsController@destroy')->name('c.delete');
        Route::get('/getselectedregion', 'CanalsController@getSelectedRegions')->name('c.getselectedregion');
        Route::post('/store', 'CanalsController@store')->name('c.store');
        Route::post('/update', 'CanalsController@update')->name('c.update');
        Route::get('/export/template', 'CanalsController@ExportTemplate')->name('c.export.template');
        Route::get('/export', 'CanalsController@Export')->name('c.export');
        Route::post('/import', 'CanalsController@Import')->name('c.import');
        Route::get('/search', 'CanalsController@Search')->name('c.search');
        Route::post('/multiselect', 'CanalsController@MultiSelect')->name('c.delete_all');
        Route::post('/accept', 'CanalsController@Accept')->name('c.accept');*/
    });

    Route::group(['prefix' => 'water_collaction'], function () {
        Route::get('/edit', 'App\Http\Controllers\Gidrogeologiya\WaterCollactionController@edit')->name('gg.reestr.wc.edit');
        /*Route::get('/', 'Gidrogeologiya\WaterCollactionController@index')->name('gg.reestr.wc.index');
        Route::get('/add', 'Gidrogeologiya\WaterCollactionController@create')->name('gg.reestr.wc.create');
        Route::post('/store', 'Gidrogeologiya\WaterCollactionController@store')->name('gg.reestr.wc.store');
        Route::post('/update', 'Gidrogeologiya\WaterCollactionController@update')->name('gg.reestr.wc.update');
        Route::get('/destroy/{id}', 'Gidrogeologiya\WaterCollactionController@destroy')->name('gg.reestr.wc.destroy');
        Route::get('/getselectedregion', 'Gidrogeologiya\WaterCollactionController@getSelectedRegions')->name('gg.reestr.wc.getselectedregion');
        Route::get('/export', 'Gidrogeologiya\WaterCollactionController@Export')->name('gg.reestr.wc.export');
        Route::get('/export/template', 'Gidrogeologiya\WaterCollactionController@ExportTemplate')->name('gg.reestr.wc.export.template');
        Route::post('/import', 'Gidrogeologiya\WaterCollactionController@Import')->name('gg.reestr.wc.import');
        Route::get('/search', 'Gidrogeologiya\WaterCollactionController@Search')->name('gg.reestr.wc.search');
        Route::post('/accept', 'Gidrogeologiya\WaterCollactionController@Accept')->name('gg.reestr.wc.accept');
        Route::get('/acceptall', 'Gidrogeologiya\WaterCollactionController@AcceptAll')->name('gg.reestr.wc.accept.all');*/
    });

    Route::group(['prefix' => 'pump_station'], function () {
        Route::get('/edit', 'App\Http\Controllers\PumpStationController@edit')->name('ps.edit');
        /*Route::match(['GET', 'POST'], '/', 'PumpStationController@index')->name('ps.index');
        Route::get('/add', 'PumpStationController@create')->name('ps.create');
        Route::get('/destroy/{id}', 'PumpStationController@destroy')->name('ps.delete');
        Route::post('/store', 'PumpStationController@store')->name('ps.store');
        Route::post('/update', 'PumpStationController@update')->name('ps.update');
        Route::get('/getselectedregion', 'PumpStationController@getSelectedRegions')->name('ps.getselectedregion');
        Route::get('/export/template', 'PumpStationController@ExportTemplate')->name('ps.export.template');
        Route::get('/export', 'PumpStationController@Export')->name('ps.export');
        Route::post('/import', 'PumpStationController@Import')->name('ps.import');
        Route::get('/search', 'PumpStationController@Search')->name('ps.search');
        Route::post('/multiselect', 'PumpStationController@MultiSelect')->name('ps.delete_all');
        Route::post('/accept', 'PumpStationController@Accept')->name('ps.accept');*/
    });

    Route::group(['prefix' => 'reservoirs'], function () {
        Route::get('/edit', 'App\Http\Controllers\ReservoirsController@edit')->name('rv.edit');
        /*Route::match(array('GET', 'POST'), '/', 'ReservoirsController@index')->name('rv.index');
        Route::get('/year', 'ReservoirsController@index_year')->name('rv.year');
        Route::get('/add', 'ReservoirsController@create')->name('rv.create');
        Route::get('/delete/{id}', 'ReservoirsController@destroy')->name('rv.delete');
        Route::post('/store', 'ReservoirsController@store')->name('rv.store');
        Route::post('/update', 'ReservoirsController@update')->name('rv.update');
        Route::get('/getselectedregion', 'ReservoirsController@getSelectedRegions')->name('rv.getselectedregion');
        Route::get('/search', 'ReservoirsController@Search')->name('rv.search');
        Route::get('/export', 'ReservoirsController@Export')->name('rv.export');
        Route::post('/multiselect', 'ReservoirsController@MultiSelect')->name('rv.delete_all');
        Route::post('/accept', 'ReservoirsController@Accept')->name('rv.accept');*/
    });

    Route::group(['prefix' => 'waterworks'], function () {
        Route::get('/edit', 'App\Http\Controllers\WaterWorksController@edit')->name('ww.edit');
        /*Route::match(['GET', 'POST'], '/', 'WaterWorksController@index')->name('ww.index');
        Route::get('/add', 'WaterWorksController@create')->name('ww.create');
        Route::get('/destroy/{id}', 'WaterWorksController@destroy')->name('ww.delete');
        Route::get('/getselectedregion', 'WaterWorksController@getSelectedRegions')->name('ww.getselectedregion');
        Route::post('/store', 'WaterWorksController@store')->name('ww.store');
        Route::post('/update', 'WaterWorksController@update')->name('ww.update');
        Route::get('/export/template', 'WaterWorksController@ExportTemplateWaterworks')->name('ww.export.template');
        Route::get('/export', 'WaterWorksController@Export')->name('ww.export');
        Route::get('/search', 'WaterWorksController@Search')->name('ww.search');
        Route::post('/import/', 'WaterWorksController@Import')->name('ww.import');
        Route::get('/search', 'WaterWorksController@Search')->name('ww.search');
        Route::post('/multiselect', 'WaterWorksController@MultiSelect')->name('ww.delete_all');
        Route::post('/accept', 'WaterWorksController@Accept')->name('ww.accept');*/
    });

    Route::group(['prefix' => 'collectors'], function () {
        Route::get('/edit', 'App\Http\Controllers\CollectorsController@edit')->name('ct.edit');
        /*Route::match(['GET', 'POST'], '/', 'CollectorsController@index')->name('ct.index');
        Route::get('/add', 'CollectorsController@create')->name('ct.create');
        Route::get('/delete/{id}', 'CollectorsController@destroy')->name('ct.delete');
        Route::post('/store', 'CollectorsController@store')->name('ct.store');
        Route::post('/update', 'CollectorsController@update')->name('ct.update');
        Route::get('/getselectedregion', 'CollectorsController@getSelectedRegions')->name('ct.getselectedregion');
        Route::get('/export/template', 'CollectorsController@ExportTemplate')->name('ct.export.template');
        Route::get('/export', 'CollectorsController@Export')->name('ct.export');
        Route::post('/import', 'CollectorsController@Import')->name('ct.import');
        Route::get('/search', 'CollectorsController@Search')->name('ct.search');
        Route::post('/multiselect', 'CollectorsController@MultiSelect')->name('ct.delete_all');
        Route::post('/accept', 'CollectorsController@Accept')->name('ct.accept');*/
    });


});

Auth::routes();
