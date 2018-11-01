<?php

namespace app\modules\record;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * Record module definition class
 */
class Module extends \yii\base\Module implements NameInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = null;

    /**
     * @var string
     */
    public $defaultRoute = 'record';

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
        return Yii::t('system', 'Record');
    }
}
