<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Sahakavatar\Console\Repository;

use Sahakavatar\Cms\Repositories\GeneralRepository;
use Sahakavatar\Console\Models\Menu;


class MenuRepository extends GeneralRepository
{

    public function model()
    {
        return new Menu();
    }

    public function getWhereNotPlugins()
    {
        return $this->model->where('type', '!=', 'plugin')->get();
    }

    public function getWhereNotPluginsFirst()
    {
        return $this->model->where('type', '!=', 'plugin')->first();
    }
}