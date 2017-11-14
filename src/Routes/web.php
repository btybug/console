<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'ModulesController@getIndexUploads');
Route::get('/modules', "ModulesController@getIndex");

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', 'SettingsController@settings');
    Route::post('/', 'SettingsController@postSaveSettings');
    Route::post('/version', 'SettingsController@postVersion');
});


Route::get('/optimisation', function () {
    Artisan::call('plugin:optimaze');

    return redirect()->back()->with(['flash' => ['message' => 'modules optimisation successfully!!!']]);
});

Route::group(['prefix' => 'general'], function () {
    Route::get('/', 'GeneralController@getValidations');
    Route::get('/trigger-events', 'GeneralController@getTriggerEvents');
});

Route::group(['prefix' => 'structure'], function () {
    Route::get('/', 'StructureController@getIndex');
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', 'StructureController@getPages');
        Route::get('/settings/{id}', 'StructureController@getPageSettings');
        Route::post('/settings/{id}', 'StructureController@postPageSettings');
        Route::post('/', 'StructureController@postEdit');
        Route::post('/get-data', 'StructureController@postPageData');
    });


    Route::get('/urls', 'StructureController@getUrls');
    Route::get('/classify', 'StructureController@getClassify');
//    Route::get('/settings', 'StructureController@getSettings');
    Route::get('/tables', 'StructureController@getTables');

    Route::group(['prefix' => 'fields'], function () {
        Route::get('/', 'StructureController@getFields');
        Route::get('/create', 'StructureController@getCreateField');
        Route::get('/create-new', 'StructureController@getCreateFieldNew');
        Route::get('/edit/{id}', 'StructureController@getEditField');
        Route::post('/edit/{id}', 'StructureController@postEditField');
        Route::post('/new', 'StructureController@postCreateField');
        Route::post('/change-status', 'StructureController@postChangeFieldStatus');
    });

    Route::get('/edit-forms', 'StructureController@getEditForms');
    Route::get('/get-default-html', 'StructureController@getDefaultHtml');
    Route::post('/get-custom-html', 'StructureController@getCustomHtml');
    Route::post('/get-saved-html-type', 'StructureController@getSavedHtmlType');


    Route::group(['prefix' => 'forms'], function () {
        Route::get('/', 'StructureController@getForms');
        Route::get('/edit/{id}', 'StructureController@getFormEdit');
        Route::get('/entries/{id}', 'StructureController@getFormEntries');
        Route::get('/view-entries/{id}', 'StructureController@getViewEntries');
        Route::post('/get-entries-data', 'StructureController@postGetEntryData');
        Route::get('/settings/{id}', 'StructureController@getFormSettings');
        Route::post('/settings/{id}', 'StructureController@postFormSettings');
        Route::post('/get-available-fields-settings', 'StructureController@postAvailableFields');
        Route::post('/edit/{id}', 'StructureController@postFormEdit');
        Route::get('/create', 'StructureController@getCreateForm');
        Route::get('/edit-custom/{id}', 'StructureController@getEditForm');
        Route::post('/save', 'StructureController@postSaveForm');
        Route::get('/create-advanced', 'StructureController@getCreateAdvanced');
        Route::post('/get-unit-settings', 'StructureController@getUnitSettingsPage');
        Route::get('/get-add-field-modal', 'StructureController@getUnitFieldModal');
        Route::get('/add-field-modal', 'StructureController@getAddFieldModal');
        Route::get('/get-unit-render', 'StructureController@getUnitRender');
        Route::post('/get-edit-field-modal', 'StructureController@getUnitEditFieldModal');
        Route::post('/get-available-fields', 'StructureController@getAvailableFieldsModal');
        Route::post('/get-unit-variations', 'StructureController@getUnitVariations');
        Route::post('/get-unit-variation-data', 'StructureController@getUnitVariationField');
        Route::post('/get-unit-variations-settings', 'StructureController@getUnitVariationSettings');
        Route::post('/get-component-settings', 'StructureController@getComponentSettings');
        Route::post('/get-builder-render', 'StructureController@postBuilder');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'GeneralController@getIndex');
        Route::post('/', 'GeneralController@postSettings');
    });


    Route::group(['prefix' => 'menus'], function () {
        Route::get('/', 'MenusController@getIndex');
        Route::get('/edit/{menu}/{role}', 'MenusController@getEdit');
        Route::post('/edit/{menu}/{role}', 'MenusController@postEdit');
        Route::post('/create', 'MenusController@postCreate');
        Route::post('/delete', 'MenusController@postDelete');
    });
});


