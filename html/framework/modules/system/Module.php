<?php

namespace app\modules\system;

use app\modules\system\components\backend\NameInterface;
use Yii;

/**
 * Class Module
 *
 * @package krok\system
 */
class Module extends \yii\base\Module implements NameInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return Yii::t('system', 'System');
    }
}
