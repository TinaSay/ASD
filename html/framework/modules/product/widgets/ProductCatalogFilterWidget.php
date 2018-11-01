<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 14:58
 */

namespace app\modules\product\widgets;

use app\modules\product\assets\CatalogFilterAsset;
use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductClientCategory;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\search\ProductCatalogSearch;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * Class ProductCatalogFilter
 *
 * @package app\modules\product\widgets
 */
class ProductCatalogFilterWidget extends Widget
{
    /**
     * @var array
     */
    protected $brands = [];
    /**
     * @var array
     */
    protected $clientCategory = [];

    /**
     * @var array
     */
    protected $usages = [];

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * init widget
     */
    public function init()
    {
        parent::init();

        $key = [
            __CLASS__,
            __METHOD__,
        ];


        $dependency = new TagDependency([
            'tags' => [
                ProductBrand::class,
                ProductClientCategory::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {

            $this->brands = ProductBrand::find()->where([
                'hidden' => ProductBrand::HIDDEN_NO,
            ])->orderBy(['position' => SORT_ASC])->all();

            $this->clientCategory = ProductClientCategory::find()->where([
                'hidden' => ProductBrand::HIDDEN_NO,
            ])->orderBy(['title' => SORT_ASC])->all();

            $this->usages = ProductUsage::find()->where([
                'hidden' => ProductUsage::HIDDEN_NO,
            ])->orderBy(['position' => SORT_ASC])->all();

            $this->total = Product::find()->active()->count();

            $data = [$this->brands, $this->clientCategory, $this->usages, $this->total];

            Yii::$app->cache->set($key, $data, null, $dependency);
        } else {
            list($this->brands, $this->clientCategory, $this->usages, $this->total) = $data;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->getView()->registerAssetBundle(CatalogFilterAsset::class);

        $searchModel = new ProductCatalogSearch();
        $searchModel->load(Yii::$app->request->get());

        $article = ArrayHelper::getValue(Yii::$app->request->get(), [$searchModel->formName(), 'article']);

        return $this->render('filter', [
            'searchModel' => $searchModel,
            'brands' => $this->brands,
            'clientCategory' => $this->clientCategory,
            'usages' => $this->usages,
            'total' => $this->total,
            'count' => Yii::$app->formatter->asDecimal($searchModel->searchQuery()->count(), 0),
            'opened' => !$searchModel->isEmpty() && is_null($article),
        ]);
    }
}