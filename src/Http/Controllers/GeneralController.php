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

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Console\Http\Requests\Account\GeneralSettingsRequest;
use Sahakavatar\Console\Repository\AdminPagesRepository;
use Sahakavatar\Settings\Repository\AdminsettingRepository;

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
        $system = $adminsettingRepository->getSystemSettings();
        $adminLoginPage = $adminPagesRepository->findBy('slug', 'admin-login');

        return view('console::structure.settings', compact(['system', 'adminLoginPage']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings(
        GeneralSettingsRequest $request,
        AdminPagesRepository $adminPagesRepository,
        AdminsettingRepository $adminsettingRepository
    )
    {
        $input = $request->except('_token');
        $adminLoginPage = $adminPagesRepository->findBy('slug', 'admin-login');
        $adminPagesRepository->update($adminLoginPage->id, [
            'url' => $request->admin_login_url
        ]);
        $adminsettingRepository->updateSystemSettings($input);
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