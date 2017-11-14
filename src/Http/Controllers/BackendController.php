<?php

namespace Btybug\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Btybug\Cms\Models\ContentLayouts\ContentLayouts;
use Btybug\Console\Services\BackendService;
use Btybug\Framework\Repository\VersionsRepository;
use Btybug\Settings\Repository\AdminsettingRepository;

/**
 * Class BackendController
 * @package Btybug\Console\Http\Controllers
 */
class BackendController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('console::backend.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTheme()
    {
        return view('console::backend.theme');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLayouts()
    {
        return view('console::backend.layouts');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUnits()
    {
        return view('console::backend.units');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViews()
    {
        return view('console::backend.views');
    }

    /**
     * @param Request $request
     * @param BackendService $backendService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getTemplates(
        Request $request,
        BackendService $backendService
    )
    {
        $layouts = ContentLayouts::findByType('section');
        $curentLayout = $backendService->getTemplates($request, $layouts);

        if (!$curentLayout) return redirect()->back();
        $variations = $curentLayout->variations();

        return view('console::backend.templates', compact(['layouts', 'curentLayout', 'variations']));
    }

    /**
     * @param $slug
     */
    public function settings()
    {
        $adminsettings = new AdminsettingRepository();
        $settings = $adminsettings->getSettings('backend_settings', 'backend_settings');
        $settings = json_decode($settings->val, true);
        return view('console::backend.settings', compact('settings'));

    }

//{"header":"1","selcteunit":null,"header_unit":"58d0f2d9858ae.58d0f2d9a95df","backend_page_section":"default_page_section.main_v","placeholders":{"left_bar":{"enable":"1","value":"58d166ae1246f.58d166ae3d705"},"right_bar":{"enable":"0","value":null}}}
    public function postSaveSettings(Request $request)
    {
        $adminsettings = new AdminsettingRepository();
        $adminsettings->createOrUpdateToJson($request->except('_token'), 'backend_settings', 'backend_settings');
        return redirect()->back()->with('message', 'sucsses');
    }

    public function getSettings($slug)
    {
        if ($slug) {
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
    public function postSettings(Request $request)
    {
        $output = ContentLayouts::savePageSectionSettings($request->slug, $request->itemname, $request->except(['_token', 'itemname']), $request->save);
        return response()->json([
            'url' => isset($output['id']) ? url('/admin/console/backend/page-section/settings/' . $output['id']) : false,
            'html' => isset($output['data']) ? $output['data'] : false

        ]);
    }

    /**
     * @param Request $request
     * @param BackendService $backendService
     * @return mixed
     */
    public function postMakeActive(
        Request $request,
        BackendService $backendService
    )
    {
        $data = $request->all();
        $result = $backendService->makeActive($data);
        return \Response::json(['error' => $result]);
    }
    public function getCssJs(VersionsRepository $versionsRepository, AdminsettingRepository $adminsettingRepository)
    {
        $cssData = $versionsRepository->wherePluck('type', 'css', 'name', 'id')->toArray();
        $jsData = $versionsRepository->getJSLiveLinks(true)->toArray();
        $model = $adminsettingRepository->getVersionsSettings('versions', 'backend');
        return view('console::backend.css_js', compact(['cssData', 'model', 'jsData']));
    }

    public function postCssJs(Request $request, AdminsettingRepository $adminsettingRepository, SettingsService $service)
    {
        $data = $request->except('_token');
        $adminsettingRepository->createOrUpdateToJson($data, 'versions', 'backend');

        return back()->with('message', 'Settings are saved');
    }

}