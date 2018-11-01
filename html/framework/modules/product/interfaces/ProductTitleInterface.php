<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 15.03.18
 * Time: 15:16
 */

namespace app\modules\product\interfaces;

/**
 * Interface ProductTitleInterface
 *
 * @package app\modules\product\interfaces
 */
interface ProductTitleInterface
{
    /**
     * @param null|int $id
     * @param null|string $path
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string;
}