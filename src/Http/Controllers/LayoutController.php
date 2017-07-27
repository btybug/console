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

use Sahakavatar\Cms\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\Templates\Widgets;
use File;
use Illuminate\Http\Request;

/**
 * Class ModulesController
 * @package App\Modules\Modules\Http\Controllers
 */
class LayoutController extends Controller
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

    public function getBackendIndex ()
    {
        $layouts = ContentLayouts::findByType('admin_layout');

        return view('console::backend.gears.layouts.index',compact('layouts'));
    }

}
