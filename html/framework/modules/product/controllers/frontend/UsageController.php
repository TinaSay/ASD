<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.02.18
 * Time: 10:17
 */

namespace app\modules\product\controllers\frontend;

use app\modules\product\models\fake\UsageMain;
use app\modules\product\models\fake\UsageSection;
use app\modules\product\models\Product;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSectionRel;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\ProductUsageRel;
use app\modules\product\models\ProductUsageSectionText;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use tina\metatag\components\Metatag;
use Yii;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class UsageController
 *
 * @package app\modules\product\controllers\frontend
 */
class UsageController extends Controller
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @var Metatag
     */
    protected $metatag;

    /**
     * UsageController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param MetaInterface $meta
     * @param Metatag $metatag
     * @param array $config
     */
    public function __construct(string $id, Module $module, MetaInterface $meta, Metatag $metatag, array $config = [])
    {
        $this->meta = $meta;
        $this->metatag = $metatag;
        parent::__construct($id, $module, $config);
    }

    /**
     * @var string
     */
    public $layout = '//catalog';

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->meta->register(new UsageMain());

        $key = [
            __CLASS__,
            __METHOD__,
            Yii::$app->language,
        ];


        $dependency = new TagDependency([
            'tags' => [
                ProductUsage::class,
                ProductSection::class,
            ],
        ]);

        if (($usages = Yii::$app->cache->get($key)) === false) {

            $usages = ProductUsage::find()->where([
                ProductUsage::tableName() . '.[[hidden]]' => ProductUsage::HIDDEN_NO,
            ])->orderBy([
                ProductUsage::tableName() . '.[[position]]' => SORT_ASC,
            ])->all();

            /** @var ProductUsage $usage */
            foreach ($usages as $usage) {
                $usage->setSections(
                    ProductUsage::sectionsAsDropDown($usage->id, ProductSection::HIDDEN_NO)
                );
            }

            Yii::$app->cache->set($key, $usages, null, $dependency);
        }

        return $this->render('index', [
            'usages' => $usages,
        ]);
    }

    /**
     * @param $usageId
     *
     * @return string
     */
    public function actionView($usageId)
    {
        $key = [
            __CLASS__,
            __METHOD__,
            $usageId,
        ];

        $dependency = new TagDependency([
            'tags' => [
                ProductUsage::class,
                ProductSection::class,
            ],
        ]);

        if (($model = Yii::$app->cache->get($key)) === false) {

            $model = $this->findModel($usageId);

            $model->setSections(
                ProductUsage::sectionsAsDropDown($model->id, ProductSection::HIDDEN_NO)
            );

            Yii::$app->cache->set($key, $model, null, $dependency);
        }
        $this->meta->register($model);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $usageId
     * @param int|null $partitionId
     *
     * @return string
     */
    public function actionItems($usageId, $partitionId = null)
    {
        $model = $this->findModel($usageId);

        $key = [
            __CLASS__,
            __METHOD__,
            $usageId,
            $partitionId,
            Yii::$app->request->get('page'),
        ];

        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductUsage::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {

            $query = Product::find()
                ->joinWith('brand')
                ->joinWith('promos')
                ->joinWith('productUsageRel', false, 'INNER JOIN')
                ->where([
                    ProductUsageRel::tableName() . '.[[usageId]]' => $usageId,
                    Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO,
                ])->orderBy([
                    Product::tableName() . '.[[updatedAt]]' => SORT_DESC,
                ]);

            if ($partitionId) {
                $query->joinWith('productSectionRel', false, 'INNER JOIN')
                    ->andWhere([ProductSectionRel::tableName() . '.[[sectionId]]' => $partitionId]);
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
        if ($partitionId) {
            $section = ProductSection::findOne($partitionId);
        }
        if ($section) {
            $this->meta->register(new UsageSection([
                'usage' => $model,
                'section' => $section,
            ]));
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
     * @param $usageId
     * @param $partitionId
     *
     * @return string
     */
    public function actionSection($usageId, $partitionId)
    {
        /** @var ProductUsageSectionText $model */
        $model = ProductUsageSectionText::find()->where([
            'language' => Yii::$app->language,
            'hidden' => ProductUsageSectionText::HIDDEN_NO,
            'sectionId' => $partitionId,
            'usageId' => $usageId,
        ])->one();

        if ($model) {
            $this->meta->register($model);
        }

        return $this->actionItems($usageId, $partitionId);
    }

    /**
     * @param $id
     *
     * @return array|null|\yii\db\ActiveRecord|ProductUsage
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if ($model = ProductUsage::find()->where([
            'hidden' => ProductUsage::HIDDEN_NO,
            'id' => $id,
        ])->one()) {
            return $model;
        }

        throw new NotFoundHttpException('Usage not found.');

    }
}