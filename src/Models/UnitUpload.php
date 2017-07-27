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

namespace Sahakavatar\Console\Models;

use Illuminate\Http\Request;
use Sahakavatar\Cms\Helpers\helpers;
use App\Models\Templates\Units;
use Zipper,File;

class UnitUpload
{
    const ZIP = ".zip";

    public $uf;

    public $fileNmae;

    public $helper;

    public $generatedName;

    public $generatedSlug;

    protected $dir;

    private $folder;

    private $name;

    private $slug;

    private $place;

    /**
     * UnitUpload constructor.
     */
    public function __construct($path)
    {
        $this->helpers = new helpers;
        $this->uf = $path;
    }

    public function ResponseSuccess($data, $code, $links = null, $id = null)
    {
        return \Response::json(['data' => $data, 'invalid' => false, 'id' => $id, 'links' => $links, 'code' => $code, 'error' => false], $code);
    }

    public function ResponseInvalid($data, $code, $messages)
    {
        return \Response::json(['data' => $data, 'invalid' => true, 'messages' => $messages, 'code' => $code, 'error' => false], $code);
    }

    public function ResponseError($message, $code)
    {
        return \Response::json(['message' => $message, 'code' => $code, 'error' => true], $code);
    }

    /**
     * @param Request $request
     * @return array
     */

    public function upload(Request $request)
    {

        if ($request->hasFile('file')) {

            $extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
            $zip_file = $request->file('file')->getClientOriginalName();
            $this->fileNmae = str_replace(self::ZIP, "", $zip_file);
            $request->file('file')->move($this->uf, $zip_file); // uploading file to given path

            try {
                $this->extract();
            } catch (Exception $e) {
                return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
            }

            return ['folder' => $this->generatedName, 'slug' => $this->generatedSlug, 'data' => $this->fileNmae, 'code' => 200, 'error' => false];
        }
    }

    public function extract()
    {
        $fileName = $this->fileNmae;
        $this->generatedSlug = uniqid();
        $this->generatedName = $this->fileNmae . '_' . $this->generatedSlug;

        File::makeDirectory($this->uf . $this->generatedName);
        Zipper::make($this->uf . "/" . $fileName . self::ZIP)->extractTo($this->uf . $this->generatedName . DS);
    }

    public function validatConfAndMoveToMain($data)
    {
        $this->folder = $data['folder'];
        $this->name = $data['data'];
        $this->slug = $data['slug'];
        $this->place = $data['place'];
        if (File::exists($this->uf . $this->folder . DS . 'config.json')) {
            $file = $this->uf . $this->folder . DS . 'config.json';
            $response = $this->validate($file);
            if ($response['error'])
                return $response;

            $this->dir = config('paths.unit_path') . DS . $this->folder ;
            File::copyDirectory($this->uf . $this->folder, $this->dir);

            return $response;
        } else {
            if (File::exists($this->uf . $this->folder . DS . $this->name . DS . 'config.json')) {
                $file = $this->uf . $this->folder . DS . $this->name . DS . 'config.json';
                $response = $this->validate($file);
                if ($response['error'])
                    return $response;

                $this->dir = config('paths.unit_path') . DS . $this->folder;
                File::copyDirectory($this->uf . $this->folder . DS . $this->name, $this->dir);

                return $response;
            }
        }

        return $this->uf . $this->folder . DS . 'config.json';
    }

    private function validate($file)
    {
        $conf = File::get($file);
        if ($conf) {
            $conf = json_decode($conf, true);
            if (!isset($conf['main_type']))
                return ['message' => 'Main Type are required', 'code' => '404', 'error' => true];

            if (!isset($conf['self_type']))
                return ['message' => 'Type are required', 'code' => '404', 'error' => true];

            if ($conf['self_type'] != 'units')
                return ['message' => 'Self Type should be units', 'code' => '404', 'error' => true];

            $conf['slug'] = (string)$this->slug;
            $conf['folder'] = (string)$this->folder;
            $conf['created_at'] = time('now');
            $conf['is_core'] = 0;
            $conf['place'] = $this->place;
            $json = json_encode($conf, true);
            File::put($file, $json);
            return ['data' => $conf, 'code' => '200', 'error' => false];
        }

        return ['message' => 'Json file is empty !!!', 'code' => '404', 'error' => true];
    }


    public function makeVariations($data)
    {
        $variation_path = $this->dir . '/variations';
        if (File::isDirectory($variation_path)) {
            if ($files = File::allFiles($variation_path)) {
                foreach ($files as $file) {
                    if (File::extension($file) == 'json') {
                        $json = File::get($file);
                        if ($json) {
                            $json = json_decode($json, true);
                            $json['id'] = $data['slug'] . '.' . uniqid();
                            File::put($variation_path . DS . $json['id'] . '.json', json_encode($json, true));
                            File::delete($file);
                        }
                    }
                }
                return ['code' => '200', 'error' => false];
            }
        }
        File::makeDirectory($variation_path);
        Units::find($data['slug'])->makeVariation(['title' => 'main variation'])->save();
    }


}