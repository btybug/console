<?php
/**
 * Created by PhpStorm.
 * User: Edo
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Btybug\Console\Repository;

use Btybug\btybug\Repositories\GeneralRepository;
use Btybug\Console\Models\Forms;

/**
 * Class FormsRepository
 * @package Btybug\Console\Repository
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

    /**
     * @return Forms
     */
    public function model()
    {
        return new Forms();
    }

    public function getByTypeNewPluck()
    {
        return $this->model()->where('type', 'new')->pluck('name', 'slug');
    }

    public function findByIdOrSlug($data)
    {
        return $this->model()->where('id', $data)->orWhere('slug', $data)->first();
    }
}