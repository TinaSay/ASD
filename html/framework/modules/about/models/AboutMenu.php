<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.12.17
 * Time: 11:39
 */

namespace app\modules\about\models;

use elfuvo\menu\common\MenuItemDto;
use elfuvo\menu\interfaces\MenuInterface;
use Yii;

/**
 * Class AboutMenu
 *
 * @package app\modules\about\models
 */
class AboutMenu implements MenuInterface
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        $list = [];
        $modelList = About::find()->where([
            'blocked' => About::BLOCKED_NO,
        ])->orderBy(['title' => SORT_ASC])
            ->asArray()->all();

        foreach ($modelList as $model) {
            if (empty($list)) {
                array_push($list, new MenuItemDto(
                    'about/default/index',
                    'Компания - главная страница'
                ));
            }
            array_push($list, new MenuItemDto(
                'about/default/view',
                $model['title'],
                'id=' . $model['id']
            ));
        }

        return $list;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'about';
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return Yii::t('system', 'About company');
    }
}