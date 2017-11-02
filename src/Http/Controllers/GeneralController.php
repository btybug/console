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
use Btybug\Console\Http\Requests\Account\GeneralSettingsRequest;
use Btybug\Console\Repository\AdminPagesRepository;
use Btybug\Settings\Repository\AdminsettingRepository;

class GeneralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(
        AdminsettingRepository $adminsettingRepository,
        AdminPagesRepository $adminPagesRepository
    )
    {
        $adminLoginPage = $adminPagesRepository->findBy('slug', 'admin-login');
        $data = $adminsettingRepository->getBackendSettings();
        return view('console::structure.settings', compact(['data', 'adminLoginPage']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings(
        Request $request,
        AdminsettingRepository $adminsettingRepository
    )
    {
        $data = $request->except('_token', 'admin_login_url');
        if ($request->admin_login_url) {
            $adminsettingRepository->createOrUpdate($request->admin_login_url, 'setting_system', 'admin-login-url');
        }

        $adminsettingRepository->createOrUpdateToJson($data, 'backend_settings', 'backend_settings');
        return redirect()->back();
    }

    public function getValidations()
    {
        $validations = BBGetAllValidations();
        return view('console::structure.general.validations', compact(['validations']));
    }

    public function getTriggerEvents()
    {
        return view('console::structure.general.trigger_events');
    }
}