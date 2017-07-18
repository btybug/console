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

/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 11/1/2016
 * Time: 9:35 PM
 */

namespace Sahakavatar\Console\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentLayouts\ContentLayouts;
use App\Models\Templates\Units;
use App\Models\Templates\Widgets;
use App\Modules\Modules\Models\AdminPages;
use App\Modules\Resources\Models\LayoutUpload;
use App\Modules\Resources\Models\Validation as thValid;
use File;
use Illuminate\Http\Request;
use view;


class LayoutsController extends Controller
{

    /**
     * @var
     */
    public $lyUpload;
    /**
     * @var
     */
    public $validateUpl;
    /**
     * @var mixed
     */
    public $up;
    public $unitTypes;

    /**
     * BackendThemeController constructor.
     * @param ThUpload $thUpload
     * @param thValid $validateUpl
     */
    public function __construct(LayoutUpload $lyUpload, thValid $validateUpl)
    {
        $this->lyUpload = $lyUpload;
        $this->validateUpl = new $validateUpl;

        $this->up = config('paths.backend_themes_upl');
        $this->unitTypes = @json_decode(File::get(config('paths.unit_path') . 'configTypes.json'), 1)['types'];
    }
    /**
     * @return view
     */
    public function getIndex()
    {

    }
    public function getBackendIndex ()
    {
        $layouts = ContentLayouts::findByType('admin_template');
        return view('uploads::gears.backend.layouts.index', compact(['layouts']));
    }

    public function getDelete(Request $request, $slug)
    {
        $layouts = ContentLayouts::find($slug);
        if ($layouts->delete()) return redirect()->back();
    }

    public function settings($slug)
    {
        $view['view'] = "console::backend.layouts.settings";
        return ContentLayouts::find($slug)->renderSettings($view);
    }

    public function postLayoutSettings(Request $request, $id, $save = false)
    {
        $layout = ContentLayouts::find($id);
        $html = $layout->renderLive($request->except('_token'));
        if ($save) {
            $layout->saveSettings($request->except('_token'));
        }
        return \Response::json(['error' => false, 'html' => $html]);
    }


    public function postUploadLayout(Request $request)
    {
        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (!$isValid) return $this->lyUpload->ResponseError('Uploaded data is InValid!!!', 500);

        $response = $this->lyUpload->upload($request);
        if (!$response['error']) {
            $result = $this->lyUpload->validatConfAndMoveToMain($response['folder'], $response['data']);

            if (!$result['error']) {
                File::deleteDirectory($this->up, true);
                return $result;
            } else {
                File::deleteDirectory($this->up, true);
                return $result;
            }
        } else {
            File::deleteDirectory($this->up, true);
            return $response;
        }
    }

}