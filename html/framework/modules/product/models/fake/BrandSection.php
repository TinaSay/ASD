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
 * Class BrandSection
 * @package app\modules\product\models\fake
 */
class BrandSection extends Model
{
    /**
     * @var array|null
     */
    public $brand;

    /**
     * @var array|null
     */
    public $section;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            /*'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    BrandSectionTemplateAdapter::class,
                ],
            ],*/
        ];
    }
}