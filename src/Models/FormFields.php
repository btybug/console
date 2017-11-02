<?php

namespace Btybug\Console\Models;

use Illuminate\Database\Eloquent\Model;

class FormFields extends Model
{
    protected $table = 'form_fields';
    protected $guarded = ['created_at'];
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

    public function field()
    {
        return $this->belongsTo(\Btybug\Console\Models\Fields::class, 'field_slug');
    }
}