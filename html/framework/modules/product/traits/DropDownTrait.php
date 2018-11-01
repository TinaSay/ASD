<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 05.02.18
 * Time: 14:52
 */

namespace app\modules\product\traits;

/**
 * Trait DropDownTrait
 *
 * @package app\modules\product\traits
 */
trait DropDownTrait
{
    /**
     * @param null|int $hidden
     *
     * @return array
     */
    public static function asDropDown(?int $hidden): array
    {
        return static::find()->select(['title', 'id'])
            ->filterWhere(['hidden' => $hidden])
            ->orderBy(['title' => SORT_ASC])
            ->indexBy('id')
            ->column();
    }
}