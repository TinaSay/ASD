<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:17
 */

namespace app\modules\product\controllers\frontend;

use app\modules\brand\models\Brand;
use app\modules\product\models\fake\BrandSection;
use app\modules\product\models\fake\CatalogMain;
use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductBrandBlock;
use app\modules\product\models\ProductBrandSectionRel;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSectionRel;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\search\ProductCatalogSearch;
use krok\meta\Meta;
use krok\system\components\frontend\Controller;
use Yii;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class BrandController
 *
 * @package app\modules\product\controllers\frontend
 */
class BrandController extends Controller
{
    /**
     * @var string
     */
    public $layout = '//catalog';

    /**
     * @var Meta
     */
    protected $meta;

    /**
     * BrandController constructor.
     * @param string $id
     * @param Module $module
     * @param Meta $meta
     * @param array $config
     */
    public function __construct(string $id, Module $module, Meta $meta, array $config = [])
    {
        $this->meta = $meta;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->meta->register(new CatalogMain());

        $key = [
            __CLASS__,
            __METHOD__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                ProductBrand::class,
                ProductBrandSectionRel::class,
                ProductSection::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {

            $brands = ProductBrand::find()->where([
                ProductBrand::tableName() . '.[[hidden]]' => ProductBrand::HIDDEN_NO,
            ])->orderBy([
                ProductBrand::tableName() . '.[[position]]' => SORT_ASC,
            ])->all();

            $sections = ProductSection::find()
                ->active()
                ->hasProducts()
                ->asArray()->asTree();

            $data = [$brands, $sections];

            Yii::$app->cache->set($key, $data, null, $dependency);
        }

        list($brands, $sections) = $data;

        return $this->render('index', [
            'brands' => $brands,
            'sections' => $sections,
        ]);
    }

    /**
     * @param $brandId
     *
     * @return string
     */
    public function actionView($brandId)
    {
        $model = $this->findModel($brandId);
        $this->meta->register($model);

        $key = [
            __CLASS__,
            __METHOD__,
            $model->id
        ];


        $dependency = new TagDependency([
            'tags' => [
                ProductBrandBlock::class,
                ProductSection::class,
                Product::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $sections = ProductSection::find()
                ->where([
                    ProductBrandSectionRel::tableName() . '.[[brandId]]' => $brandId,
                ])
                ->hasProducts()
                ->active()->asArray()->asTree();

            $blocks = ProductBrandBlock::find()->where([
                'brandId' => $model->id,
                'hidden' => ProductBrandBlock::HIDDEN_NO,
            ])->limit(3)->all();

            $data = [$sections, $blocks];

            Yii::$app->cache->set($key, $data, null, $dependency);
        }

        list($sections, $blocks) = $data;

        return $this->render('view', [
            'model' => $model,
            'sections' => $sections,
            'blocks' => $blocks,
        ]);
    }


    /**
     * @param $brandId
     * @param int|null $sectionId
     *
     * @return string
     */
    public function actionItems($brandId, $sectionId = null)
    {
        $model = $this->findModel($brandId);

        $key = [
            __CLASS__,
            __METHOD__,
            $brandId,
            $sectionId,
            Yii::$app->request->get('page'),
        ];

        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductBrand::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {

            $query = Product::find()
                ->joinWith('brand')
                ->joinWith('promos')
                ->where([
                    Product::tableName() . '.[[brandId]]' => $model->id,
                    Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO,
                ])->orderBy([
                    Product::tableName() . '.[[updatedAt]]' => SORT_DESC,
                ]);

            if ($sectionId) {
                $query->joinWith('productSectionRel', false, 'INNER JOIN')
                    ->andWhere([ProductSectionRel::tableName() . '.[[sectionId]]' => $sectionId]);
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            $list = $dataProvider->getModels();
            $pagination = $dataProvider->getPagination();

            $data = [$list, $pagination];

            Yii::$app->cache->set($key, $data, null, $dependency);
        }

        list($list, $pagination) = $data;

        $section = null;
        if ($sectionId) {
            $section = ProductSection::findOne($sectionId);
            $brandSection = new BrandSection([
                'brand' => $model,
                'section' => $section,
            ]);
            $this->meta->register($brandSection);
        } else {
            $this->meta->register($model);
        }

        return $this->render('items', [
            'model' => $model,
            'list' => $list,
            'pagination' => $pagination,
            'section' => $section,
        ]);
    }

    /**
     * @param $brandId
     * @param $sectionId
     *
     * @return string
     */
    public function actionSection($brandId, $sectionId)
    {
        return $this->actionItems($brandId, $sectionId);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionGetSections($id)
    {
        $sections = ProductSection::find()->where([
            ProductBrandSectionRel::tableName() . '.[[brandId]]' => $id,
        ])->active()->asArray()->asTree();
        if ($sections) {
            $searchModel = new ProductCatalogSearch();

            return $this->renderAjax('_sections_checkbox', [
                'sections' => $sections,
                'searchModel' => $searchModel,
            ]);
        }

        return '';
    }

    /**
     * @return Response
     */
    public function actionGetUsages()
    {
        // todo: check client category relation
        $ids = Yii::$app->request->post('ids', []);
        $list = Product::find()
            ->select([
                ProductUsage::tableName() . '.[[id]]',
                ProductUsage::tableName() . '.[[position]]',
            ])
            ->joinWith('usages', false, 'INNER JOIN')
            ->joinWith('brand', false, 'INNER JOIN')
            ->where([
                ProductBrand::tableName() . '.[[id]]' => $ids,
            ])->distinct()
            ->orderBy([ProductUsage::tableName() . '.[[position]]' => SORT_ASC])
            ->column();

        return $this->asJson(['success' => true, 'list' => $list]);
    }

    /**
     * @param $id
     *
     * @return array|null|\yii\db\ActiveRecord|Brand
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if ($model = ProductBrand::find()->where([
            ProductBrand::tableName() . '.[[hidden]]' => ProductBrand::HIDDEN_NO,
            ProductBrand::tableName() . '.[[id]]' => $id,
        ])->illustration()->one()) {
            return $model;
        }

        throw new NotFoundHttpException('Brand not found.');

    }
}