<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Sahakavatar\Console\Repository;

use Sahakavatar\Cms\Repositories\GeneralRepository;
use Sahakavatar\Console\Models\AdminPages;

/**
 * Class AdminPagesRepository
 * @package Sahakavatar\Console\Repository
 */
class AdminPagesRepository extends GeneralRepository
{
    /**
     * @return mixed
     */
    public function getGroupedWithModule()
    {
        return $this->model->where('parent_id', 0)->get()->groupBy('module_id');
    }

    /**
     * @param $role
     * @return mixed
     */
    public function getPermissionsByRole($role)
    {
        return $this->model()->permission_role()->where('role_id', $role->id)->first();
    }

    /**
     * @return AdminPages
     */
    public function model()
    {
        return new AdminPages();
    }
}