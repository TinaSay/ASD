<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.07.18
 * Time: 15:29
 */

namespace app\modules\product\models\fake;

use yii\base\Model;

/**
 * Class UsageMain
 * @package app\modules\product\models\fake
 */
class UsageMain extends Model
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            /*'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    UsageMainTemplateAdapter::class,
                ],
            ],*/
        ];
    }
}