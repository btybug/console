<?php namespace Btybug\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Btybug\btybug\Models\ContentLayouts\ContentLayouts;
use Btybug\btybug\Services\CmsItemReader;
use Btybug\Console\Services\PageSectionsService;
use View;


/**
 * Class PageSectionsController
 * @package Btybug\Console\Http\Controllers
 */
class PageSectionsController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function getIndex(
        Request $request,
        PageSectionsService $pageSectionsService
    )
    {
        $currentPageSection = null;
        $pageSections = $pageSectionsService->getPageSections();
        if ($request->p) {
            $currentPageSection = $pageSectionsService->getPageSection($request->p);
        } else {
            if (count($pageSections)) {
                $currentPageSection = CmsItemReader::getAllGearsByType('page_sections')
                    ->where('place', 'backend')
                    ->first();
            }
        }
        $variations = $currentPageSection ? $currentPageSection->variations() : [];

        return view('console::backend.page_sections.index', compact(['pageSections', 'currentPageSection', 'variations']));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteVariation(Request $request)
    {
        $result = false;
        if ($request->slug) {
            $result = ContentLayouts::deleteVariation($request->slug);
        }
        return \Response::json(['success' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete(Request $request)
    {
        $slug = $request->get('slug');
        $pageSection = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'backend')
            ->where('slug', $slug)
            ->first();
        if ($pageSection) {
            $deleted = $pageSection->deleteGear();
            return \Response::json(['success' => $deleted, 'url' => url('/admin/uploads/gears/page-section')]);
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function postUpload(
        Request $request,
        PageSectionsService $pageSectionsService
    )
    {
        return $pageSectionsService->upload($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMakeActive(
        Request $request,
        PageSectionsService $pageSectionsService
    )
    {
        $data = $request->all();
        $result = $pageSectionsService->postMakeActive($data);
        return \Response::json(['error' => $result]);

    }
}



