<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 10:14
 */

namespace app\modules\product\meta;

/**
 * Interface MetaTemplateInterface
 * @package app\modules\product\meta
 */
interface MetaTemplateInterface
{
    /**
     * @return array
     */
    public function getModelTemplateAttributes(): array;
}