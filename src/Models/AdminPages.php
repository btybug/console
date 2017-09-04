<?php

namespace Sahakavatar\Console\Models;

//use Sahakavatar\Cms\Models\UiElements;
use Illuminate\Database\Eloquent\Model;
use Sahakavatar\User\Models\Roles;

/**
 * Class AdminPages
 * @package App\Modules\Backend\Models
 */
class AdminPages extends Model
{

    public static $rules = [
        'url' => "required",
        'redirect' => "required|in:404,505,custom",
        'pagename' => 'required',
        'redirectto' => 'required_if:redirect,custom',
    ];
    /**
     * @var
     */
    private static $segment_array;
    /**
     * @var
     */
    private static $urlWithoutAdmin;
    /**
     * @var string
     */
    protected $table = 'admin_pages';
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    /**
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return bool
     */
    public static function findWithUrl()
    {

        $url = \Request::server('REQUEST_URI');
        $urlWithoutAdmin = $route = substr($url, 7);

        $page = self::where('url', $url)->orWhere(function ($query) use ($url, $urlWithoutAdmin) {
            $paramsUrl = self::replaceParametrs();
            $query->where('url', $urlWithoutAdmin)
                ->orWhere('url', $paramsUrl);
        })->first();

        if ($page) {
            return UiElements::getAllWidgets()->where('page', $page->slug)->run();
        }

        return false;
    }


    public static function getModuleRoutes($slug)
    {
        $routes = array();
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $value) {
            $a = 'admin/' . strtolower($slug);
            if (strpos($value->getPrefix(), $a) or strpos($value->getPrefix(), $a) === 0) {
                if ($value->getMethods()[0] == 'GET') {
                    $routes[$value->getPrefix()][] = ($value->getPath());
                }
            }
        }
        return collect($routes);
    }

    public static function url_page_name($url)
    {

        $permurl = BBmakeUrlPermission($url, '/');
        $ispage = AdminPages::where('url', $permurl)->orWhere('url', '/' . $permurl)->first();
        if ($ispage) return $ispage->title;
        return null;
    }

    public static function admin_url_is_page($url)
    {

        $permurl = BBmakeUrlPermission($url, '/');
        $ispage = AdminPages::where('url', $permurl)->orWhere('url', '/' . $permurl)->first();
        if ($ispage) return true;
        return false;
    }


    public static function getRolesByPage($id, $imploded = true)
    {
        $page = self::find($id);

        $page_roles = [];
        if ($page) {
            $parent = $page->parent;
            if (count($page->permission_role)) {
                foreach ($page->permission_role as $perm) {
                    if ($parent) {
                        if ($parent->permission_role()->where('role_id', $perm->role->id)->first()) {
                            $page_roles[] = $perm->role->slug;
                        }
                    } else {
                        $page_roles[] = $perm->role->slug;
                    }

                }

                if ($imploded) {
                    return implode(',', $page_roles);
                } else {
                    return $page_roles;
                }

            }
        }
        if ($imploded) {
            return null;
        } else {
            return [];
        }
    }

    public static function getAllowedTags($page, $imploded = true)
    {
        if ($page->parent) {
            $tags = [];
            $roles = Roles::where('slug', "!=", 'superadmin')->get();
            if (count($roles)) {
                foreach ($roles as $role) {
                    $parentPerm = $page->parent->permission_role()->where('role_id', $role->id)->first();
                    if ($parentPerm) {
                        $tags[] = $role->slug;
                    }
                }
            }

            if ($imploded) {
                return implode(',', $tags);
            } else {
                return $tags;
            }
        } else {
            return Roles::getRolesSeperetedWith();
        }
    }

    public static function checkAccess($page_id, $role_slug)
    {
        if ($role_slug == Roles::SUPERADMIN) return true;

        $page = self::find($page_id);
        $role = Roles::where('slug', $role_slug)->first();
        if ($page && $role) {
            $access = $page->permission_role()->where('role_id', $role->id)->first();
            if ($access) return true;
        }

        return false;
    }

    public function permission_role()
    {
        return $this->hasMany('Sahakavatar\User\Models\PermissionRole', 'page_id', 'id');
    }

    public static function PagesByModulesParent($module)
    {
        return self::where('module_id', $module->slug)->where('parent_id', 0)->get();
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $existingOne = AdminPages::where('url', $model->url)->first();
            if (!$existingOne) {
                $model->slug = uniqid();
                return $model;
            }

            return false;
        });
    }

    /**
     * @param $query
     */
    public function scopeMain($query)
    {
        return $query->where('parent_id', '=', '0');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Sahakavatar\Console\Models\AdminPages', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany('Sahakavatar\Console\Models\AdminPages', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AdminPages::class, 'parent_id', 'id')->with('children');
    }
}