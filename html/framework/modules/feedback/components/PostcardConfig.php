<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.02.18
 * Time: 17:52
 */

namespace app\modules\feedback\components;

use Yii;

class PostcardConfig
{
    /**
     * @param string $path
     *
     * @return bool
     */
    protected static function prepareDir($path)
    {
        if (is_dir($path)) {
            return true;
        } else {
            return mkdir($path, '0755', true);
        }
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public static function getFullName($filename)
    {
        $appealConfigDir = Yii::getAlias(Yii::$app->params['smtpConfigDir']);
        self::prepareDir($appealConfigDir);

        return $appealConfigDir . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Загрузка данных конфига. Параметры: имя файла и параметры по умолчанию.
     *
     * @param $filename
     * @param $default array
     *
     * @return mixed
     */
    public static function load($filename, $default)
    {
        $fullName = self::getFullName($filename);
        try {
            $settings = unserialize(base64_decode(file_get_contents($fullName)));

            return $settings;
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Сохранение данных конфига
     *
     * @param $filename
     * @param $data
     *
     * @return mixed
     */
    public static function save($filename, $data = [])
    {
        $fullName = self::getFullName($filename);
        $fileData = base64_encode(serialize($data));
        $length = file_put_contents($fullName, $fileData);

        return strlen($fileData) === $length;
    }
}
