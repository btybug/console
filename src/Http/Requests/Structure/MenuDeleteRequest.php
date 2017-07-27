<?php

/**
 * Created by PhpStorm.
 * User: Ara Arakelyan
 * Date: 7/19/2017
 * Time: 3:40 PM
 */

namespace Sahakavatar\Console\Http\Requests\Account;

use Sahakavatar\Cms\Http\Requests\Request;

class MenuDeleteRequest extends Request
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
                'id' => 'required|exists:demo_menus,id'
            ];
        }
        return [];
    }
}