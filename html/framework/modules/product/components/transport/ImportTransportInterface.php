<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 06.02.18
 * Time: 10:46
 */

namespace app\modules\product\components\transport;

/**
 * Interface ImportTransportInterface
 *
 * @package app\modules\product\components\transport
 */
interface ImportTransportInterface
{
    /**
     * @param $method
     * @param array $params
     *
     * @return bool
     */
    public function call($method, array $params);

    /**
     * @return null|string
     */
    public function getBinaryData(): ?string;

    /**
     * @return \DOMDocument|null
     */
    public function getXml(): ?\DOMDocument;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @return array
     */
    public function getErrors(): array;
}