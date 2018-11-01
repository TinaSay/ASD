<?php
namespace app\modules\lk\components\transport;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use app\modules\product\components\transport\SSHTunnelSoapClient;
use yii\log\Logger;

/**
 * Class SoapTransportLk
 * @package app\modules\lk\components\transport
 */
class SoapTransportLk extends BaseObject implements ImportTransportInterfaceLk
{
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

    protected $responseAll;

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
            ini_set("soap.wsdl_cache_enabled", 0);
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
                $this->responseAll = $return->return;

                /*if (YII_DEBUG) {
                    $fh = fopen(\Yii::getAlias('@public/' . $method . '_' . md5(serialize($params)) . '.xml'), 'wb');
                    fwrite($fh, $this->response);
                    fclose($fh);
                }*/

                return true;
            }
        } catch(\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
/*
        } catch (\Exception $e) {
            var_dump($method);
            var_dump($params);
            var_dump($e->getCode());
            var_dump($e->getMessage());
            \Yii::getLogger()->log(
                $method . PHP_EOL .
                print_r($params, true) . PHP_EOL .
                $e->getCode() . ' ' .
                $e->getMessage(), Logger::LEVEL_ERROR);
        }
*/
        return false;
    }

    /**
     * @return null|string
     */
    public function getBinaryData(): ?string
    {
        return $this->response;
    }

    public function getFilePdf()
    {
        return $this->responseAll;
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
}