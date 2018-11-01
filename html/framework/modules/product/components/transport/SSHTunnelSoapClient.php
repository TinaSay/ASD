<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 06.02.18
 * Time: 11:13
 */

namespace app\modules\product\components\transport;

use yii\base\Exception;

/**
 * call SOAP via SSH tunnel
 *
 * Class ProxySoapClient
 *
 * @package app\modules\product\components\transport
 */
class SSHTunnelSoapClient extends \SoapClient
{
    /**
     * @var string
     */
    public $proxyHost = '127.0.0.1';

    /**
     * @var string
     */
    public $proxyPort = '1080';

    /**
     * ProxySoapClient constructor.
     *
     * @param mixed $wsdl
     * @param array|null $options
     */
    public function __construct($wsdl, array $options = null)
    {
        if (isset($options['proxy_host'])) {
            $this->proxyHost = $options['proxy_host'];
            unset($options['proxy_host']);
        }
        if (isset($options['proxy_port'])) {
            $this->proxyPort = $options['proxy_port'];
            unset($options['proxy_port']);
        }

        parent::__construct($wsdl, $options);
    }

    /**
     * @param $url
     * @param $data
     * @param $action
     *
     * @return string
     * @throws Exception
     */
    public function callCurl($url, $data, $action)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);

        // If you need to handle headers like cookies, session id, etc. you will have
        // to set them here manually
        $headers = ["Content-Type: text/xml", 'SOAPAction: "' . $action . '"'];

        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($handle, CURLOPT_HEADER, true);

        curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($handle, CURLOPT_PROXY, $this->proxyHost . ':' . $this->proxyPort); // 1080 is your -D parameter

        $response = curl_exec($handle);

        $errno = curl_errno($handle);
        if ($errno) {
            throw new Exception(curl_error($handle), $errno);
        }

        curl_close($handle);

        if ($response) {
            list(, $content) = explode("\r\n\r\n", $response, 2);

            return $content;
        }

        return '';
    }

    /**
     * @param string $request
     * @param string $location
     * @param string $action
     * @param int $version
     * @param int $one_way
     *
     * @return string
     */
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        /*
         *
         print $action . PHP_EOL .
            "Request: " . $request . PHP_EOL;
        */
        return $this->callCurl($location, $request, $action);
    }
}