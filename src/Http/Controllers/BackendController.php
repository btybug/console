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
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\ExtraModules\Structures;
use App\Models\Menus\Menu;
use App\Models\Templates\Templates;
use App\Modules\Modules\Models\AdminPages;
use File;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class BackendController extends Controller
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
    public function __construct ()
    {
        $this->helper = new helpers();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        return view('console::backend.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTheme ()
    {
        return view('console::backend.theme');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLayouts ()
    {
        return view('console::backend.layouts');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUnits ()
    {
        return view('console::backend.units');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViews ()
    {
        return view('console::backend.views');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getTemplates (Request $request)
    {
//        $type=$request->get('type','general');
        $p=$request->get('p',0);
        $curentLayout=null;
        $layouts= ContentLayouts::findByType('section');
        if($p){
            $curentLayout=ContentLayouts::find($p);
        }else{
            if(count($layouts)){
                $curentLayout=$layouts[0];
            }

        }

        if(!$curentLayout)return redirect()->back();
        $variations=$curentLayout->variations();

        return view('console::backend.templates',compact(['layouts','curentLayout','variations','type']));
    }

    /**
     * @param $slug
     */
    public function getSettings($slug) {
        if($slug) {
            $view = ContentLayouts::renderLivePreview($slug);
            return $view ? $view : abort('404');
        } else {
            abort('404');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSettings(Request $request) {
        $output = ContentLayouts::savePageSectionSettings($request->slug, $request->itemname, $request->except(['_token', 'itemname']), $request->save);
        return response()->json([
            'url' => isset($output['id']) ? url('/admin/console/backend/page-section/settings/' . $output['id']) : false,
            'html' => isset($output['data']) ? $output['data'] : false

        ]);
    }

    public function postMakeActive(Request $request)
    {
        $data = $request->all();
        $result = false;
        if($data['type'] == 'page_section'){
            ContentLayouts::active()->makeInActive()->save();
            $page_section = ContentLayouts::find($data['slug']);
            if($page_section) $result = $page_section->setAttributes("active",true)->save() ? false : true;
            if(!ContentLayouts::activeVariation($data['slug'])) {
                $main = $page_section->variations()[0];
                $result = $main->setAttributes("active",true)->save() ? false : true;
            }
        }else if($data['type'] == 'page_section_variation'){
            ContentLayouts::activeVariation($data['slug'])->makeInActiveVariation()->save();
            $pageSectionVariation = ContentLayouts::findVariation($data['slug']);
            $pageSectionVariation->setAttributes('active', true);
            $result = $pageSectionVariation->save() ? false : true;
        }
        return \Response::json(['error' => $result]);

    }
}
