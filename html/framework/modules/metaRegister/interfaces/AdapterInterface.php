<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 26.06.18
 * Time: 10:19
 */

namespace app\modules\metaRegister\interfaces;

/**
 * Interface ConfigurableInterface
 */
interface AdapterInterface
{
    /**
     * @return bool
     */
    public function hasDefinedParams(): bool;

    /**
     * @return mixed
     */
    public function createMetaData();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function updateMetaData($id);

    /**
     * @return string
     */
    public function getType(): string;
}
