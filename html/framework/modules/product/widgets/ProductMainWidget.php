<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 20.02.18
 * Time: 18:08
 */

namespace app\modules\product\widgets;

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\ProductUsageRel;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;
use yii\db\Expression;

class ProductMainWidget extends Widget
{

    /**
     * @var int
     */
    protected $limit = 3;

    /**
     * @var array
     */
    protected $list = [];

    /**
     * @var array
     */
    protected $usages = [];

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
                ProductBrand::class,
                ProductPromo::class,
                ProductUsage::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $this->usages = ProductUsage::find()->select([
                ProductUsage::tableName() . '.[[id]]',
                ProductUsage::tableName() . '.[[title]]',
            ])->where([
                ProductUsage::tableName() . '.[[hidden]]' => ProductUsage::HIDDEN_NO,
            ])->joinWith('productUsageRel', false, 'INNER JOIN')
                ->asArray()
                ->indexBy('id')
                ->all();
            $this->list = [];
            if ($this->usages) {
                foreach ($this->usages as $usageId => $usage) {
                    $tmp = Product::find()->active()
                        ->joinWith('promos', true, 'INNER JOIN')
                        ->joinWith('brand', true)
                        ->joinWith('productUsageRel', false, 'INNER JOIN')
                        ->andWhere([ProductUsageRel::tableName() . '.[[usageId]]' => $usage['id']])
                        ->indexBy('id')
                        ->orderBy(new Expression('RAND()'))
                        ->limit($this->limit)
                        ->all();
                    if ($tmp) {
                        $this->list[$usage['id']] = $tmp;
                    } else {
                        unset($this->usages[$usageId]);
                    }
                }
                unset($tmp);
            }

            $data = [$this->list, $this->usages];

            Yii::$app->cache->set($key, $data, 600, $dependency);
        } else {
            list($this->list, $this->usages) = $data;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        foreach ($this->list as $arr) {
            shuffle($arr);
        }

        return $this->render('main', ['list' => $this->list, 'usages' => $this->usages]);
    }
}