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
    // page section
    Route::group(['prefix' => 'page-section'], function () {
        Route::get('/', 'PageSectionsController@getIndex');
        Route::get('/settings/{slug}', 'PageSectionsController@getSettings');
        Route::post('/settings/{slug}/{save?}', 'PageSectionsController@postSettings');
        Route::post('/make-active', 'PageSectionsController@postMakeActive');
        Route::post('/upload', 'PageSectionsController@postUpload');
        Route::post('/delete-variation', 'PageSectionsController@postDeleteVariation');
        Route::post('/delete', 'PageSectionsController@postDelete');
    });

    //admin/console/backend/templates
    Route::group(['prefix' => 'h-f'], function () {
        Route::get('/', 'HfController@getIndex');
        Route::get('/front-themes', 'HfController@gatFrontThemes');
        Route::get('/front-themes-activate/{slug}', 'HfController@activateFrontTheme');
        Route::get('/tpl-variations/{slug}', 'HfController@getTplVariations');
        Route::post('/tpl-variations/{slug}', 'HfController@postTplVariations');
        Route::post('/get-variations', 'HfController@postGetVariations');
        Route::post('/edit-variation', 'HfController@postEditVariation');
        Route::get('/delete-variation/{slug}', 'HfController@getDeleteVariation');
        Route::get('/settings-live/{slug}', 'HfController@TemplatePerview');
        Route::get('/settings-iframe/{slug}/{page_id}/{edit?}', 'HfController@TemplatePerviewIframe');
        Route::get('/settings-edit-theme/{slug}/{settings?}', 'HfController@TemplatePerviewEditIframe');
        Route::post('/settings/{id}/{save?}', 'HfController@postSettings');


        Route::post('/new-type', 'HfController@postNewType');
        Route::post('/delete-type', 'HfController@postDeleteType');
        Route::post('/delete', 'HfController@postDelete');
        Route::post('/upload-template', 'HfController@postUploadTemplate');
        Route::post('/templates-with-type', 'HfController@postTemplatesWithType');
        Route::post('/templates-in-modal', 'HfController@postTemplatesInModal');
    });
    Route::get('/layouts', 'LayoutController@getBackendIndex');
    Route::get('/main-body', 'MainBodyController@getBackendIndex');


    //units
    Route::group(['prefix' => 'units'], function () {
        Route::get('/', 'UnitsController@getIndex');
        Route::post('/upload', 'UnitsController@postUploadUnit');
        Route::post('/delete', 'UnitsController@postDelete');
        Route::get('/settings/{slug?}', 'UnitsController@getSettings');
        Route::get('/settings-iframe/{slug}/{settings?}', 'UnitsController@unitPreviewIframe');
        Route::post('/settings/{id}/{save?}', 'UnitsController@postSettings');
        Route::post('/delete-variation', 'UnitsController@postDeleteVariation');
    });

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

    //sections
    Route::group(['prefix' => 'sections'], function () {
        Route::get('/', 'SectionsController@getIndex');
        Route::post('/upload', 'SectionsController@postUpload');
        Route::get('/settings/{slug?}', 'SectionsController@getSettings');
        Route::get('/settings-iframe/{slug}/{settings?}', 'SectionsController@unitPreviewIframe');
        Route::post('/settings/{id}/{save?}', 'SectionsController@postSettings');
        Route::post('/delete-variation', 'SectionsController@postDeleteVariation');
        Route::post('/delete', 'SectionsController@postDelete');
    });

    Route::group(['prefix' => 'templates'], function () {
        Route::get('/', 'TemplatesController@getIndex');
        Route::post('/upload', 'TemplatesController@postUpload');
        Route::get('/settings/{slug?}', 'TemplatesController@getSettings');

        Route::get('/settings-iframe/{slug}/{settings?}', 'TemplatesController@previewIframe');
        Route::post('/settings/{id}/{save?}', 'TemplatesController@postSettings');
        Route::post('/delete-variation', 'TemplatesController@postDeleteVariation');
        Route::post('/delete', 'TemplatesController@postDelete');
    });
    Route::group(['prefix' => 'theme'], function () {
        Route::get('/', 'ThemeController@getIndex');
        Route::post('/make-active', 'ThemeController@postMakeActive');
        Route::get('/settings/{slug}', 'ThemeController@getSettings');
        Route::post('/settings/{slug}/{save?}', 'ThemeController@postThemeSettings');
        Route::post('/edit/live-save', 'ThemeController@postLiveSave');
        Route::post('/theme-edit/checkboxes', 'ThemeController@postEditCheckboxes');
        Route::post('/upload', 'ThemeController@postUploadTheme');
        Route::post('/delete', 'ThemeController@postDeleteTheme');
    });

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