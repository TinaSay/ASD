<?php

namespace app\modules\wherebuy;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * wherebuy module definition class
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
        return Yii::t('system', 'Wherebuy');
    }
}
