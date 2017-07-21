<?php

namespace Sahakavatar\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts;
use Sahakavatar\Console\Services\BackendService;

/**
 * Class BackendController
 * @package Sahakavatar\Console\Http\Controllers
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
}