Route::group(['prefix' => 'config'], function () {
    Route::get('/page-preview/{page_id}', 'StructureController@getPagePreview');
    Route::post('/page-preview/{page_id}', 'StructureController@postSavePageSettings');
});
Route::group(['prefix' => 'backend'], function () {
    Route::get('/', 'BackendController@getIndex');
    Route::get('/settings', 'BackendController@settings');
    Route::post('/settings', 'BackendController@postSaveSettings');
    Route::get('/css-js', 'BackendController@getCssJs');
    Route::post('/css-js', 'BackendController@postCssJs');

    //field units
    Route::group(['prefix' => 'general-fields'], function () {
        Route::get('/', 'FieldUnitsController@getIndex');
        Route::post('/upload', 'FieldUnitsController@postUploadUnit');
        Route::post('/delete', 'FieldUnitsController@postDelete');

        Route::get('/settings/{slug?}', 'FieldUnitsController@getSettings');
        Route::get('/settings-iframe/{slug}/{settings?}', 'FieldUnitsController@unitPreviewIframe');
        Route::post('/settings/{id}/{save?}', 'FieldUnitsController@postSettings');
        Route::post('/delete-variation', 'FieldUnitsController@postDeleteVariation');
    });
    Route::get('/special-fields', 'FieldUnitsController@getSpecialFields');

//    Route::get('/layouts', 'BackendController@getLayouts');
//    Route::get('/units', 'BackendController@getUnits');
//    Route::get('/views', 'BackendController@getViews');
});


Route::group(['prefix' => 'modules'], function () {
    Route::get('/', 'ModulesController@getIndex');
    Route::post('/urls-pages-optimization', 'ModulesSettingsController@postoptimize');
    Route::group(['prefix' => '{param}'], function () {
        Route::get('/', 'ModulesSettingsController@getMain');
        Route::get('/general', 'ModulesSettingsController@getIndex');
        Route::get('/gears', 'ModulesSettingsController@getGears');
        Route::get('/assets', 'ModulesSettingsController@getAssets');
        Route::get('/permission', 'ModulesSettingsController@getPermission');
        Route::post('/permission', 'ModulesSettingsController@postPermission');
        Route::get('/code', 'ModulesSettingsController@getCode');
        Route::get('/tables', 'ModulesSettingsController@getTables');
        Route::get('/views', 'ModulesSettingsController@getViews');

        Route::group(['prefix' => 'build'], function () {
            Route::get('/', 'ModulesSettingsController@getBuild');
            Route::get('/pages', 'ModulesSettingsController@getPages');
            Route::post('/pages', 'ModulesSettingsController@postPages');
            Route::post('/pages-data', 'ModulesSettingsController@postPageData');
            Route::post('/create-menu', 'ModulesSettingsController@postCreateMenus');
            Route::get('/urls', 'ModulesSettingsController@getUrls');
            Route::get('/classify', 'ModulesSettingsController@getClassify');

            Route::group(['prefix' => 'menus'], function () {
                Route::get('/', 'ModulesSettingsController@getMenus');
                Route::post('/create-menu', 'ModulesSettingsController@postCreateMenu');
                Route::get('/edit/{menu}/{role}', 'ModulesSettingsController@getMenuEdit');
            });
        });

    });

});