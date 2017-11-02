<?php

namespace Btybug\Console\Models;

use Illuminate\Database\Eloquent\Model;

class FormEntries extends Model
{
    public $dontFlash = ['file'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'form_entries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'form_id', 'ip', 'data'];
    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function form()
    {
        return $this->belongsTo(\Btybug\Console\Models\Forms::class, 'form_id');
    }

    public function user()
    {
        return $this->belongsTo('Sahakavatar\User\User', 'user_id');
    }
}
