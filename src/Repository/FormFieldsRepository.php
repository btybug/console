<?php
/**
 * Created by PhpStorm.
 * User: Edo
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Btybug\Console\Repository;

use Btybug\Cms\Repositories\GeneralRepository;
use Btybug\Console\Models\FormFields;

class FormFieldsRepository extends GeneralRepository
{
    public function model()
    {
        return new FormFields();
    }
}