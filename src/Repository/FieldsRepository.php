<?php
/**
 * Created by PhpStorm.
 * User: Edo
 * Date: 8/8/2016
 * Time: 1:31 PM
 */

namespace Btybug\Console\Repository;

use Btybug\btybug\Repositories\GeneralRepository;
use Btybug\Console\Models\Fields;

/**
 * Class FieldsRepository
 * @package Btybug\Console\Repository
 */
class FieldsRepository extends GeneralRepository
{

    const ACTIVE = 1;

    public function getByTableNameAndActive($table_name)
    {
        return $this->model()->where('table_name', $table_name)->where('status', self::ACTIVE)->get();
    }

    /**
     * @return Fields
     */
    public function model()
    {
        return new Fields();
    }

    public function getByTableNameActiveAndAvailablity($table_name)
    {
        return $this->model()->where('table_name', $table_name)->where('status', self::ACTIVE)->where('available_for_users', '!=', 0)->get();
    }
}