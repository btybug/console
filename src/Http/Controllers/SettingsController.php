<?php
/**
 * Copyright (c) 2017. All rights Reserved BtyBug TEAM
 */

namespace Btybug\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Btybug\Framework\Repository\VersionsRepository;
use Btybug\btybug\Repositories\AdminsettingRepository;

/**
 * Class SettingsController
 * @package Btybug\Console\Http\Controllers
 */
class SettingsController extends Controller
{
    /**
     * @param $slug
     */
    public function settings (
        AdminsettingRepository $adminsettingRepository,
        VersionsRepository $versionsRepository
    )
    {
        $settings = $adminsettingRepository->getSettings('backend_settings', 'backend_settings');
        $settings = json_decode($settings->val, true);

        $cssData = $versionsRepository->wherePluck('type', 'css', 'name', 'id')->toArray();
        $jsData = $versionsRepository->getJSLiveLinks(true)->toArray();
        $model = $adminsettingRepository->getVersionsSettings('versions', 'backend');

        return view('console::settings', compact('settings','cssData', 'model', 'jsData'));

    }

    public function postSaveSettings (
        Request $request,
        AdminsettingRepository $adminsettingRepository
    )
    {
        $adminsettingRepository->createOrUpdateToJson($request->except('_token'), 'backend_settings', 'backend_settings');

        return redirect()->back()->with('message', 'sucsses');
    }

    public function postVersion(
        Request $request,
        AdminsettingRepository $adminsettingRepository
    )
    {
        $data = $request->except('_token');
        $adminsettingRepository->createOrUpdateToJson($data, 'versions', 'backend');

        return back()->with('message', 'Settings are saved');
    }
}