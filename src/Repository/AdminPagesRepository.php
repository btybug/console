<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Btybug\Console\Repository;

use Btybug\btybug\Repositories\GeneralRepository;
use Btybug\Console\Models\AdminPages;

/**
 * Class AdminPagesRepository
 * @package Btybug\Console\Repository
 */
class AdminPagesRepository extends GeneralRepository
{
    /**
     * @return mixed
     */
    public function getGroupedWithModule()
    {
        return $this->model->where('parent_id', 0)->groupBy('module_id')->get();
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

    public function main()
    {
        return $this->model()->main()->get();
    }

    public function PagesByModulesParent($module)
    {
        return self::model()->where('module_id', $module->slug)->where('parent_id', 0)->get();
    }

    public function childs()
    {
        return $this->model()->childs;
    }

    public function parent_permission_role_with_role($roleID)
    {
        return $this->parent_permission_role()->where('role_id', $roleID)->first();
    }

    public function parent_permission_role()
    {
        return $this->parent()->permission_role;
    }

    public function parent()
    {
        return $this->model()->parent;
    }

    public function getByUrl($url)
    {
        return $this->model()->where('url', $url)->orWhere('url', '/' . $url)->first();
    }
}