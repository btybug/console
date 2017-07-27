<?php
/**
 * Created by PhpStorm.
 * User: Comp2
 * Date: 2/8/2017
 * Time: 1:24 PM
 */

namespace Sahakavatar\Console\Models;

use Sahakavatar\Console\Models\AdminPages;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = 'demo_menu_items';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = array('id','menu_id','role_id','parent_id','page_id','title','url','icon','sort','created_at','updated_at');

    public function menu(){
        return $this->belongsTo('Sahakavatar\Console\Models\Menu','menu_id','id');
    }

    public function childs(){
        return $this->hasMany('Sahakavatar\Console\Models\MenuItems','parent_id','id');
    }

    public static function registerFromAdminPages($pages,$type = 'plugin',$parent = null){
        if(count($pages)){
            foreach($pages as $page){
                $parnetMenu = self::create([
                   'admin_page_id' => $page->id,
                   'module' => $page->module_id,
                   'name' => $page->title,
                   'url' => $page->url,
                   'type' => $type,
                   'parent_id' => $parent,
                ]);

                if(count($page->childs)){
                    self::registerFromAdminPages($page->childs,$type,$parnetMenu->id);
                }
            }
        }

        return false;
    }
}