<?php

namespace Btybug\Console\Http\Requests\Structure;

use Btybug\Cms\Http\Requests\Request;

class PageEditRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return [
                'id' => 'exists:admin_pages,id',
                'title' => 'required',
                'url' => 'sometimes|unique:admin_pages,url,' . $this->id
            ];
        }
        return [];
    }
}