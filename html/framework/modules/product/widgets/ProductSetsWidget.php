<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 9:28
 */

namespace app\modules\product\widgets;

use app\modules\product\models\Product;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductSet;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

class ProductSetsWidget extends Widget
{
    /**
     * @var int
     */
    public $limit = 4;

    /**
     * @var int|null
     */
    public $exclude;

    /**
     * @var ProductSet[]
     */
    protected $list = [];

    /**
     * init widget
     */
    public function init()
    {
        parent::init();

        $key = [
            __CLASS__,
            __METHOD__,
            $this->limit,
        ];

        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductSet::class,
                ProductPromo::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {

            $this->list = ProductSet::find()
                ->where([
                    ProductSet::tableName() . '.[[hidden]]' => ProductSet::HIDDEN_NO,
                ])->indexBy('id')
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if ($this->exclude && isset($this->list[$this->exclude])) {
            unset($this->list[$this->exclude]);
        }
        shuffle($this->list);
        $list = array_slice($this->list, 0, $this->limit);
        $this->list = [];

        return $this->render('sets', ['list' => $list, 'exclude' => $this->exclude]);
    }
}