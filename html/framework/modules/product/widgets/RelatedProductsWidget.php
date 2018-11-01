<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 13.02.18
 * Time: 19:12
 */

namespace app\modules\product\widgets;

use app\modules\product\assets\ProductRelatedAsset;
use app\modules\product\models\Product;
use app\modules\product\models\ProductRel;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Class RelatedProductsWidget
 *
 * @package app\modules\product\widgets
 */
class RelatedProductsWidget extends Widget
{
    /**
     * @var int
     */
    public $model;

    /**
     * @var Product[]
     */
    protected $list = [];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->model) {
            throw new InvalidConfigException('You must set "model" property');
        }
        if (!$this->model instanceof Product) {
            throw new InvalidConfigException('Property "model" must be instance of ' . Product::class);
        }
        parent::init();

        $key = [
            __CLASS__,
            __METHOD__,
            $this->model->id,
        ];


        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductRel::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {

            $this->list = $this->model->getRelatedProducts()
                ->joinWith('promos')
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->getView()->registerAssetBundle(ProductRelatedAsset::class);

        return $this->render('related', [
            'model' => $this->model,
            'list' => $this->list,
        ]);
    }
}