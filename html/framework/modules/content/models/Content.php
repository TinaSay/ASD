<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 18.04.18
 * Time: 11:01
 */

namespace app\modules\content\models;

use app\modules\banner\models\Banner;
use app\modules\meta\adapters\OpenGraphAdapter;
use app\modules\sked\models\Sked;
use krok\meta\behaviors\MetaBehavior;
use tina\metatag\behaviors\MetatagBehavior;
use tina\metatag\models\Metatag;
use voskobovich\behaviors\ManyToManyBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Content
 *
 * @package app\modules\content\models
 * @property integer $bannerPosition
 * @property string $bannerColor
 * @property integer $productSet
 * @property integer $renderForm
 *
 * @property ContentSked[] $contentSked
 * @property Sked[] $skeds
 * @property ContentBanner[] $contentBanner
 * @property Banner[] $banners
 */
class Content extends \krok\content\models\Content
{
    const BANNER_POSITION_TOP = 1;
    const BANNER_POSITION_AFTER_TEXT = 2;
    const BANNER_POSITION_AFTER_SKED = 3;

    const BANNER_COLOR_YELLOW = 'yellow';
    const BANNER_COLOR_BLUE = 'blue';

    const SHOW_PRODUCT_SET_WIDGET_YES = 1;
    const SHOW_PRODUCT_SET_WIDGET_NO = 0;

    const RENDER_FORM_NO = 0;
    const RENDER_FORM_SUBSCRIBE = 1;
    const RENDER_FORM_FEEDBACK = 2;


    /**
     * @var Metatag
     */
    public $meta;

    /**
     * @return array
     */
    public function behaviors()
    {
        return parent::behaviors() + [
                'MetatagBehavior' => [
                    'class' => MetatagBehavior::class,
                    'metaAttribute' => 'meta',
                ],
                'ManyToManyBehavior' => [
                    'class' => ManyToManyBehavior::class,
                    'relations' => [
                        'skedId' => 'skeds',
                        'bannerId' => 'banners',
                    ],
                ],
                'MetaBehavior' => [
                    'class' => MetaBehavior::class,
                    'adapters' => [
                        OpenGraphAdapter::class,
                    ],
                ],
            ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['skedId', 'bannerId'], 'each', 'rule' => ['integer']],
            [['bannerPosition', 'productSet', 'renderForm'], 'integer'],
            [['bannerColor'], 'string', 'max' => 7],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
                'skedId' => 'Списки',
                'bannerPosition' => 'Расположение баннеров',
                'bannerColor' => 'Цвет баннеров',
                'productSet' => 'Наборы',
                'renderForm' => 'Форма',
                'bannerId ' => 'Баннеры',
            'hidden ' => 'Заблокировано',
        ]);
    }

    /**
     * @return array
     */
    public static function getBannerPositionList()
    {
        return [
            self::BANNER_POSITION_TOP => 'В начале страницы',
            self::BANNER_POSITION_AFTER_TEXT => 'После текста',
            self::BANNER_POSITION_AFTER_SKED => 'После список',
        ];
    }

    /**
     * @return string|null
     */
    public function getBannerPosition()
    {
        return ArrayHelper::getValue($this->getBannerPositionList(), $this->bannerPosition);
    }

    /**
     * @return array
     */
    public static function getBannerColorList()
    {
        return [
            self::BANNER_COLOR_BLUE => 'Синий',
            self::BANNER_COLOR_YELLOW => 'Желтый',
        ];
    }

    /**
     * @return string|null
     */
    public function getBannerColor()
    {
        return ArrayHelper::getValue($this->getBannerColorList(), $this->bannerColor);
    }

    /**
     * @return array
     */
    public static function getProductSetList()
    {
        return [
            self::SHOW_PRODUCT_SET_WIDGET_NO => 'Нет',
            self::SHOW_PRODUCT_SET_WIDGET_YES => 'Да',
        ];
    }

    /**
     * @return mixed
     */
    public function getProductSet()
    {
        return ArrayHelper::getValue($this->getProductSetList(), $this->productSet);
    }

    /**
     * @return array
     */
    public static function getRenderFormList()
    {
        return [
            self::RENDER_FORM_NO => 'Нет',
            self::RENDER_FORM_SUBSCRIBE => 'Подписка на новости',
            self::RENDER_FORM_FEEDBACK => 'Обратная связь',
        ];
    }

    /**]
     * @return string|null
     */
    public function getRenderForm()
    {
        return ArrayHelper::getValue($this->getRenderFormList(), $this->renderForm);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentSked()
    {
        return $this->hasMany(ContentSked::class, ['contentId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSkeds()
    {
        return $this->hasMany(Sked::class, ['id' => 'skedId'])
            ->via('contentSked');
    }

    /**
     * @return array
     */
    public function getSkedList()
    {
        return ArrayHelper::map(Sked::findAll(['hidden' => Sked::HIDDEN_NO]), 'id', 'title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentBanner()
    {
        return $this->hasMany(ContentBanner::class, ['contentId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banner::class, ['id' => 'bannerId'])
            ->via('contentBanner');
    }

    /**
     * @return array
     */
    public function getBannerList()
    {
        return ArrayHelper::map(Banner::findAll(['hidden' => Banner::HIDDEN_NO]), 'id', 'title');
    }

    /**
     * @param $bannerIds
     */
    public function saveBannerRelation($bannerIds)
    {
        ContentBanner::deleteAll(['contentId' => $this->id]);
        if (is_array($bannerIds) && count($bannerIds) > 0) {
            foreach ($bannerIds as $bannerId) {
                (new ContentBanner([
                    'contentId' => $this->id,
                    'bannerId' => $bannerId,
                ]))->save();
            }
        }
    }

    /**
     * @return array
     */
    public function getSkedIds()
    {
        return ArrayHelper::getColumn($this->skeds, 'id');
    }

    public function getBannerIds()
    {
        return ArrayHelper::getColumn($this->banners, 'id');
    }

}
