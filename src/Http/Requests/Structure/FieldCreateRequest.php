<?php
namespace Sahakavatar\Console\Http\Requests\Structure;

use Sahakavatar\Cms\Http\Requests\Request;

class FieldCreateRequest extends Request
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
                'name' => "required",
                'table_name' => "required",
                'column_name' => "required",
                'unit' => 'required'
            ];
        }
        return [];
    }
}