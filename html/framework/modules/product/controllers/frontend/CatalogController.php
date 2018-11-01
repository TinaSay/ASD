<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:17
 */

namespace app\modules\product\controllers\frontend;

use app\modules\product\models\fake\CatalogMain;
use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductClientCategoryRel;
use app\modules\product\models\ProductProperty;
use app\modules\product\models\ProductPropertyValue;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\search\ProductCatalogSearch;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use Yii;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CatalogController
 *
 * @package app\modules\product\controllers\frontend
 */
class CatalogController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//catalog';

    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * CatalogController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param MetaInterface $meta
     * @param array $config
     */
    public function __construct(string $id, Module $module, MetaInterface $meta, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->meta = $meta;
    }

    /**
     * @param null $sectionId
     *
     * @return string
     */
    public function actionIndex($sectionId = null)
    {
        $this->meta->register(new CatalogMain());

        $searchModel = new ProductCatalogSearch();

        $key = [
            __CLASS__,
            __METHOD__,
            $sectionId,
            Yii::$app->request->get('page'),
        ];


        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductSection::class,
                ProductBrand::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $brand = $section = null;

            if ($sectionId) {
                $query = ProductSection::find();
                $childrenId = $query->getAllChildrenId($sectionId);
                $searchModel->sectionId = [$sectionId] + $childrenId;
                $section = ProductSection::findOne($sectionId);
                if ($section && $section->brandId) {
                    $brand = ProductBrand::findOne(['id' => $section->brandId]);
                }
            }

            $dataProvider = $searchModel->search();
            $list = $dataProvider->getModels();
            $pagination = $dataProvider->getPagination();

            $data = [$list, $pagination, $brand, $section];

            Yii::$app->cache->set($key, $data, null, $dependency);
        } else {
            list($list, $pagination, $brand, $section) = $data;
        }

        return $this->render('index', [
            'list' => $list,
            'pagination' => $pagination,
            'brand' => $brand,
            'section' => $section,
        ]);
    }

    /**
     * @param null|int $sectionId
     *
     * @return string
     */
    public function actionSearch($sectionId = null)
    {
        $searchModel = new ProductCatalogSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->active(),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $realSearch = Yii::$app->request->get('realSearch', 0);

        if ($searchModel->load(Yii::$app->request->get()) && $searchModel->validate()) {
            $searchModel->realSearch = $realSearch;
            $dataProvider = $searchModel->search();
            if ($searchModel->isRealSearch()) {
                $searchModel->saveSelection($dataProvider->totalCount);
            } else {
                $searchModel->deleteSelection();
            }
        } elseif ($sectionId) {
            $childrenId = ProductSection::find()->getAllChildrenId($sectionId);
            $searchModel->sectionId = [$sectionId] + $childrenId;
            $dataProvider = $searchModel->search();
        } elseif ($searchModel::hasSavedSelection()) {
            $searchModel->loadSelection();
            $dataProvider = $searchModel->search();
        }

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param $usageId
     *
     * @return string
     */
    public function actionUsage($usageId)
    {
        $usage = ProductUsage::findOne($usageId);
        $searchModel = new ProductCatalogSearch();

        $searchModel->usageId = [$usageId];
        $dataProvider = $searchModel->search();

        return $this->render('usage', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'usage' => $usage,
        ]);
    }

    /**
     * @return Response
     */
    public function actionFilterCount()
    {
        $searchModel = new ProductCatalogSearch();
        $searchModel->load(Yii::$app->request->post());

        $count = $searchModel->searchQuery()->distinct()->count();

        return $this->asJson([
            'success' => true,
            'count' => ($searchModel->isEmpty() ? 0 :
                Yii::$app->formatter->asDecimal($count, 0)),
            'text' => $searchModel->isEmpty() ? Yii::t('system', 'goods') :
                'товаров',
        ]);
    }

    /**
     * @param string $alias
     *
     * @return string
     */
    public function actionView($alias)
    {
        $setId = Yii::$app->request->get('setId');
        $set = null;
        if ($setId) {
            $set = ProductSet::findOne($setId);
        }
        $model = $this->findModel($alias);

        $this->meta->register($model);

        return $this->render('view', [
            'model' => $model,
            'set' => $set,
        ]);
    }

    /**
     * @param string $term
     *
     * @return Response
     */
    public function actionProductDictionary(string $term)
    {
        $list = Product::find()->select([
            'id',
            'alias',
            new Expression('[[title]] as [[label]]'),
            new Expression('[[title]] as [[value]]'),
        ])->active()
            ->andWhere([
                'OR',
                ['like', 'title', $term],
                ['like', 'article', $term],
            ])->asArray()->limit(10)->all();

        $list = ArrayHelper::map($list, 'id', function ($model) {
            $model['url'] = Url::to(['/product/catalog/view', 'alias' => $model['alias']]);
            unset($model['alias']);

            return $model;
        });

        return $this->asJson(['success' => true, 'list' => $list]);
    }

    /**
     * @return Response
     */
    public function actionBrandsForCategory()
    {
        $ids = Yii::$app->request->post('ids', []);
        $list = Product::find()
            ->select(ProductBrand::tableName() . '.[[id]]')
            ->joinWith('productClientCategoryRel', false, 'INNER JOIN')
            ->joinWith('brand', false, 'INNER JOIN')
            ->active()
            ->where([
                ProductClientCategoryRel::tableName() . '.[[clientCategoryId]]' => $ids,
            ])->groupBy([
                ProductBrand::tableName() . '.[[id]]',
            ])->column();

        return $this->asJson(['success' => true, 'list' => $list]);
    }

    /**
     * @param $alias
     *
     * @return null|static|Product
     * @throws NotFoundHttpException
     */
    protected function findModel(string $alias)
    {
        $key = [
            __CLASS__,
            __METHOD__,
            $alias,
        ];


        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductBrand::class,
                ProductProperty::class,
                ProductPropertyValue::class,
            ],
        ]);

        if (($model = Yii::$app->cache->get($key)) === false) {

            $model = Product::find()
                ->where([
                    Product::tableName() . '.[[alias]]' => $alias,
                ])
                ->active()
                ->joinWith('brand')
                ->joinWith('usages')
                ->joinWith('productPropertyValues')
                ->joinWith('properties')
                ->one();
            if (!$model) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            Yii::$app->cache->set($key, $model, null, $dependency);
        }

        return $model;
    }
}