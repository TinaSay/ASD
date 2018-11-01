<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 27.06.18
 * Time: 10:41
 */

namespace app\modules\metaRegister\interfaces;

/**
 * Interface ConfigurableInterface
 *
 * @package app\modules\metaRegister\interfaces
 */
interface ConfigurableInterface
{
    /**
     * @return array
     */
    public function metaTags(): array;

    /**
     * @return string
     */
    public function getType(): string;
}