<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 12:45
 */

namespace app\modules\product\widgets;

use app\modules\product\models\Product;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductSectionRel;
use app\modules\product\models\ProductUsageRel;
use app\modules\product\models\search\ProductCatalogSearch;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

class ProductCatalogMenuWidget extends Widget
{

    /**
     * @var int
     */
    public $brandId;

    /**
     * @var int
     */
    public $usageId;

    /**
     * @var int
     */
    public $promoId;

    /**
     * @var ProductPromo[]
     */
    protected $list;

    /**
     * init widget
     */
    public function init()
    {
        parent::init();

        $key = [
            __CLASS__,
            __METHOD__,
            $this->brandId,
            $this->usageId,
        ];


        $dependency = new TagDependency([
            'tags' => [
                ProductPromo::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {

            $query = ProductPromo::find()->where([
                ProductPromo::tableName() . '.[[hidden]]' => ProductPromo::HIDDEN_NO,
            ])->orderBy([
                ProductPromo::tableName() . '.[[position]]' => SORT_ASC,
            ]);

            if ($this->brandId) {
                $query->joinWith('products', false . 'INNER JOIN')
                    ->andWhere([
                        Product::tableName() . '.[[brandId]]' => $this->brandId,
                    ]);
            }
            $this->list = $query->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $countProducts = 0;
        if ($this->brandId) {
            $query = Product::find()->where([
                'hidden' => Product::HIDDEN_NO,
                'brandId' => $this->brandId,
            ]);
            if (Yii::$app->request->get('sectionId')) {
                $query->joinWith('productSectionRel', false, 'INNER JOIN')
                    ->andWhere([ProductSectionRel::tableName() . '.[[sectionId]]' => Yii::$app->request->get('sectionId')]);
            }
            $countProducts = $query->count();
        } elseif ($this->usageId) {
            $query = ProductUsageRel::find()
                ->joinWith('product', false, 'INNER JOIN')
                ->where([
                    Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO,
                    ProductUsageRel::tableName() . '.[[usageId]]' => $this->usageId,
                ]);
            $countProducts = $query->count();
        }

        return $this->render('menu', [
            'hasSelection' => ProductCatalogSearch::hasSavedSelection(),
            'promos' => $this->list,
            'promoId' => $this->promoId,
            'brandId' => $this->brandId,
            'usageId' => $this->usageId,
            'countProducts' => $countProducts,
        ]);
    }
}