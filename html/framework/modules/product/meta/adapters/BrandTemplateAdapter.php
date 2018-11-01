<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.07.18
 * Time: 14:28
 */

namespace app\modules\product\meta\adapters;

use app\modules\product\meta\BrandConfigure;
use krok\meta\adapters\AdapterInterface;

/**
 * Class BrandTemplateAdapter
 * @package app\modules\product\meta\adapters
 */
class BrandTemplateAdapter extends AbstractTemplateAdapter implements AdapterInterface
{
    /**
     * @return string
     */
    static protected function getConfigure(): string
    {
        return BrandConfigure::class;
    }
}