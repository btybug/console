<?php namespace Sahakavatar\Console\Http\Controllers;

use Sahakavatar\Cms\Services\CmsItemReader;
use Sahakavatar\Cms\Services\CmsItemRegister;
use Sahakavatar\Cms\Services\CmsItemUploader;
use App\Http\Controllers\Controller;
use Sahakavatar\Cms\Models\BackendTpl as Templates;
use Sahakavatar\Cms\Models\BackendTpl;
use Sahakavatar\Cms\Models\Templates\Units;
use App\Modules\Resources\Models\Files\FileUpload;
use App\Modules\Resources\Models\TemplateVariations as TemplateVariations;
use App\Modules\Console\Models\UnitUpload;
use App\Modules\Resources\Models\Validation as validateUpl;
use File;
use Illuminate\Http\Request;
use Resources;
use View;


class TemplatesController extends Controller
{

    private $helpers = null;

    private $up;

    private $tp;

    private $types;

    private $upload;

    public function __construct(validateUpl $validateUpl)
    {
        $this->upload = new CmsItemUploader('templates');
        $this->validateUpl = new $validateUpl;
        $this->up = config('paths.ui_elements_uplaod');
        $this->tp = config('paths.template_path');
        $this->types = @json_decode(File::get(config('paths.template_path') . 'configForBackendTypes.json'), 1)['types'];
        $this->tplTypes = @json_decode(File::get(config('paths.template_path') . 'configForBackendTypes.json'), 1)['types'];
    }

    public function getIndex(Request $request)
    {
        $slug = $request->get('p');
        $type = $request->get('type','header');
        $types = [];
        $templates = null;
        $tpl = null;
        if (count($this->tplTypes)) {
            foreach ($this->tplTypes as $tplType) {
                $types[$tplType['foldername']] = $tplType['title'];
            }

            $main_type = $this->tplTypes[0]['foldername'];
            if ($type) {
                $main_type = $type;
            }

            $templates = CmsItemReader::getAllGearsByType('templates')->where('place', 'backend')->where('type', $type)->run();
            if ($slug) {
                $tpl = CmsItemReader::getAllGearsByType('templates')
                    ->where('place', 'backend')
                    ->where('type', $type)
                    ->where('slug', $slug)
                    ->first();
            } elseif(count($templates)) {
                $tpl = CmsItemReader::getAllGearsByType('templates')
                    ->where('place', 'backend')
                    ->where('type', $type)
                    ->first();
            }
        }
        return view("console::backend.gears.tpl.index", compact(['templates', 'types', 'tpl', 'type']));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteVariation(Request $request) {
        $result = false;
        if($request->slug) {
            $result = Templates::deleteVariation($request->slug);
        }
        return \Response::json(['success' => $result]);
    }

    public function postUpload(Request $request)
    {
        return $this->upload->run($request);
    }

    public function postDelete(Request $request)
    {
        $slug = $request->get('slug');
        $tpl = CmsItemReader::getAllGearsByType('templates')
            ->where('place', 'backend')
            ->where('slug', $slug)
            ->first();
        if($tpl) {
            $deleted = $tpl->deleteGear();
            return \Response::json(['success' => $deleted, 'url' => url('/admin/console/backend/templates')]);
        }
    }

    public function getSettings($id,Request $request) {
        $slug = explode('.', $id);
        $ui = Templates::find($slug[0]);
        if(!$ui) {
            abort('404');
        }
        $variation = Templates::findVariation($id);
//        if (!$variation) return redirect()->back();
        $ifrem = array();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $ifrem['body'] = url('/admin/console/backend/templates/settings-iframe',$id);

        return view('console::backend.gears.tpl.preview', compact(['ui', 'id', 'ifrem', 'settings', 'variation']));
    }

    public function postSettings(Request $request)
    {
        $output = BackendTpl::saveSettings($request->id, $request->itemname, $request->except(['_token', 'itemname']), $request->save);
        $result =  $output ? ['html' => $output['html'], 'url' => url('/admin/console/backend/templates/settings/' . $output['slug']), 'error' => false] : ['error' => true];
        return \Response::json($result);
    }

    public function previewIframe($id, $type = null)
    {
        $slug = explode('.', $id);
        $ui = Templates::find($slug[0]);
        $variation = Templates::findVariation($id);
//        if (!$variation) return redirect()->back();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $settings_json = json_encode($settings, true);
        $htmlSettings = "No Settings!!!";

        if (isset($ui->have_setting) && $ui->have_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }

        $htmlBody = $ui->render(['settings' => $settings]);
        $settings_json = json_encode($settings, true);

        return view('console::backend.gears.tpl._partials.if_edit_preview', compact(['htmlBody', 'htmlSettings', 'settings_json', 'id', 'settings']));
    }
}



