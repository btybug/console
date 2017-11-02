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

namespace Btybug\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Btybug\btybug\Models\ContentLayouts\ContentLayouts;
use Btybug\btybug\Models\ExtraModules\Structures;
use Btybug\btybug\Models\Routes;
use Btybug\btybug\Services\CmsItemReader;
use Btybug\Console\Http\Requests\Structure\FieldCreateRequest;
use Btybug\Console\Http\Requests\Structure\FormCreateRequest;
use Btybug\Console\Http\Requests\Structure\FormSettingsUpdateRequest;
use Btybug\Console\Http\Requests\Structure\PageEditRequest;
use Btybug\Console\Http\Requests\Structure\SavePageSettingsRequest;
use Btybug\Console\Repository\AdminPagesRepository;
use Btybug\Console\Repository\FieldsRepository;
use Btybug\Console\Repository\FormsRepository;
use Btybug\Console\Repository\VersionsRepository;
use Btybug\Console\Services\FieldValidationService;
use Btybug\Console\Services\FormService;
use Btybug\Console\Services\StructureService;
use Sahakavatar\Settings\Repository\AdminsettingRepository;
use Sahakavatar\User\Services\RoleService;
use Sahakavatar\User\Services\UserService;

/**
 * Class ModulesController
 * @package Sahakavatar\Modules\Models\Http\Controllers
 */
class StructureController extends Controller
{
    public function getIndex()
    {
        return view('console::structure.index');
    }

    public function getTables(
        StructureService $structureService
    )
    {
        $tables = $structureService->getTables();
        return view('console::structure.tables', compact(['tables']));
    }

    public function getPages(
        Request $request,
        AdminPagesRepository $adminPagesRepository,
        RoleService $roleService,
        Routes $routes
    )
    {

//        dd(Routes::registerPages('sahak.avatar/framework'));
        $pageGrouped = $adminPagesRepository->getGroupedWithModule();
        if ($request->page) {
            $page = $adminPagesRepository->find($request->page);
        } else {
            $page = $adminPagesRepository->first();
        }

        if ($page && !$page->layout_id) $page->layout_id = 0;

        $rolesData = $roleService->getRolesSeperetedWith();
        return view('console::structure.pages.index', compact(['pageGrouped', 'page', 'rolesData']));
    }

    public function getPageSettings(
        Request $request,
        AdminPagesRepository $adminPagesRepository,
        UserService $userService
    )
    {
        $id = $request->id;
        $page = $adminPagesRepository->findOrFail($id);
        $admins = $userService->getAdmins()->pluck('username', 'id')->toArray();
        $tags = $page->tags;
        $placeholders = '';
        return view('console::structure.pages.settings', compact(['page', 'admins', 'tags', 'id', 'placeholders']));
    }

