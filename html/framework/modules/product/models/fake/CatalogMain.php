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
 * Class CatalogMain
 * @package app\modules\product\models\fake
 */
class CatalogMain extends Model
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
                    CatalogTemplateAdapter::class,
                ],
            ],*/
        ];
    }
}