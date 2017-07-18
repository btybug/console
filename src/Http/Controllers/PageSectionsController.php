<?php namespace Sahakavatar\Console\Http\Controllers;

use App\Core\CmsItemReader;
use App\Core\CmsItemUploader;
use App\Http\Controllers\Controller;
use App\Models\Templates\Sections;
use App\Models\ContentLayouts\ContentLayouts;
use File;
use Illuminate\Http\Request;
use Resources;
use View;


/**
 * Class SectionsController
 * @package App\Modules\Console\Http\Controllers
 */
class PageSectionsController extends Controller
{

    /**
     * @var null
     */
    private $helpers = null;
    /**
     * @var CmsItemUploader
     */
    private $upload;

    /**
     * SectionsController constructor.
     */
    public function __construct()
    {
        $this->upload = new CmsItemUploader('page_sections');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function getIndex(Request $request)
    {
        $slug = $request->get('p', 0);
        $currentPageSection = null;
        $pageSections = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'backend')
            ->run();
        if ($slug) {
            $currentPageSection = CmsItemReader::getAllGearsByType('page_sections')
                ->where('place', 'backend')
                ->where('slug', $slug)
                ->first();
        } else {
            if (count($pageSections)) {
                $currentPageSection = CmsItemReader::getAllGearsByType('page_sections')
                    ->where('place', 'backend')
                    ->first();
            }
        }

        $variations = $currentPageSection ? $currentPageSection->variations() : [];

        return view('console::backend.page_sections.index', compact(['pageSections', 'currentPageSection', 'variations', 'type']));
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
    public function postDeleteVariation(Request $request) {
        $result = false;
        if($request->slug) {
            $result = ContentLayouts::deleteVariation($request->slug);
        }
        return \Response::json(['success' => $result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete(Request $request) {
        $slug = $request->get('slug');
        $pageSection = CmsItemReader::getAllGearsByType('page_sections')
            ->where('place', 'backend')
            ->where('slug', $slug)
            ->first();
        if($pageSection) {
            $deleted = $pageSection->deleteGear();
            return \Response::json(['success' => $deleted, 'url' => url('/admin/uploads/gears/page-section')]);
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function postUpload(Request $request)
    {
        return $this->upload->run($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMakeActive(Request $request)
    {
        $data = $request->all();
        $result = false;
        if ($data['type'] == 'page_section') {
            ContentLayouts::active()->makeInActive()->save();
            $page_section = ContentLayouts::find($data['slug']);
            if ($page_section) $result = $page_section->setAttributes("active", true)->save() ? false : true;
            if (!ContentLayouts::activeVariation($data['slug'])) {
                $main = $page_section->variations()[0];
                $result = $main->setAttributes("active", true)->save() ? false : true;
            }
        } else if ($data['type'] == 'page_section_variation') {
            ContentLayouts::activeVariation($data['slug'])->makeInActiveVariation()->save();
            $pageSectionVariation = ContentLayouts::findVariation($data['slug']);
            $pageSectionVariation->setAttributes('active', true);
            $result = $pageSectionVariation->save() ? false : true;
        }
        return \Response::json(['error' => $result]);

    }
}



