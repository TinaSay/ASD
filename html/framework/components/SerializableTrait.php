<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.07.18
 * Time: 15:01
 */

namespace app\components;

/**
 * Trait SerializableTrait
 *
 * @package app\components
 */
trait SerializableTrait
{
    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->adapters);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->adapters = unserialize($serialized);
    }
}
