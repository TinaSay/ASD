<?php

namespace app\modules\metaRegister;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * metaRegister module definition class
 */
class Module extends \yii\base\Module implements NameInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = null;

    /**
     * @return string
     */
    public static function getName()
    {
        return Yii::t('system', 'Meta Register');
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
