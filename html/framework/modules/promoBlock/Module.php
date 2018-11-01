<?php

namespace app\modules\promoBlock;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * promoBlock module definition class
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
     * @var string
     */
    public $defaultRoute = 'promo-block';

    /**
     * @return string
     */
    public static function getName()
    {
        return Yii::t('system', 'Promo Block');
    }
}
