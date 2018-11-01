<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.07.18
 * Time: 14:28
 */

namespace app\modules\product\meta\adapters;

use app\modules\product\meta\CatalogConfigure;
use krok\meta\adapters\AdapterInterface;

/**
 * Class CatalogTemplateAdapter
 * @package app\modules\product\meta\adapters
 */
class CatalogTemplateAdapter extends AbstractTemplateAdapter implements AdapterInterface
{
    /**
     * @return string
     */
    static protected function getConfigure(): string
    {
        return CatalogConfigure::class;
    }
}