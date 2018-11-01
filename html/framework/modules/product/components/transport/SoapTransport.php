<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 06.02.18
 * Time: 10:50
 */

namespace app\modules\product\components\transport;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\log\Logger;

/**
 * Class SoapTransport
 *
 * @package app\modules\product\components\transport
 */
class SoapTransport extends BaseObject implements ImportTransportInterface
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var string|null
     */
    public $login;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var string
     */
    public $url;

    /**
     * SOAP calls is proxied
     *
     * @see http://php.net/manual/ru/soapclient.soapclient.php
     *
     * @var array|null
     */
    public $proxy;

    /**
     * SOAP calls proxied by SSH tunnel
     *
     * @var array|null
     */
    public $proxySsh;

    /**
     * @var int
     */
    public $queryInterval = 200000;

    /**
     * @var \SoapClient
     *
     * @method GetProduct($ProductUID)
     * @method GetReferences()
     * @method GetFile($data)
     */
    protected $client;

    /**
     * @var null|bool|string
     */
    protected $response;

    /**
     * @var \DOMDocument|null
     */
    protected $xml;

    /**
     * @throws InvalidConfigException
     */
    protected function initClient()
    {
        if (!$this->url) {
            throw new InvalidConfigException('URL for SOAP calls must be set.');
        }
        if (!$this->client) {
            $options = [
                "trace" => 1,
                "soap_version" => SOAP_1_2,
                "cache_wsdl" => WSDL_CACHE_MEMORY,
            ];
            if ($this->login) {
                $options['login'] = $this->login;
                $options['password'] = $this->password;
            }

            if ($this->proxy) {
                $options['proxy_host'] = $this->proxy['proxy_host'];
                $options['proxy_port'] = $this->proxy['proxy_port'];
                $options['stream_context'] = stream_context_create(
                    [
                        'http' => [
                            'proxy' => 'tcp://' . $this->proxy['proxy_host'] . ':' . $this->proxy['proxy_port'],
                            'request_fulluri' => true,
                        ],
                    ]
                );
                // load schema from local file
                $this->url = __DIR__ . '/data/wsSiteDataExport.wsdl';
            }

            if ($this->proxySsh) {
                $options = array_merge($options, $this->proxySsh);

                $this->client = new SSHTunnelSoapClient(__DIR__ . '/data/wsSiteDataExport.wsdl', $options);
            } else {
                $this->client = new \SoapClient($this->url, $options);
            }

        }
    }

    /**
     * @param $method
     * @param array $params
     *
     * @return bool
     */
    public function call($method, array $params)
    {
        $this->response = null;
        $this->xml = null;
        $this->initClient();

        usleep($this->queryInterval);

        try {
            $return = $this->client->__soapCall($method, [$params]);

            if ($return && isset($return->return) && isset($return->return->BinaryData)) {
                $this->response = $return->return->BinaryData;

                if (YII_DEBUG) {
                    $fh = fopen(Yii::getAlias('@public/' . $method . '_' . md5(serialize($params)) . '.xml'), 'wb');
                    fwrite($fh, $this->response);
                    fclose($fh);
                }

                return true;
            }

        } catch (\Exception $e) {
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            $this->errors[] = $e->getMessage();
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getBinaryData(): ?string
    {
        return $this->response;
    }

    /**
     * @return \DOMDocument|null
     */
    public function getXml(): ?\DOMDocument
    {
        if ($this->response && !$this->xml) {
            $this->xml = new \DOMDocument();
            $this->xml->loadXML($this->response);
        }

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