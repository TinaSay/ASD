<?php
namespace app\modules\lk\components\transport;

use Yii;
use yii\base\Model;

/**
 * Class FileTransport
 * @package app\modules\lk\components\transport
 */
class FileTransport extends Model implements ImportTransportInterfaceLk
{

    /**
     * @var string
     */
    public $path = '@app/modules/lk/components/transport/data/';

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

        if (file_exists($path . $method . ($this->realMode ? '_' . md5(serialize($params)) : '') . '.xml')) {

            if ($this->realMode && $method == 'GetFile') {
                $this->binaryData = file_get_contents($path . $method . ($this->realMode ? '_' . md5(serialize($params)) : '') . '.xml');
            } else {
                $this->xml = new \DOMDocument();
                $this->xml->load($path . $method . ($this->realMode ? '_' . md5(serialize($params)) : '') . '.xml');
            }

            return true;
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

}