<?php

namespace app\modules\brand\widget\brand;

use app\modules\brand\models\Brand;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Виджет для вывода брендов
 *
 * @property string $type
 * @property string $bannerLimit
 * @property string $pageType
 */
class BrandWidget extends Widget
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $limit = 7;

    /**
     * @var Brand[]
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
                Brand::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {
            $this->list = Brand::find()
                ->where(['blocked' => Brand::BLOCKED_NO])
                ->orderBy(['position' => SORT_ASC])
                ->limit($this->limit)
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('homeWidget', [
            'brands' => $this->list,
        ]);
    }
}
