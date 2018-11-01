<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.12.17
 * Time: 11:39
 */

namespace app\modules\advice\models;

use elfuvo\menu\common\MenuItemDto;
use elfuvo\menu\interfaces\MenuInterface;
use elfuvo\menu\models\Menu;
use Yii;

class AdviceMenu implements MenuInterface
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        $list = [];
        $groups = adviceGroup::find()->where(['hidden' => adviceGroup::HIDDEN_NO])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        foreach ($groups as $group) {
            array_push($list, new MenuItemDto(
                'advice/advice/index',
                $group['title'],
                'id=' . $group['id']
            ));
        }

        array_push($list, new MenuItemDto(
            'advice/advice/view',
            'Карточка новости',
            '',
            '<id:\d+>',
            Menu::TYPE_BREADCRUMB
        ));

        return $list;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'advice';
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return Yii::t('system', 'advice');
    }
}