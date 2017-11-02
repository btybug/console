<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Btybug\Console\Repository;

use Btybug\btybug\Repositories\GeneralRepository;
use Btybug\Manage\Models\FrontendPage;
use Btybug\User\Repository\RoleRepository;

/**
 * Class AdminPagesRepository
 * @package Btybug\Console\Repository
 */
class FrontPagesRepository extends GeneralRepository
{
    private $rolesPerm;

    /**
     * @return mixed
     */
    public function getGroupedWithModule()
    {
        return $this->model->where('parent_id', NULL)->groupBy("module_id")->get();
    }

    public function getMain()
    {
        return $this->model->where('parent_id', NULL)->get();
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

    public function getRolesByParent(int $id, bool $imploded = true)
    {
        $page = $this->model->find($id);
        $pageRoles = [];
        if ($page) {
            $parent = $page->parent;
            $rolesPerm = new RoleRepository();
            $roles = $rolesPerm->getFrontRoles();
            if (count($roles)) {
                foreach ($roles as $role) {
                    if ($parent) {
                        if ($parent->permission_role->where('role_id', $role->id)->first()) {
                            $pageRoles[] = $role->slug;
                        }
                    } else {
                        $pageRoles[] = $role->slug;
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

    public function PagesByModulesParent($module)
    {
        return self::model()->where('module_id', $module->slug)->where('parent_id', 0)->get();
    }

    /**
     * @return FrontendPage
     */
    public function model()
    {
        return new FrontendPage();
    }
}