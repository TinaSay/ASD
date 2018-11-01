<?php

namespace app\modules\rating;

use krok\system\components\backend\NameInterface;
use Yii;

/**
 * rating module definition class
 */
class Module extends \yii\base\Module implements NameInterface
{
    /**
     * @return string
     */
    public static function getName()
    {
        return Yii::t('system', 'Rating');
    }
}
