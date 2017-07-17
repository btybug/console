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

use App\helpers\dbhelper;
use App\helpers\helpers;
use App\Http\Controllers\Controller;
use App\Modules\Modules\Models\AdminPages;
use App\Repositories\AdminsettingRepository as Settings;
use File;
use Illuminate\Http\Request;

/**
 * Class SettingsController
 * @package App\Modules\Frontend\Http\Controllers
 */
class GeneralController extends Controller
{

    /**
     * @var dbhelper|null
     */
    private $dbhelper = null;
    /**
     * @var helpers|null
     */
    private $helpers = null;

    /**
     * @var Settings|null
     */
    private $settings = null;

    /**
     * SettingsController constructor.
     * @param dbhelper $dbhelper
     * @param Settings $settings
     */
    public function __construct (dbhelper $dbhelper, Settings $settings)
    {
        $this->dbhelper = $dbhelper;
        $this->settings = $settings;
        $this->helpers = new helpers();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $system = $this->settings->getSystemSettings();
        $adminLoginPage = AdminPages::where('slug', 'admin-login')->first();

        return view('console::structure.settings', compact(['system', 'adminLoginPage']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings (Request $request)
    {
        $input = $request->except('_token');
        $adminLoginPage = AdminPages::where('slug', 'admin-login')->first();
        $v = \Validator::make($input, ['admin_login_url' => 'required|unique:admin_pages,url,'.$adminLoginPage->id]);

        if ($v->fails()) return back()->withInput()->withErrors($v->messages());

        if($adminLoginPage) {
            $adminLoginPage->url = $request->admin_login_url;
            $adminLoginPage->save();
        }
        $this->settings->updateSystemSettings($input);
        $this->helpers->updatesession('System successfully saved');

        return redirect()->back();
    }

    public function getValidations ()
    {
        $validations = BBGetAllValidations();
        return view('console::structure.general.validations', compact(['validations']));
    }

    public function getTriggerEvents ()
    {
        return view('console::structure.general.trigger_events');
    }
}