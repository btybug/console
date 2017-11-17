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
use App\Models\ExtraModules\Structures;
use App\Modules\Console\Models\Asset;
use App\Modules\Console\Models\Menu;
use App\Modules\Users\Models\PermissionRole;
use App\Modules\Users\Models\Roles;
use File;
use Illuminate\Http\Request;
use Btybug\btybug\Models\ContentLayouts\ContentLayouts;
use Btybug\btybug\Services\CmsItemReader;
use Btybug\Modules\Models\Models\AdminPages;
use Btybug\Modules\Models\Models\Forms;
use Btybug\Modules\Models\Models\Routes;

/**
 * Class ModulesController
 * @package Btybug\Modules\Models\Http\Controllers
 */
class ModulesSettingsController extends Controller
{

    public $modules;
    public $extra_modules;
    public $module_path;
    public $page_menu;
    public $types;

    public function __construct()
    {
        $this->modules = json_decode(\File::get(storage_path('app/modules.json')));
        $this->extra_modules = json_decode(\File::get(storage_path('app/plugins.json')));
        $this->module_path = "/admin/console/modules";
        $this->page_menu = "configMenu";
        $this->types = @json_decode(File::get(config('paths.unit_path') . 'configTypes.json'), 1)['types'];
    }

    public function getMain($basename)
    {
        return view("console::modules.settings.main", compact(['basename']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex($slug)
    {
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        return view('console::modules.settings.general', compact(['slug', 'module', 'page_menu']));
    }

    private function validateModule($basename)
    {
        if (isset($this->modules->$basename)) {
            return $this->modules->$basename;
        } else {
            if (isset($this->extra_modules->$basename)) {
                return $this->extra_modules->$basename;
            }
        }

        return false;
    }

    public function getGears($slug, Request $request)
    {
        $type = $request->get('type', 'units');
        if (!Structures::find($slug)) {
            abort('404');
        }
        $templates = CmsItemReader::getModuleGearsBySlug($slug)->where('self_type', $type)->run();
        $p = $request->get('p', isset($templates[0]) ? $templates[0]->slug : null);
        $variations = [];
        $tpl = CmsItemReader::getModuleGearsBySlug($slug)->where('slug', $p)->first();
        if ($tpl) {
            $variations = $tpl->variations();
        }
        return view('console::modules.settings.gears', compact(['templates', 'type', 'variations', 'tpl']));
    }

    public function getAssets(Request $request)
    {
        $slug = $request->param;
        $main = $request->get('main', 'gears');
        $currentGear = null;
        if ($main == 'backend') {
            $gears = CmsItemReader::getModuleBackendGearsBySlug($request->param)->run();
        } else if ($main == 'gears') {
            $gears = CmsItemReader::getModuleGearsBySlug($request->param)->run();
        } else {
            $gears = NULL;
        }
        $p = $request->get('p');
        $type = $request->get('type');
        if ($p && $type) {
            if ($main == 'backend') {
                $currentGear = CmsItemReader::getModuleBackendGearsBySlug($request->param)->where('slug', $p)->first();
            } else {
                $currentGear = CmsItemReader::getModuleGearsBySlug($request->param)->where('slug', $p)->first();
            }
        } else {
            if (count($gears)) {
                $currentGear = $gears[0];
                $type = $request->get('type', $currentGear->self_type);
            }
        }

        $variations = isset($currentGear) ? $currentGear->variations() : NULL;
        return view('console::modules.settings.assets', compact(['slug', 'type', 'main', 'gears', 'currentGear', 'variations']));
    }

    public function getBuild($slug)
    {
        return view('console::modules.settings.build', compact(['slug']));
    }

    public function getPermission($slug)
    {
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        $roles = Roles::where('slug', '!=', 'user')->pluck('id', 'name');

        $pages = AdminPages::where('module_id', $module->namespace)->where('parent_id', 0)->get();
        return view('console::modules.settings.permission', compact(['slug', 'module', 'roles', 'pages']));
    }

    public function getCode($slug)
    {
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        $file_indexes = [];

        if (isset($module->path) && File::isDirectory(base_path() . $module->path)) {
            $files = File::allFiles(base_path() . $module->path);
            foreach ($files as $file) {
                $f = [];
                $f['full_path'] = $file;
                $file = substr($file, strpos($file, "/" . $module->name) + 1);
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $f['path'] = $file;
                $f['ext'] = $ext;
                if (!strpos($file, 'module.json')) {
                    $file_indexes[] = $f;
                }
            }
        }

        return view('console::modules.settings.code', compact(['slug', 'module', 'file_indexes']));
    }

    public function getTables($slug, $active = 0)
    {
        $module = $this->validateModule($slug);
        if (!$module) return redirect($this->module_path);

        $createForm = null;
        if (isset($module->tables) and isset($module->tables[$active]))
            $createForm = Forms::where('table_name', $module->tables[$active])->first();
        $page_menu = "configMenu";

        return view('console::modules.settings.tables', compact(['slug', 'module', 'active', 'createForm', 'page_menu']));
    }

    public function getViews($slug)
    {
        $module = $this->validateModule($slug);
        if (!$module) return redirect($this->module_path);

        $layouts = ContentLayouts::findByType('admin_template');

        return view('console::modules.settings.views', compact(['slug', 'module', 'layouts']));
    }

    public function getPages($slug, Request $request)
    {
        $pageID = $request->get('page');
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        $pageGrouped = AdminPages::groupBy('module_id')->get();
        $pages = AdminPages::pluck('title', 'id')->all();
        $modulesList = [$module];
        $type = 'pages';
        $rolesString = null;
        $layouts = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'backend')
            ->pluck("title", "slug");

        if ($pageID) {
            $page = AdminPages::find($pageID);
        } else {
            $page = AdminPages::where('module_id', $slug)->first();
        }

        if ($page && !$page->layout_id) $page->layout_id = 0;

        if ($page) {
            $rolesString = AdminPages::getRolesByPage($page->id);
        }


        return view('console::modules.settings.build.pages', compact(['rolesString', 'pageGrouped', 'pages', 'modulesList', 'layouts', 'module', 'slug', 'type', 'layouts', 'page']));
    }

    public function postPages(Request $request)
    {
        $data = $request->except('_token');
        $page = AdminPages::find($data['id']);

        if (!$page) return redirect()->back()->with('message', "Page not found");

        PermissionRole::optimizePageRoles($page, $data['tags']);

        $page->update([
            'redirect_to' => $data['redirect_to']
        ]);

        return redirect()->back()->with('message', "Page Updated !!!");
    }

    public function postPageData(Request $request)
    {
        $id = $request->get('id');
        $page = AdminPages::find($id);
        $rolesString = AdminPages::getRolesByPage($page->id, false);
        $layout = ContentLayouts::findVariation($page->layout_id);
        $allowedtags = AdminPages::getAllowedTags($page);
        if ($layout) {
            return \Response::json(
                ['error' => false,
                    'value' => $layout->id,
                    'page_name' => $page->title,
                    'page_id' => $page->id,
                    'page_date' => BBgetDateFormat($page->created_at),
                    'page_url' => url($page->url),
                    'roles_string' => $rolesString,
                    'tags' => $allowedtags
                ]
            );
        }

        return \Response::json(['error' => false, 'value' => 0, 'tags' => $allowedtags, 'roles_string' => $rolesString, 'page_name' => $page->title, 'page_date' => BBgetDateFormat($page->created_at), 'page_id' => $page->id, 'page_url' => url($page->url)]);
    }

    public function postPermission(Request $request)
    {
        $data = $request->except('_token');

        $page = AdminPages::find($data['pageID']);
        $newRole = Roles::find($data['roleID']);
        $rolesString = AdminPages::getRolesByPage($page->id, false);

        if ($data['isChecked'] == 'yes') {
            $rolesString[] = $newRole->slug;
        } else {
            if (($key = array_search($newRole->slug, $rolesString)) !== false) {
                unset($rolesString[$key]);
            }
        }

        if (count($rolesString)) {
            $roles = implode(',', $rolesString);
        } else {
            $roles = null;
        }

        PermissionRole::optimizePageRoles($page, $roles);

        $module = $this->validateModule($data['slug']);
        $roles = Roles::where('slug', '!=', 'user')->pluck('id', 'name');
        $pages = AdminPages::where('module_id', $module->namespace)->where('parent_id', 0)->get();

        $html = view('console::modules.settings._partials.perm_list', compact(['roles', 'pages']))->render();

        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function getMenus($slug, Request $request)
    {
        $menu = $request->get('p');
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        $menus = Menu::where('module', $slug)->where('parent_id', null)->get();
        $roles = Roles::where('slug', '!=', 'user')->get();

        return view('console::modules.settings.build.menus', compact(['slug', 'type', 'menus', 'roles', 'menu']));
    }

    public function postCreateMenus($slug, Request $request)
    {
        $module = $this->validateModule($slug);

        if (!$module) return redirect($this->module_path);

        $name = $request->get('name');

        File::put(base_path() . $module->path . "/Config/BackBuild/Menus/" . $name . ".json", json_encode([], true));

        return redirect()->back();
    }

    public function getMenuEdit($slug)
    {
        $pageGrouped = AdminPages::groupBy('module_id')->get();
        $html = Routes::getModuleRoutes('GET', 'admin/uploads/modules')->html();

        return view('console::modules.settings.build.edit_menus', compact(['slug', 'pageGrouped', 'html']));
    }

    public function getUrls($slug)
    {
        $html = Routes::getModuleRoutes('GET', 'admin/' . strtolower($slug))->html();

        return view('console::modules.settings.build.urls', compact(['slug', 'html']));
    }

    public function getClassify($slug)
    {
        return view('console::modules.settings.build.classify', compact(['slug']));
    }

    public function postoptimize(Request $request)
    {
        $data = $request->except('_token');
        $result = Routes::registrePages($data['slug']);
        if ($result) return \Response::json(['error' => false, 'messages' => $result]);

        return \Response::json(['error' => true, 'messages' => 'undifind plugin']);
    }
}
