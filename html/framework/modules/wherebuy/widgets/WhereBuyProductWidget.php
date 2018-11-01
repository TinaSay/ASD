<?php

namespace app\modules\wherebuy\widgets;

use app\modules\wherebuy\models\Wherebuy;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Виджет для вывода баннеров
 *
 * @property string $type
 * @property string $bannerLimit
 * @property string $pageType
 */
class WhereBuyProductWidget extends Widget
{
    /**
     * @var Wherebuy[]
     */
    protected $list = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $key = [
            __CLASS__,
            __METHOD__,
            Yii::$app->language,
        ];

        $dependency = new TagDependency([
            'tags' => [
                Wherebuy::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {
            $this->list = Wherebuy::find()
                ->showInProduct()
                ->active()
                ->language()
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        shuffle($this->list);
        $list = array_splice($this->list, 0, 2);

        return $this->render('product', [
            'list' => $list,
        ]);
    }
}
