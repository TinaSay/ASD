<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 06.02.18
 * Time: 11:03
 */

namespace app\modules\product\components\transport;

use Yii;
use yii\base\BaseObject;

/**
 * Class FileTransport
 *
 * @package app\modules\product\components\transport
 */
class FileTransport extends BaseObject implements ImportTransportInterface
{

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var string
     */
    public $path = '@app/modules/product/components/transport/data/';

    /**
     * @var bool
     */
    public $realMode = false;

    /**
     * @var \DOMDocument
     */
    protected $xml;

    /**
     * @var string|null
     */
    protected $binaryData;

    /**
     * @param $method
     * @param array $params
     *
     * @return bool|string
     */
    public function call($method, array $params)
    {
        $this->xml = null;
        $path = Yii::getAlias($this->path);
        $this->binaryData = null;
        $tmpFile = $path . $method . ($this->realMode ? '_' . md5(serialize($params)) : '') . '.xml';

        if (file_exists($tmpFile)) {

            if ($this->realMode && $method == 'GetFile') {
                $this->binaryData = file_get_contents($tmpFile);
            } else {
                $this->xml = new \DOMDocument();
                $this->xml->load($tmpFile);
            }

            return true;
        } else {
            $this->errors[] = 'File not found ' . $tmpFile;
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getBinaryData(): ?string
    {
        return $this->xml ? base64_decode($this->xml->getElementsByTagName('BinaryData')
            ->item(0)->textContent) : $this->binaryData;
    }

    /**
     * @return \DOMDocument|null
     */
    public function getXml(): ?\DOMDocument
    {
        return $this->xml;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

}