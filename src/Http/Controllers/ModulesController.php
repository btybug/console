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

namespace Sahakavatar\Console\Http\Controllers;

use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\ExtraModules\Structures;
use App\Models\Menus\Menu;
use App\Modules\Modules\Models\AdminPages;
use File;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class ModulesController extends Controller
{
    /**
     * @var helpers
     */
    public $helper;
    /**
     * @var Module
     */
    protected $modules;
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

    /**
     * ModulesController constructor.
     * @param Module $module
     * @param Upload $upload
     * @param validateUpl $v
     */
    public function __construct()
    {
        $this->helper = new helpers();
        $this->up = config('paths.modules_upl');
        $this->mp = config('paths.extra_modules');
    }

    public function getIndexUploads()
    {
        return view('console::index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        $selected_module = $request->get('m');
        $type = $request->get('type');
        $addons = [];
        $module = null;

        if($type && $type == 'core'){
            $extras = json_decode(File::get(storage_path('app/modules.json')));
            if (isset($extras->{$selected_module})) {
                $module = $extras->{$selected_module};
            }else {
                $module = null;
                if (count($extras)) {
                    $module = $extras->Users;
                }
            }
        }else{
            $extras = Structures::getExtraModules();
            if (count($extras)) {
                $module = ($selected_module) ? (isset($extras[$selected_module])) ? $extras[$selected_module] : null : array_first($extras);
            }
        }

        if($module) $addons = BBGetModuleAddons($module->slug);

        return view('console::modules.list', compact(['module', 'addons', 'extras','type']));
    }

    public function postCreateMenu($module, Request $request)
    {

    }

    public function postMenuEdit($module, $menu, $role, Request $request)
    {
        dd($module, $menu, $role, $request->all());
    }

    public function getTest()
    {
        dd(Menu::find('menuConfig')->role('admin'));

    }

}
