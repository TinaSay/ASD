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
 * Class UsageSection
 * @package app\modules\product\models\fake
 */
class UsageSection extends Model
{
    /**
     * @var array|null
     */
    public $usage;

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
                    UsageSectionTemplateAdapter::class,
                ],
            ],*/
        ];
    }
}