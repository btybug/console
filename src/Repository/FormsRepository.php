<?php
/**
 * Created by PhpStorm.
 * User: Edo
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Sahakavatar\Console\Repository;

use Sahakavatar\Cms\Repositories\GeneralRepository;
use Sahakavatar\Console\Models\Forms;

/**
 * Class FormsRepository
 * @package Sahakavatar\Console\Repository
 */
class FormsRepository extends GeneralRepository
{

    /**
     * @param $slug
     */
    public function getNewCoreFormsBySlug($slug)
    {
        return $this->model()->where('type', 'new')->where('created_by', 'core')->where('id', $slug)->first();
    }

    public function getByTypeNewPluck()
    {
       return $this->model()->where('type', 'new')->pluck('name', 'slug') ;
    }

    /**
     * @return Forms
     */
    public function model()
    {
        return new Forms();
    }
}