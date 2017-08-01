<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Sahakavatar\Console\Repository;

use Sahakavatar\Cms\Repositories\GeneralRepository;
use Sahakavatar\Manage\Models\FrontendPage;

/**
 * Class AdminPagesRepository
 * @package Sahakavatar\Console\Repository
 */
class FrontPagesRepository extends GeneralRepository
{
    /**
     * @return AdminPages
     */
    public function model()
    {
        return new FrontendPage();
    }

    /**
     * @return mixed
     */
    public function getGroupedWithModule()
    {
        return $this->model->where('parent_id', NULL)->groupBy("module_id")->get();
    }

    public function getRolesByPage(int $id, bool $imploded = true)
    {
        $page = $this->model->find($id);
        $pageRoles = [];
        if ($page) {
            $parent = $page->parent;
            if (count($page->permission_role)) {
                foreach ($page->permission_role as $perm) {
                    if ($parent) {
                        if ($parent->permission_role()->where('role_id', $perm->role->id)->first()) {
                            $pageRoles[] = $perm->role->slug;
                        }
                    } else {
                        $pageRoles[] = $perm->role->slug;
                    }
                }

                if ($imploded) {
                    return implode(',', $pageRoles);
                } else {
                    return $pageRoles;
                }
            }
        }
        if ($imploded) {
            return null;
        } else {
            return [];
        }
    }
}