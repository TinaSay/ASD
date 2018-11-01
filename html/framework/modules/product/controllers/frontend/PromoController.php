<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:17
 */

namespace app\modules\product\controllers\frontend;

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\search\ProductSearch;
use krok\system\components\frontend\Controller;
use Yii;
use yii\caching\TagDependency;
use yii\web\NotFoundHttpException;

/**
 * Class PromoController
 *
 * @package app\modules\product\controllers\frontend
 */
class PromoController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//catalog';

    /**
     * @param $promoId
     * @param $brandId
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($promoId, $brandId = null)
    {
        $model = ProductPromo::findOne($promoId);

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $key = [
            __CLASS__,
            __METHOD__,
            $promoId,
            $brandId,
            Yii::$app->request->get('page'),
        ];


        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductBrand::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $brand = ProductBrand::findOne($brandId);

            $searchModel = new ProductSearch();

            $searchModel->promoId = [$model->id];
            $searchModel->brandId = $brandId;
            $dataProvider = $searchModel->search([]);
            $list = $dataProvider->getModels();
            $pagination = $dataProvider->getPagination();

            $data = [$list, $pagination, $brand];

            Yii::$app->cache->set($key, $data, null, $dependency);
        } else {
            list($list, $pagination, $brand) = $data;
        }

        return $this->render('index', [
            'list' => $list,
            'pagination' => $pagination,
            'brand' => $brand,
            'model' => $model,
        ]);
    }

}