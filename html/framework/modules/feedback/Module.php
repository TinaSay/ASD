<?php

namespace app\modules\feedback;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * auth module definition class
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
    public $defaultRoute = 'default';

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
        return Yii::t('system', 'Feedback');
    }
}
