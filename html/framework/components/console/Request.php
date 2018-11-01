<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 26.09.17
 * Time: 15:44
 */

namespace app\components\console;

/**
 * Class Request
 *
 * @package app\components\console
 */
class Request extends \yii\console\Request
{
    public $enableCsrfCookie = false;

    /**
     * @var string
     */
    public $pathInfo = '';

    /**
     * Returns GET parameter with a given name. If name isn't specified, returns an array of all GET parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     *
     * @return array|mixed
     */
    public function get($name = null, $defaultValue = null)
    {
        return $defaultValue;
    }

    /**
     * @return string
     */
    public function getUserIP()
    {
        return '0.0.0.0';
    }
}