    public function postPageSettings(
        $id,
        PageEditRequest $request,
        AdminPagesRepository $adminPagesRepository
    )
    {
        $cotnentData = $request->only('header', 'header_unit', 'backend_page_section', 'placeholders');
        $data = $request->except('_token', 'type', 'tags', 'classify', 'header', 'header_unit', 'backend_page_section', 'placeholders');
        if (isset($data['url'])) {
            (starts_with($data['url'], '/')) ? false : $data['url'] = "/" . $data['url'];
        }
        $data['settings'] = json_encode($cotnentData, true);
        $adminPagesRepository->update($id, $data);
        return redirect()->to('/admin/console/structure/pages')->with('message', 'Successfully Updated Page');
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

    public function getPagePreview(
        $page_id,
        Request $request,
        StructureService $structureService
    )
    {
        return $structureService->getPagePreview($page_id, $request);
    }

    public function postSavePageSettings(
        $page_id,
        SavePageSettingsRequest $pageSettingsRequest,
        StructureService $structureService
    )
    {
        $page = $structureService->postPagePreview($page_id, $pageSettingsRequest);
        return \Response::json(['error' => false, 'message' => 'Page Layout settings Successfully assigned', 'module' => $page->module_id]);
    }

    public function postPageData(
        Request $request,
        AdminPagesRepository $adminPagesRepository
    )
    {
        $page = $adminPagesRepository->findOrFail($request->id);
        $layout = ContentLayouts::findVariation($page->layout_id);
        $html = view('console::structure._partials.page_data', compact(['page']))->render();

        return \Response::json(['error' => false, 'html' => $html, 'page' => $page, 'value' => ($layout) ? $layout->id : 0]);
    }

    public function getForms(
        FormsRepository $formsRepository
    )
    {
        $forms = $formsRepository->getBy('type', 'new');
        return view('console::structure.forms', compact('forms'));
    }

    public function getCreateForm(Request $request)
    {
        //TODO when modules will ready
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

    public function getAddFieldModal(
        Request $request,
        FormsRepository $formsRepository,
        FieldsRepository $fieldsRepository,
        StructureService $structureService
    )
    {
        $form = $formsRepository->getNewCoreFormsBySlug($request->slug);
        return $structureService->getAddFieldModal($request->slug, $form, $fieldsRepository);
    }

    public function getUnitFieldModal(
        Request $request,
        StructureService $structureService
    )
    {
        $html = $structureService->getUnitFieldModal($request);
        return \Response::json(['html' => $html]);
    }

    public function getUnitEditFieldModal(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $request->all();
        $html = $structureService->getUnitEditFieldModal($data);
        return \Response::json(['html' => $html]);
    }


    public function getAvailableFieldsModal(
        Request $request,
        FieldsRepository $fieldsRepository
    )
    {
        $success = false;
        $fields = [];
        if ($request->fields_type) {
            $fields = $fieldsRepository->getByTableNameAndActive($request->fields_type)->toArray();
            $success = true;
        }

        return \Response::json(['success' => $success, 'fields' => $fields]);
    }

    public function getUnitVariations(
        Request $request,
        StructureService $structureService
    )
    {
        $html = $structureService->getUnitVariations($request);
        return \Response::json(['html' => $html]);
    }

    public function getUnitSettingsPage(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $structureService->getUnitSettingsPage($request);
        return \Response::json(['settings' => $data['settings'], 'type' => $data['type']]);
    }

    public function getComponentSettings(
        Request $request,
        StructureService $structureService
    )
    {
        return $structureService->getComponentSettings($request);
    }

    public function getUnitVariationField(
        Request $request,
        StructureService $structureService
    )
    {
        return $structureService->getUnitVariationField($request);
    }

    public function getUnitVariationSettings(
        Request $request,
        StructureService $structureService
    )
    {
        return $structureService->getUnitVariationSettings($request);
    }

    public function getCreateField(
        AdminsettingRepository $adminsettingRepository
    )
    {
        $defaultFieldHtml = $adminsettingRepository->getSettings('setting_system', 'default_field_html');
        return view('console::structure.create_field', compact('defaultFieldHtml'));
    }

    public function getCreateFieldNew()
    {
        return view('console::structure.create_field_studio');
    }

    public function getFields(
        FieldsRepository $fieldsRepository
    )
    {
        $fields = $fieldsRepository->getAll();
        return view('console::structure.fields', compact(['fields']));
    }

    public function getEditForms(
        FormsRepository $formsRepository
    )
    {
        $forms = $formsRepository->getBy('type', 'edit');
        return view('console::structure.edit_forms', compact(['forms']));
    }

    public function postCreateField(
        FieldCreateRequest $request,
        StructureService $structureService
    )
    {
        $structureService->saveField($request->except('_token'));
        return redirect('admin/console/structure/fields')->with('message', 'Field created');
    }

    public function getEditField(
        Request $request,
        FieldsRepository $fieldsRepository,
        FieldValidationService $fieldValidationService
    )
    {
        $field = $fieldsRepository->findOrFail($request->id);
        $unitSlug = explode('.', $field->unit)[0];
        $unit = CmsItemReader::getAllGearsByType('units')
            ->where('slug', $unitSlug)
            ->first();
        $rule = $fieldValidationService->getBaseValidationRulse($field->table_name, $field->column_name);
        return view('console::structure.edit_field', compact(['field', 'unit', 'rule']));
    }

    public function postEditField(
        $id,
        FieldCreateRequest $request,
        FieldsRepository $fieldsRepository,
        StructureService $structureService
    )
    {
        $data = $request->except(['_token']);
        $field = $fieldsRepository->findOrFail($id);
        if ($field->structured_by != 'custom') {
            $field->update(['json_data' => $request->get('settings', null), 'unit' => $request->get('unit', null)]);
            return redirect('admin/console/structure/fields')->with('message', 'Field Updated');
        }

        $structureService->fieldUpdate($data, $field);

        return redirect('admin/console/structure/fields')->with('message', 'Field Updated');
    }


    public function getCreateAdvanced()
    {
        return view('console::structure.advanced');
    }

    public function getUnitRender(
        Request $request,
        StructureService $structureService
    )
    {
        return $structureService->getComponentSettings($request);
    }

    public function postSaveForm(
        FormCreateRequest $request,
        StructureService $structureService
    )
    {
        $data = $request->except('_token');
        $structureService->createForm($data);

        return redirect()->to('/admin/console/structure/edit-forms')->with('message', 'Form Successfully created');
    }

    public function getFormEdit($id, Request $request)
    {
        //TODO when Modules ready
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

    public function getDefaultHtml(
        StructureService $structureService
    )
    {
        $data = $structureService->getDefaultHtml();
        return \Response::json($data);
    }

    public function getCustomHtml(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $structureService->getCustomHtml($request);
        return \Response::json($data);
    }

    public function getSavedHtmlType(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $structureService->getSavedHtmlType($request);
        return \Response::json($data);
    }

    public function postChangeFieldStatus(
        Request $request,
        StructureService $structureService
    )
    {
        $success = $structureService->postChangeFieldStatus($request);
        return \Response::json([
            'success' => $success
        ]);
    }

    public function postFormEdit(
        $id,
        Request $request,
        FormsRepository $formsRepository,
        FormService $formService
    )
    {
        $data = $request->all();
        $form = $formsRepository->findOrFail($id);
        $response = $formService->validateColumns($form->id, $data['fields']);

        if ($response['error']) {
            return redirect()->back()->with('message', $response['message']);
        }

        $form->update($request->except('fields', 'blade', 'token', 'blade_rendered', 'new_builder'));
        $formService->syncFields($form->id, $data['fields']);
        $formService->generateBlade($form->id, $data['blade']);


        if ($form->type == 'new') {
            return redirect()->to('/admin/console/structure/forms')->with('message', 'Form successfully edited');
        } else {
            return redirect()->to('/admin/console/structure/edit-forms')->with('message', 'Form successfully edited');
        }
    }

    public function postNewBuilder(
        $id,
        Request $request,
        FormsRepository $formsRepository,
        FormService $formService,
        StructureService $structureService
    )
    {
        $data = $request->all();
        $form = $formsRepository->findOrFail($id);
        $response = $formService->validateColumns($form->id, $data['fields']);

        if ($response['error']) return \Response::json(['error' => true, 'message' => $response['message']]);
        $data = $structureService->postNewBuilder($request, $id);

        return \Response::json($data);
    }

    public function postBuilder(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $structureService->postBuilder($request);

        return \Response::json($data);
    }

    public function getFormSettings(
        $id,
        FormsRepository $formsRepository,
        StructureService $structureService
    )
    {
        $form = $formsRepository->findOrFail($id);
        $fields = $structureService->getFieldsByFormType($form);
        $settings = json_decode($form->settings, true);

        return view('console::structure.form-settings', compact(['form', 'fields', 'settings']));
    }

    public function postFormSettings(
        $id,
        FormSettingsUpdateRequest $request,
        FormsRepository $formsRepository
    )
    {
        $settings = json_encode($request->only('message', 'is_ajax', 'event'));
        $formsRepository->update($id, [
            'fields_type' => $request->fields_type,
            'form_type' => $request->form_type,
            'settings' => $settings
        ]);

        return redirect()->to('/admin/console/structure/forms')->with('message', 'Settings saved successfully');
    }

    public function postAvailableFields(
        Request $request,
        StructureService $structureService
    )
    {
        $html = $structureService->postAvailableFields($request->table);
        return \Response::json([
            'error' => false,
            'html' => $html
        ]);
    }

    public function getFormEntries(
        $id,
        FormsRepository $formsRepository
    )
    {
        $form = $formsRepository->findOrFail($id);
        return view('console::structure.entries')->with(['form' => $form, 'entries' => $form->entries]);
    }

    public function postGetEntryData(
        Request $request,
        StructureService $structureService
    )
    {
        $data = $structureService->getEntryData($request);
        return \Response::json($data);
    }

    public function getEditForm(
        $id,
        Request $request,
        FormsRepository $formsRepository,
        FormService $formService,
        StructureService $structureService,
        FieldsRepository $fieldsRepository
    )
    {
        $form = $formsRepository->findOrFail($id);
        $fields = $formService->getFields(true);
        $blade = $formService->renderBlade($id);
        $bladeRendered = $form->render($id);
        //TODO get Modules from new system
        $modules = Structures::getBuilderModules()->toArray();
        $data = $structureService->getBuilders($modules, $form, $request);

        if ($form->form_type == 'user') {
            $fieldJson = json_encode($fieldsRepository->getByTableNameActiveAndAvailablity($form->fields_type)->toArray());
        } else {
            $fieldJson = json_encode($fieldsRepository->getByTableNameAndActive($form->fields_type)->toArray());
        }

        return view('console::structure.create-form', compact(['form', 'blade', 'fields', 'bladeRendered', 'fieldJson']))->with($data);
    }
}
