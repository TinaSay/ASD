<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.12.17
 * Time: 11:39
 */

namespace app\modules\news\models;

use elfuvo\menu\common\MenuItemDto;
use elfuvo\menu\interfaces\MenuInterface;
use elfuvo\menu\models\Menu;
use Yii;

class NewsMenu implements MenuInterface
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        $list = [];
        $groups = NewsGroup::find()->where(['hidden' => NewsGroup::HIDDEN_NO])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        foreach ($groups as $group) {
            array_push($list, new MenuItemDto(
                'news/news/index',
                $group['title'],
                'id=' . $group['id']
            ));
        }

        array_push($list, new MenuItemDto(
            'news/news/view',
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
        return 'news';
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return Yii::t('system', 'News');
    }
}