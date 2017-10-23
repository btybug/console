<?php

namespace Sahakavatar\Console\Services;

use Sahakavatar\Cms\Models\Themes\Themes;
use Sahakavatar\Cms\Services\GeneralService;

/**
 * Class ThemeService
 * @package Sahakavatar\Console\Services
 */
class ThemeService extends GeneralService
{

    /**
     * @var
     */
    private $current;
    /**
     * @var
     */
    private $result;

    public function getCurrent($themes, $p)
    {
        if (count($themes) && !$p) {
            $curentTheme = $themes[0];
        }
        if ($p) {
            $curentTheme = Themes::find($p);
        }
    }
}