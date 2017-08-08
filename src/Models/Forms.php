<?php
/**
 * Created by PhpStorm.
 * User: shojan
 * Date: 11/27/2016
 * Time: 6:03 AM
 */

namespace Sahakavatar\Console\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Forms
 * @package Sahakavatar\Modules\Models\Models
 */
class Forms extends Model
{
    /**
     * @var string
     */
    public static $form_path = 'resources' . DS . 'views' . DS . 'forms' . DS;
    /**
     * @var string
     */
    public static $form_file_ext = '.blade.php';
    public $fields;
    public $formData;
    public $collected;
    /**
     * @var string
     */
    protected $table = 'forms';
    /**
     * @var array
     */
    protected $guarded = ['id'];
    protected $casts = [
        'settings' => 'json'
    ];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function fields()
    {
        return $this->belongsToMany('\App\Models\Fields', 'form_fields', 'form_id', 'field_slug');
    }

    public function entries()
    {
        return $this->hasMany('\App\Models\FormEntries', 'form_id', 'id');
    }
}