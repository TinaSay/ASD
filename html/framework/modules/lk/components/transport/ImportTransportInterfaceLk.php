<?php
namespace app\modules\lk\components\transport;

/**
 * Interface ImportTransportInterfaceLk
 * @package app\modules\lk\components\transport
 */
interface ImportTransportInterfaceLk
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

    public function getFilePdf();

    /**
     * @return \DOMDocument|null
     */
    public function getXml(): ?\DOMDocument;
}