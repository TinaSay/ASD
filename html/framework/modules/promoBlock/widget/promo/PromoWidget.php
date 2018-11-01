<?php

namespace app\modules\promoBlock\widget\promo;

use app\modules\promoBlock\models\PromoBlock;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Виджет для вывода промоблока
 *
 * @property string $year
 */
class PromoWidget extends Widget
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var PromoBlock[]
     */
    protected $list;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $key = [
            __METHOD__,
            __FILE__,
            __LINE__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                PromoBlock::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {
            $this->list = PromoBlock::find()
                ->where(['hidden' => PromoBlock::PROMO_HIDDEN_NO])
                ->orderBy(['position' => SORT_ASC])
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('slider', ['promos' => $this->list]);
    }
}
