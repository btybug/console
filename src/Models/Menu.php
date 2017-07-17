<?php
/**
 * Created by PhpStorm.
 * User: Comp2
 * Date: 2/8/2017
 * Time: 1:24 PM
 */

namespace App\Modules\Console\Models;

use App\Modules\Modules\Models\AdminPages;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'demo_menus';

    protected $guarded = array('id');

    public function adminPage() {
        return $this->belongsTo('App\Modules\Modules\Models\AdminPages');
    }

    public function creator(){
        return $this->belongsTo('App\Modules\Users\User','creator_id','id');
    }

    public function items(){
        return $this->hasMany('App\Modules\Console\Models\MenuItems','menu_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(){
        return $this->belongsTo('App\Modules\Create\Models\MenuItems', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany('App\Modules\Create\Models\MenuItems', 'parent_id');
    }

    public static function registerFromAdminPages($pages,$type = 'plugin',$parent = null){
        if(count($pages)){
            foreach($pages as $page){
                $parentMenu = self::create([
                   'admin_page_id' => $page->id,
                   'module' => $page->module_id,
                   'name' => $page->title,
                   'url' => $page->url,
                   'type' => $type,
                   'parent_id' => $parent,
                ]);

                if(count($page->childs)){
                    self::registerFromAdminPages($page->childs,$type,$parentMenu->id);
                }
            }
        }

        return false;
    }

    public static function makeJson($items,$parent = true){
        $array = [];

        if(count($items)){
            foreach($items as $item){
                if($parent){
                    $array['menuitem'][$item->id] = [
                        'pagegroup' => $item->title,
                        'title' => $item->title,
                        'url' => $item->url,
                        'id' => $item->id,
                    ];

                    if(count($item->childs)){
                        $array['menuitem'][$item->id]['children'] = self::makeJson($item->childs,false);
                    }
                }else{
                    $array[$item->id] = [
                        'pagegroup' => $item->title,
                        'title' => $item->title,
                        'url' => $item->url,
                        'id' => $item->id,
                    ];

                    if(count($item->childs)){
                        $array[$item->id]['children'] = self::makeJson($item->childs,false);
                    }
                }
            }
        }

        return $array;
    }

    public static function saveFromJson($items,$menu,$role,$parent = 0)
    {
        if(count($items)){
            foreach($items as $item){
                $id = uniqid();
                $result =  MenuItems::create([
                    'id' => $id,
                    'menu_id' => $menu->id,
                    'parent_id' => $parent,
                    'page_id' => $item['id'],
                    'role_id' => $role->id,
                    'title' => $item['title'],
                    'url' => $item['url'],
                ]);

                if($result && isset($item['children'])){
                    self::saveFromJson($item['children'],$menu,$role,$id);
                }
            }
        }
    }
}