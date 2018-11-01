<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.05.18
 * Time: 10:52
 */

namespace app\modules\feedback\helpers;

use app\modules\feedback\models\FeedbackSettings;
use Yii;
use yii\base\InvalidConfigException;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * Class FeedbackSettingsHelper
 *
 * @package modules\feedback\helpers
 */
class FeedbackSettingsHelper
{
    /**
     * @var array
     */
    static private $_config = [];

    /**
     * @return array
     */
    public static function listing()
    {
        if (self::$_config == []) {

            $key = ['feedback.settings'];

            $dependency = new TagDependency([
                'tags' => FeedbackSettings::class,
            ]);

            if ((self::$_config = Yii::$app->cache->get($key)) === false) {
                self::$_config = ArrayHelper::index(FeedbackSettings::find()->all(), 'name');

                Yii::$app->cache->set($key, self::$_config, null, $dependency);
            }
        }

        return self::$_config;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function has($name)
    {
        return ArrayHelper::keyExists($name, self::listing());
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public static function get($name)
    {
        if (self::has($name)) {
            return ArrayHelper::getValue(self::listing(), $name);
        } else {
            throw new InvalidConfigException('Configuration not found');
        }
    }

    /**
     * @param $name
     *
     * @return string|null
     */
    public static function getValue($name)
    {
        if (self::has($name)) {
            return ArrayHelper::getValue(self::listing(), [$name, 'value']);
        }

        return null;
    }
}