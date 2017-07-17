<?php
/**
 * Copyright (c) 2017.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace App\Modules\Console\Http\Controllers;

use App\Core\CmsItemReader;
use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\AdminPages;
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\ExtraModules\Structures;
use App\Models\Fields;
use App\Models\FormEntries;
use App\Models\Forms;
use App\Models\Templates\Units;
use App\Modules\Console\Models\FieldValidations;
use App\Modules\Console\Models\Menu;
use App\Modules\Console\Models\MenuItem;
use App\Modules\Users\Models\Roles;
use App\Repositories\AdminsettingRepository as Settings;
use DB;
use File;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class StructureController extends Controller
{
    /**
     * @var helpers
     */
    public $helper;
    /**
     * @var mixed
     */
    public $up;
    /**
     * @var mixed
     */
    public $mp;
    /**
     * @var
     */
    public $upplugin;
    public $fieldValidation;
    public $settings;
    public $unitTypes, $specialTypes;
    /**
     * @var Module
     */
    protected $modules;

    /**
     * ModulesController constructor.
     * @param Module $module
     * @param Upload $upload
     * @param validateUpl $v
     */
    public function __construct(FieldValidations $fieldValidations, Settings $settings)
    {
        $this->helper = new helpers();
        $this->settings = $settings;
        $this->up = config('paths.modules_upl');
        $this->mp = config('paths.extra_modules');
        $this->unitTypes = @json_decode(File::get(config('paths.unit_path') . 'configFieldUnitTypes.json'), 1)['types'];
        $this->specialTypes = @json_decode(File::get(config('paths.unit_path') . 'configSpecialUnitTypes.json'), 1)['types'];
        $this->fieldValidation = $fieldValidations;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('console::structure.index');
    }

    public function getTables()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        return view('console::structure.tables', compact(['tables']));
    }

    public function getPages(Request $request)
    {
//        \Artisan::call('pages:optimise');
        $pageID = $request->get('page');
        $pageGrouped = AdminPages::where('parent_id', 0)->groupBy('module_id')->get();
        if ($pageID) {
            $page = AdminPages::find($pageID);
        } else {
            $page = AdminPages::first();
        }

        if ($page && !$page->layout_id) $page->layout_id = 0;

        return view('console::structure.pages', compact(['pageGrouped', 'page']));
    }

    public function postEdit(Request $request)
    {
        $data = $request->except('_token', 'type', 'tags', 'classify');
        $validator = \Validator::make($data, [
            'id' => 'exists:admin_pages,id',
            'title' => 'required',
            'url' => 'sometimes|unique:admin_pages,url,' . $data['id']
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        if (isset($data['url'])) {
            (starts_with($data['url'], '/')) ? false : $data['url'] = "/" . $data['url'];
        }

        $page = AdminPages::find($data['id']);
        if (!$page) return redirect()->back()->with('message', 'Page Not Found!!!');

        $page->update($data);
        return redirect()->back()->with('message', 'Successfully Updated Page');
    }

    public function getMenus(Request $request)
    {
        $id = $request->get('p');
        $menus = Menu::where('type', '!=', 'plugin')->get();
        $roles = Roles::all();
        $menu = null;

        if (count($menus) && $id) {
            $menu = Menu::find($id);
        } elseif (count($menus)) {
            $menu = Menu::where('type', '!=', 'plugin')->first();
        }
//        $pages = AdminPages::where('module_id','console')->where('parent_id',0)->get();
//        Menu::registerFromAdminPages($pages);

        return view('console::structure.menus', compact('menus', 'roles', 'menu', 'slug'));
    }

    public function postMenuCreate(Request $request)
    {
        $data = $request->all();
        $v = \Validator::make($data, ['name' => "required"]);

        if ($v->fails()) return back()->withInput()->withErrors($v->messages());

        $menu = Menu::create([
            'name' => $data['name'],
            'creator_id' => \Auth::id(),
            'type' => 'custom',
        ]);

        if ($menu) return back()->with('message', "menu successfully created");

        return back()->with('message', "menu not created");
    }

    public function postDelete(Request $request)
    {
        $id = $request->slug;
        $success = false;
        if ($menu = Menu::find($id)) $success = $menu->delete();

        return \Response::json(['success' => $success, 'url' => url('admin/console/structure/menus')]);
    }

    public function getMenuEdit($id, $slug, Request $request)
    {

        $menu = Menu::find($id);
        $page = AdminPages::first();
        $pageGrouped = AdminPages::groupBy('module_id')->get();
        $role = Roles::where('slug', $slug)->first();

        if ($menu) {
            $items = $menu->items()->where('role_id', $role->id)->where('parent_id', 0)->get();
            $data = json_encode(Menu::makeJson($items), true);

            return view('console::structure.menu_edit', compact(['pageGrouped', 'page', 'slug', 'data', 'menu']));
        } else {
            abort('404');
        }
    }

    public function postMenuEdit($id, $slug, Request $request)
    {
        $menu = Menu::find($id);
        $role = Roles::where('slug', $slug)->first();

        if ($menu && $role) {
            $menu->items()->delete();
            $json_data = json_decode($request->json_data, true);

            if (isset($json_data['menuitem']) && count($json_data['menuitem'])) {
                Menu::saveFromJson($json_data['menuitem'], $menu, $role);

                return redirect()->back()->with('message', "Menu Updated successfully");
            }

        }

        return redirect()->to('admin/console/structure/menus');
    }

    public function getClassify()
    {
        return view('console::structure.classify');
    }

    public function getUrls()
    {
        return view('console::structure.urls');
    }

    public function getSettings()
    {
        return view('console::structure.settings');
    }

    public function getPagePreview($page_id, Request $request)
    {
        $layout = $request->get('pl');
        $page = AdminPages::find($page_id);
        $url = null;
        if (!$page) return redirect()->back();

        if (!str_contains($page->url, '{param}')) $url = $page->url;

        $layouts = ContentLayouts::findByType('section')->pluck("name", "slug");
        // $html = \View::make("ContentLayouts.$layout.$layout")->with(['settings'=>$this->options])->render();
        $lay = ContentLayouts::findVariation($layout);

        if (!$lay) {
            return view('console::structure.page-preview', ['data' => compact(['page_id', 'layout', 'page', 'url', 'layouts'])]);
        }

        $view['view'] = "console::structure.page-preview";
        $view['variation'] = $lay;
        $data = explode('.', $layout);
        return ContentLayouts::find($data[0])->renderSettings($view, compact(['page_id', 'layout', 'page', 'url', 'layouts']));
    }

    public function postSavePageSettings($page_id, Request $request)
    {
        $data = $request->except(['pl', 'image']);
        $layout_id = $request->get('layout_id');
        $page = AdminPages::find($page_id);

        if ($layout_id && !ContentLayouts::findVariation($layout_id)) return \Response::json(['error' => true, 'message' => 'Page Section not found  !!!']);
        $data['page_id'] = $page_id;

        $v = \Validator::make($data, ['page_id' => "exists:admin_pages,id"]);

        if ($v->fails()) return \Response::json(['error' => true, 'message' => $v->messages()]);

        if ($page) {
            $page->settings = (!empty($data)) ? json_encode($data, true) : null;
            $page->layout_id = $layout_id;
            $page->save();

            return \Response::json(['error' => false, 'message' => 'Page Layout settings Successfully assigned', 'module' => $page->module_id]);
        }

        return \Response::json(['error' => true, 'message' => 'Page not found  !!!']);
    }

    public function postPageData(Request $request)
    {
        $id = $request->get('id');
        $page = AdminPages::find($id);
        $layout = ContentLayouts::findVariation($page->layout_id);
        if ($page) {
            $html = view('console::structure._partials.page_data', compact(['page']))->render();
            return \Response::json(['error' => false, 'html' => $html, 'page' => $page, 'value' => ($layout) ? $layout->id : 0]);
        }

        return \Response::json(['error' => true]);
    }

    public function getForms(FieldValidations $fieldValidations)
    {
        $forms = Forms::where('type', 'new')->get();
        return view('console::structure.forms', compact('forms'));
    }

    public function getCreateForm(Request $request)
    {
        $form_slug = uniqid();
        $builders = [];
        $modules = Structures::getBuilderModules()->toArray();
        if (count($modules)) {
            foreach ($modules as $builder) {
                $builders[$builder->slug] = $builder->name;
            }
        }

        $slug = $request->get('slug');
        $builder = Structures::find($slug);

        if ($builder && \File::exists(base_path($builder->path . DS . 'views' . DS . $builder->builder . '.blade.php'))) {
            $file = view("$builder->namespace::" . $builder->builder, compact(['form']))->render();
        }

        $form_type = $request->get('form_type');
        $fields_type = $request->get('fields_type');
        if ($form_type == 'user') {
            $fieldJson = json_encode(Fields::where('table_name', $fields_type)->where('status', Fields::ACTIVE)->where('available_for_users', '!=', 0)->get()->toArray());
        } else {
            $fieldJson = json_encode(Fields::where('table_name', $fields_type)->where('status', Fields::ACTIVE)->get()->toArray());
        }

        return view('console::structure.create-form', compact(['form_slug', 'builders', 'form_type', 'fields_type', 'fieldJson', 'file', 'slug']));
    }

    public function getAddFieldModal(Request $request)
    {
        $slug = $request->get('p');
        $form = Forms::where('type', 'new')->where('created_by', 'core')->where('id', $request->slug)->first();
        if ($form) {
            $fields = Fields::where('form_group', $form->fields_type)->get();
            //$units = CmsItemReader::getAllGearsByType('units')->where('place', 'backend')->where('main_type', 'special_fields')->where('type',$form->fields_type)->run();
            if ($slug) {
                $field = Fields::where('form_group', $form->fields_type)
                    ->where('slug', $slug)
                    ->first();
            } elseif (count($fields)) {
                $field = Fields::where('form_group', $form->fields_type)
                    ->first();
            }

            $html = \View::make('console::structure._partials.add_field_modal', compact(['fields', 'field']))->render();
            return \Response::json(['html' => $html]);
        }

        return \Response::json(['error' => true], 500);
    }

    public function getUnitFieldModal(Request $request)
    {
        $slug = $request->get('p');
        $type = $request->get('type', 'general_fields');
        $mainType = 'text';
        $types = [];
        $ui_elemements = null;
        $model = null;
        $unit = null;
        if (count($this->unitTypes)) {
            foreach ($this->unitTypes as $unitType) {
                $types[$unitType['foldername']] = $unitType['title'];
            }

            $main_type = $this->unitTypes[0]['foldername'];
            if ($type) {
                $main_type = $type;
            }

            $ui_elemements = CmsItemReader::getAllGearsByType('units')->where('place', 'backend')->where('main_type', 'general_fields')->run();
            $specialElements = CmsItemReader::getAllGearsByType('units')->where('place', 'backend')->where('main_type', 'special_fields')->run();

            if ($slug) {
                $unit = CmsItemReader::getAllGearsByType('units')
                    ->where('place', 'backend')
                    ->where('main_type', 'general_fields')
                    ->where('slug', $slug)
                    ->first();

                $specialUnit = CmsItemReader::getAllGearsByType('units')
                    ->where('place', 'backend')
                    ->where('main_type', 'special_fields')
                    ->where('slug', $slug)
                    ->first();
            } elseif (count($ui_elemements)) {
                $unit = CmsItemReader::getAllGearsByType('units')
                    ->where('place', 'backend')
                    ->where('main_type', 'general_fields')
                    ->first();

                $specialUnit = CmsItemReader::getAllGearsByType('units')
                    ->where('place', 'backend')
                    ->where('main_type', 'special_fields')
                    ->first();
            }
            $variations = $unit->variations();

        }
        $html = \View::make('console::structure._partials.add_field', compact(['ui_elemements', 'types', 'unit', 'type', 'specialElements', 'specialUnit', 'mainType', 'variations', 'model']))->render();
        return \Response::json(['html' => $html]);
    }

    public function getUnitEditFieldModal(Request $request)
    {
        $data = $request->all();

        $form = Forms::where('type', 'new')->where('created_by', 'core')->where('id', $request->master_slug)->first();
        $slug = explode('.', $request->uislug);
        if (count($slug)) {
            $units = CmsItemReader::getAllGearsByType('units')->where('place', 'backend')->where('type', $form->fields_type)->run();
            $uiUnit = CmsItemReader::getAllGearsByType('units')
                ->where('place', 'frontend')
                ->where('type', 'component')
                ->where('slug', array_first($slug))
                ->first();

            $inputSlug = explode('.', $request->inputslug);
            if (count($inputSlug)) {
                $unit = CmsItemReader::getAllGearsByType('units')
                    ->where('place', 'backend')
                    ->where('main_type', 'special_fields')
                    ->where('slug', array_first($inputSlug))
                    ->first();
            }

            $variations = ($unit) ? $unit->variations() : [];
        }
        $model = $request->get('generaltab', []);
        $html = view('console::structure._partials.add_field', compact(['units', 'unit', 'type', 'variations', 'model', 'uiUnit', 'data', 'form']))->render();

        return \Response::json(['html' => $html]);
    }


    public function getAvailableFieldsModal(Request $request)
    {
        $success = false;
        $fields = [];
        if ($request->fields_type) {
            $fields = Fields::where('table_name', $request->fields_type)->where('status', Fields::ACTIVE)->get()->toArray();
            $success = true;
        }

        return \Response::json(['success' => $success, 'fields' => $fields]);
    }

    public function getUnitVariations(Request $request)
    {
        $variations = null;
        $unit = CmsItemReader::getAllGearsByType('units')
            ->where('place', 'backend')
            ->where('slug', $request->slug)
            ->first();
        if ($unit) {
            if ($unit->main_type == 'general_fields') {
                foreach ($this->unitTypes as $unitType) {
                    $types[$unitType['foldername']] = $unitType['title'];
                }
            } else {
                foreach ($this->specialTypes as $unitType) {
                    $types[$unitType['foldername']] = $unitType['title'];
                }
            }

            $variations = count($unit->variations()) ? $unit->variations() : null;
        }
        $html = \View::make('console::structure._partials.variation_list', compact(['variations', 'unit', 'types']))->render();
        return \Response::json(['html' => $html]);
    }

    public function getUnitSettingsPage(Request $request)
    {
        $settings = null;
        $type = null;
        $slug = explode('.', $request->unit_id);

        if (count($slug)) {
            $unit = CmsItemReader::getAllGearsByType('units')
                ->where('main_type', 'general_fields')
                ->where('slug', array_first($slug))
                ->first();
            if ($unit) {
                $units = CmsItemReader::getAllGearsByType('units')
                    ->where('main_type', 'general_fields')
                    ->where('type', $unit->type)
                    ->run();
                $type = $unit->type;
                $validationRules = $this->fieldValidation->getRules();
                $variations = count($unit->variations()) ? $unit->variations() : null;

                $settings = view("console::backend.gears.fields.types.$type", compact(['validationRules', 'units', 'variations', 'unit']))->render();
            }
        }

        return \Response::json(['settings' => $settings, 'type' => $type]);
    }

    public function getComponentSettings(Request $request)
    {
        $slug = explode('.', $request->slug);
        if (count($slug)) {
            $unit = CmsItemReader::getAllGearsByType('units')
                ->where('type', 'component')
                ->where('slug', array_first($slug))
                ->first();
            if ($unit) {
                $html = $unit->render();
                $settings = $unit->renderSettings();
                return \Response::json(['settings' => $settings, 'html' => $html, 'error' => false]);
            }
        }
        return \Response::json(['error' => true]);
    }

    public function getUnitVariationField(Request $request)
    {
        $slug = explode('.', $request->slug);
        if (count($slug)) {
            $unit = CmsItemReader::getAllGearsByType('units')
                ->where('slug', array_first($slug))
                ->first();
            if ($unit) {
                $blade = \File::get("$unit->path" . DS . "$unit->main_file");
                return \Response::json(['html' => BBRenderUnits($request->slug), 'blade' => $blade, 'options' => $unit->options, 'error' => false]);
            }
        }
        return \Response::json(['message' => 'wrong message', 'error' => true]);
    }

    public function getUnitVariationSettings(Request $request)
    {
        $slug = explode('.', $request->id);
        if (count($slug)) {
            $tpl = CmsItemReader::getAllGearsByType('units')
                ->where('slug', array_first($slug))
                ->first();
            if ($tpl) {
                $html = view('console::backend.gears.fields._partials.variation_list_settings', compact(['tpl']))->render();
                return \Response::json(['html' => $html, 'error' => false]);
            }
        }
        return \Response::json(['message' => 'wrong message', 'error' => true]);

    }

    public function getCreateField()
    {
        $types = [];
        $defaultFieldHtml = $this->settings->getSettings('setting_system', 'default_field_html');
        if (count($this->unitTypes)) {
            foreach ($this->unitTypes as $unitType) {
                $types[$unitType['foldername']] = $unitType['title'];
            }
        }
        return view('console::structure.create_field', compact('types', 'defaultFieldHtml'));
    }

    public function getCreateFieldNew()
    {
        return view('console::structure.create_field_studio');
    }

    public function getFields()
    {
        $fields = Fields::all();
        return view('console::structure.fields', compact(['fields']));
    }

    public function getEditForms()
    {
        $forms = Forms::where('type', 'edit')->get();
        return view('console::structure.edit_forms', compact(['forms']));
    }

    public function postCreateField(Request $request)
    {
        $data = $request->except('_token');
        $v = \Validator::make(
            $data,
            [
                'name' => "required",
                'table_name' => "required",
                'column_name' => "required",
                'unit' => 'required'
            ]
        );
        if ($v->fails()) return redirect()->back()->withInput()->withErrors($v->messages());
        $dataToSave = [
            'name' => $data['name'],
            'slug' => uniqid(),
            'table_name' => $data['table_name'],
            'column_name' => $data['column_name'],
            'created_by' => \Auth::id(),
            'structured_by' => 'custom',
            'unit' => $data['unit'] != '' ? $data['unit'] : NULL,
            'label' => $data['label'] != '' ? $data['label'] : NULL,
            'placeholder' => $data['placeholder'] != '' ? $data['placeholder'] : NULL,
            'icon' => $data['icon'] != '' ? $data['icon'] : NULL,
            'tooltip' => $data['tooltip'] != '' ? $data['tooltip'] : NULL,
            'custom_html' => $data['custom_html'] != '' ? $data['custom_html'] : NULL,
            'field_html' => $data['field_html'] != '' ? $data['field_html'] : 'no',
            'second_table' => isset($data['second_table']) && $data['second_table'] != '' ? $data['second_table'] : NULL,
            'second_column' => isset($data['second_column']) && $data['second_column'] != '' ? $data['second_column'] : NULL,
            'required' => $data['required'],
            'visibility' => $data['visibility'],
            'default_value' => $data['default_value'] != '' ? $data['default_value'] : NULL,
            'available_for_users' => $data['available_for_users'],
            'before_save' => $data['before_save'],
        ];
        $dataToSave['json_data'] = json_encode($dataToSave, true);
//        if($data['custom_field_html'] != 'no') {
//            $dataToSave['custom_html'] = $data['custom_field_html'];
//        }
        Fields::create($dataToSave);

        return redirect('admin/console/structure/fields')->with('message', 'Field created');
    }

    public function getEditField(Request $request)
    {
        $field = Fields::findOrFail($request->id);
        $types = [];
        if (count($this->unitTypes)) {
            foreach ($this->unitTypes as $unitType) {
                $types[$unitType['foldername']] = $unitType['title'];
            }
        }
        $unitSlug = explode('.', $field->unit)[0];
        $unit = CmsItemReader::getAllGearsByType('units')
            ->where('slug', $unitSlug)
            ->first();

        $validation = new FieldValidations();
        $rule = $validation->getBaseValidationRulse($field->table_name, $field->column_name);
        return view('console::structure.edit_field', compact(['field', 'types', 'unit','rule']));
    }

    public function postEditField($id, Request $request)
    {
        $data = $request->except(['_token']);
        $field = Fields::findOrFail($id);

        if ($field->structured_by != 'custom') {
            $field->update(['json_data' => $request->get('settings', null), 'unit' => $request->get('unit', null)]);
            return redirect('admin/console/structure/fields')->with('message', 'Field Updated');
        }

        $v = \Validator::make(
            $data,
            [
                'name' => "required",
                'table_name' => "required",
                'column_name' => "required",
                'unit' => 'required'
            ]
        );

        if ($v->fails()) return redirect()->back()->withInput()->withErrors($v->messages());

        $field->update([
            'name' => $data['name'],
            'table_name' => $data['table_name'],
            'column_name' => $data['column_name'],
            'json_data' => $data['settings'],
            'unit' => $data['unit'] != '' ? $data['unit'] : NULL,
            'label' => $data['label'] != '' ? $data['label'] : NULL,
            'placeholder' => $data['placeholder'] != '' ? $data['placeholder'] : NULL,
            'icon' => $data['icon'] != '' ? $data['icon'] : NULL,
            'tooltip' => $data['tooltip'] != '' ? $data['tooltip'] : NULL,
            'custom_html' => $data['custom_html'] != '' ? $data['custom_html'] : NULL,
            'field_html' => $data['field_html'] != '' ? $data['field_html'] : 'no',
            'second_table' => isset($data['second_table']) && $data['second_table'] != '' ? $data['second_table'] : NULL,
            'second_column' => isset($data['second_column']) && $data['second_column'] != '' ? $data['second_column'] : NULL,
            'required' => $data['required'],
            'visibility' => $data['visibility'],
            'default_value' => $data['default_value'] != '' ? $data['default_value'] : NULL,
            'available_for_users' => $data['available_for_users'],
            'before_save' => $data['before_save'],
        ]);

        return redirect('admin/console/structure/fields')->with('message', 'Field Updated');
    }


    public function getCreateAdvanced()
    {
        return view('console::structure.advanced');
    }

    public function getUnitRender(Request $request)
    {
        $html = null;
        $slug = explode('.', $request->slug);

        if (count($slug)) {
            $unit = CmsItemReader::getAllGearsByType('units')
                ->where('type', 'component')
                ->where('slug', array_first($slug))
                ->first();
            if ($unit) $html = $unit->render();
        }

        return \Response::json(['html' => $html]);
    }

    public function postSaveForm(Request $request)
    {
        $data = $request->except('_token');
        $v = \Validator::make(
            $data,
            [
                'name' => "required",
                'form_type' => 'required',
                'fields_type' => 'required',
                'form_builder' => 'required',
                'blade' => 'required',
                'fields' => 'required',
            ]
        );

        if ($v->fails()) return redirect()->back()->withInput()->withErrors($v->messages());

        $form = new Forms();
        $form->slug = uniqid();
        $form->settings = $data['settings'];
        $form->name = $data['name'];
        $form->type = "edit";
        $form->created_by = "custom";
        $form->fields_type = $data['fields_type'];
        $form->form_builder = $data['form_builder'];
        $form->form_type = $data['form_type'];
        if ($form->save()) {
            Forms::generateBlade($form->id, $data['blade']);
        }

        return redirect()->to('/admin/console/structure/edit-forms')->with('message', 'Form Successfully created');
    }

    public function getFormEdit($id, Request $request)
    {
        $file = null;
        $form = Forms::findOrFail($id);
        $fields = $form->getFields(true);
        $blade = $form->renderBlade();
        $bladeRendered = $form->render();
        $modules = Structures::getBuilderModules()->toArray();
        $builders = [];
        if (count($modules)) {
            foreach ($modules as $builder) {
                $builders[$builder->slug] = $builder->name;
            }
        }

        $form->form_builder = $slug = $request->get('slug', $form->form_builder);
        $builder = Structures::find($slug);

        if ($builder && \File::exists(base_path($builder->path . DS . 'views' . DS . $builder->builder . '.blade.php'))) {
            $file = view("$builder->namespace::" . $builder->builder, compact(['form']))->render();
        }


        if ($form->form_type == 'user') {
            $fieldJson = json_encode(Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->where('available_for_users', '!=', 0)->get()->toArray());
        } else {
            $fieldJson = json_encode(Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->get()->toArray());
        }

        return view('console::structure.edit-form', compact(['form', 'blade', 'fields', 'bladeRendered', 'builders', 'file', 'fieldJson']));
    }

    public function getDefaultHtml()
    {
        $defaultFieldHtml = $this->settings->getSettings('setting_system', 'default_field_html');
        $variationId = $defaultFieldHtml->val;
        $settings = Units::findByVariation($variationId)->renderSettings();
        $variation = Units::findVariation($variationId)->toArray();
        $unit = Units::findByVariation($variationId)->render($variation);
        return \Response::json([
            'html' => $unit,
            'settings' => htmlentities($settings)
        ]);
    }

    public function getCustomHtml(Request $request)
    {
        $variationId = $request->slug;
        $settings = Units::findByVariation($variationId)->renderSettings();
        $variation = Units::findVariation($variationId)->toArray();
        $unit = Units::findByVariation($variationId)->render($variation);
        return \Response::json([
            'html' => $unit,
            'settings' => htmlentities($settings)
        ]);
    }

    public function getSavedHtmlType(Request $request)
    {
        $renderType = $html = null;
        $form = Forms::find($request->get('id'));
        $field = Fields::where('slug', $request->slug)->first();

        if ($form) {
            $form_type = $form->form_type;
        } elseif ($request->get('form_type')) {
            $form_type = $request->get('form_type');
        } else {
            return \Response::json(['error' => true]);
        }

        if (!$field) return \Response::json(['error' => true]);

        if ($form_type == 'user') {
            if ($field->available_for_users == 1) {
                $html = BBField(['slug' => $request->slug]);
                $renderType = 'render';
            } elseif ($field->available_for_users == 2) {
                $html = BBFieldHidden(['slug' => $request->slug]);
                $renderType = 'hidden';
            } elseif ($field->available_for_users == 3) {
                $renderType = 'no_render';
            }
        } else {
            if ($field->visibility) {
                $html = BBField(['slug' => $request->slug]);
                $renderType = 'render';
            } else {
                $html = BBFieldHidden(['slug' => $request->slug]);
                $renderType = 'hidden';
            }
        }


        return \Response::json([
            'field' => $field->toArray(),
            'html' => $html,
            'type' => $renderType,
            'error' => false
        ]);
    }

    public function postChangeFieldStatus(Request $request)
    {
        $status = $request->status == 'true' ? 1 : 0;
        $field = Fields::where('slug', $request->slug)->first();
        $field->status = $status;
        $success = $field->save() ? true : false;
        return \Response::json([
            'success' => $success
        ]);
    }

    public function postFormEdit($id, Request $request)
    {
        $data = $request->all();
        $form = Forms::findOrFail($id);
        $response = $form->validateColumns($data['fields']);

        if ($response['error']) {
            if ($request->ajax()) {
                return \Response::json([
                    'error' => true,
                    'message' => $response['message']
                ]);
            } else {
                return redirect()->back()->with('message', $response['message']);
            }
        }

        $form->update($request->except('fields', 'blade', 'token', 'blade_rendered', 'new_builder'));
        Forms::syncFields($form->id, $data['fields']);
        Forms::generateBlade($form->id, $data['blade']);

        if ($request->ajax()) {
            $builder = Structures::find($request->get('new_builder'));
            if ($builder && \File::exists(base_path($builder->path . DS . 'views' . DS . $builder->builder . '.blade.php'))) {
                $file = view("$builder->namespace::" . $builder->builder, compact(['form']))->render();
                return \Response::json([
                    'error' => false,
                    'fields' => $form->getFields(true),
                    'builder' => $file
                ]);
            } else {
                return \Response::json([
                    'error' => true,
                    'message' => 'Data is kept, but new builder not found'
                ]);
            }
        } else {
            if ($form->type == 'new') {
                return redirect()->to('/admin/console/structure/forms')->with('message', 'Form successfully edited');
            } else {
                return redirect()->to('/admin/console/structure/edit-forms')->with('message', 'Form successfully edited');
            }

        }
    }

    public function postBuilder(Request $request)
    {
        $slug = $request->get('slug');
        $builder = Structures::find($slug);

        if ($builder && \File::exists(base_path($builder->path . DS . 'views' . DS . $builder->builder . '.blade.php'))) {
            $form = Forms::find($request->get('form'));
            $file = view("$builder->namespace::" . $builder->builder, compact(['form']))->render();
            if (isset($builder->js) && count($builder->js)) {
                foreach ($builder->js as $js) {
                    \Eventy::action('my.scripts', url('app/ExtraModules/' . $builder->namespace . '/views/js/' . $js));
                }
            }


            return \Response::json([
                'error' => false,
                'builder' => $file
            ]);
        }

        return \Response::json([
            'error' => true
        ]);
    }

    public function getFormSettings($id)
    {
        $form = Forms::findOrFail($id);
        if ($form->form_type == 'user') {
            $fields = Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->where('available_for_users', '!=', 0)->get();
        } else {
            $fields = Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->get();
        }

        $settings = json_decode($form->settings, true);
        return view('console::structure.form-settings', compact(['form', 'fields', 'settings']));
    }

    public function postFormSettings($id, Request $request)
    {
        $data = $request->all();

        $form = Forms::findOrFail($id);

        $v = \Validator::make(
            $data,
            [
                'fields_type' => "required",
                'form_type' => "required",
            ]
        );
        if ($v->fails()) return redirect()->back()->withInput()->withErrors($v->messages());

        $settings = json_encode($request->only('message', 'is_ajax','event'));

        $form->update([
            'fields_type' => $data['fields_type'],
            'form_type' => $data['form_type'],
            'settings' => $settings
        ]);

        return redirect()->to('/admin/console/structure/forms')->with('message', 'Settings saved successfully');
    }

    public function postAvailableFields(Request $request)
    {
        $table = $request->get('table');

        $fields = Fields::where('table_name', $table)->get();

        $html = view('console::structure._partials.available_fields', compact('fields'))->render();

        return \Response::json([
            'error' => false,
            'html' => $html
        ]);
    }

    public function getFormEntries($id)
    {
        $form = Forms::findOrFail($id);
        $entries = $form->entries;

        return view('console::structure.entries', compact('form', 'entries'));
    }

    public function postGetEntryData(Request $request)
    {
        $id = $request->get('id');

        $entry = FormEntries::findOrFail($id);

        ($entry->data) ? $data = unserialize($entry->data) : $data = [];

        if (count($data)) {
            $html = view('console::structure._partials.entry', compact('data'))->render();
            return \Response::json(['error' => false, 'html' => $html]);
        }

        return \Response::json(['error' => 'true']);
    }

    public function getEditForm($id, Request $request)
    {
        $file = null;
        $form = Forms::where('id', $id)->where('type', 'edit')->first();

        if (!$form) abort(404);

        $fields = $form->getFields(true);
        $blade = $form->renderBlade();
        $bladeRendered = $form->render();
        $modules = Structures::getBuilderModules()->toArray();
        $builders = [];
        if (count($modules)) {
            foreach ($modules as $builder) {
                $builders[$builder->slug] = $builder->name;
            }
        }

        $form->form_builder = $slug = $request->get('slug', $form->form_builder);
        $builder = Structures::find($slug);

        if ($builder && \File::exists(base_path($builder->path . DS . 'views' . DS . $builder->builder . '.blade.php'))) {
            $file = view("$builder->namespace::" . $builder->builder, compact(['form']))->render();
        }


        if ($form->form_type == 'user') {
            $fieldJson = json_encode(Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->where('available_for_users', '!=', 0)->get()->toArray());
        } else {
            $fieldJson = json_encode(Fields::where('table_name', $form->fields_type)->where('status', Fields::ACTIVE)->get()->toArray());
        }

        return view('console::structure.create-form', compact(['form', 'blade', 'fields', 'bladeRendered', 'builders', 'file', 'fieldJson', 'slug']));
    }
}
