<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 14.02.18
 * Time: 15:12
 */

namespace app\modules\product\controllers\frontend;

use app\modules\product\models\Product;
use app\modules\product\models\ProductPage;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductSetRel;
use app\modules\product\models\ProductUsage;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use Yii;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * Class SetController
 *
 * @package app\modules\product\controllers\frontend
 */
class SetController extends Controller
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * SetController constructor.
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
     * @param null $categoryId
     *
     * @return string
     */
    public function actionIndex($categoryId = null)
    {
        $key = [
            __CLASS__,
            __METHOD__,
            $categoryId,
        ];


        $dependency = new TagDependency([
            'tags' => [
                ProductUsage::class,
                ProductSet::class,
                ProductPage::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $usages = ProductSet::find()
                ->select([
                    new Expression('IF(' . ProductUsage::tableName() . '.[[name]] > "", ' .
                        ProductUsage::tableName() . '.[[name]], ' . ProductUsage::tableName() . '.[[title]])'),
                    ProductUsage::tableName() . '.[[id]]',
                ])
                ->joinWith('usage', false, 'INNER JOIN')
                ->distinct()
                ->indexBy('id')
                ->column();

            $list = ProductSet::find()->where([
                ProductSet::tableName() . '.[[hidden]]' => ProductSet::HIDDEN_NO,
            ])->joinWith('usage', true)
                ->andFilterWhere(['usageId' => $categoryId])
                ->orderBy([
                    'position' => SORT_ASC,
                ])->all();

            $page = ProductPage::find()->where([
                'hidden' => ProductPage::HIDDEN_NO,
            ])->one();

            $data = [$usages, $list, $page];

            Yii::$app->cache->set($key, $data, null, $dependency);
        }

        list($usages, $list, $page) = $data;

        return $this->render('index', [
            'list' => $list,
            'usages' => $usages,
            'usageId' => $categoryId,
            'page' => $page,
        ]);
    }

    /**
     * @param $setId
     *
     * @return string
     */
    public function actionView($setId)
    {
        $model = $this->findModel($setId);

        $this->meta->register($model);

        return $this->render('view', [
            'model' => $model,
            'list' => $this->getProducts($setId),
        ]);
    }

    /**
     * @param $setId
     *
     * @return string
     */
    public function actionItems($setId)
    {
        $model = $this->findModel($setId);


        return $this->render('items', ['model' => $model, 'list' => $this->getProducts($setId)]);
    }

    /**
     * @param $setId
     *
     * @return Product[]|null
     */
    protected function getProducts($setId)
    {
        $key = [
            __CLASS__,
            __METHOD__,
            $setId,
        ];


        $dependency = new TagDependency([
            'tags' => [
                Product::class,
                ProductSetRel::class,
            ],
        ]);

        if (($list = Yii::$app->cache->get($key)) === false) {
            $productId = ProductSetRel::find()
                ->distinct()
                ->select(['productId'])->where([
                    'setId' => $setId,
                ])->column();
            $list = [];

            if ($productId) {
                $list = Product::find()
                    ->joinWith('brand')
                    ->joinWith([
                        'productSetRel' => function (ActiveQuery $query) use ($setId) {
                            $query->onCondition([
                                ProductSetRel::tableName() . '.[[setId]]' => $setId,
                            ]);
                        },
                    ])->where([
                        Product::tableName() . '.[[id]]' => $productId,
                        Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO,
                    ])->all();
            }

            Yii::$app->cache->set($key, $list, null, $dependency);
        }

        return $list;
    }

    /**
     * @param $setId
     *
     * @return string
     */
    public function actionOrder($setId)
    {
        return $this->render('order', ['model' => $this->findModel($setId)]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage()
    {
        $model = ProductPage::find()->where([
            'hidden' => ProductPage::HIDDEN_NO,
        ])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $key = [
            __CLASS__,
            __METHOD__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                ProductUsage::class,
            ],
        ]);

        if (($usages = Yii::$app->cache->get($key)) === false) {
            $usages = ProductSet::find()
                ->select([
                    ProductUsage::tableName() . '.[[title]]',
                    ProductUsage::tableName() . '.[[id]]',
                ])
                ->joinWith('usage', false, 'INNER JOIN')
                ->distinct()
                ->indexBy('id')
                ->column();

            Yii::$app->cache->set($key, $usages, null, $dependency);
        }

        return $this->render('page', ['model' => $model, 'usages' => $usages]);
    }

    /**
     * @param $id
     *
     * @return null|\yii\db\ActiveRecord|ProductSet
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = ProductSet::find()
            ->joinWith([
                'products' => function (ActiveQuery $query) {
                    $query->onCondition([
                            Product::tableName() . '.[[hidden]]' => Product::HIDDEN_NO,
                        ]
                    );
                },
            ])
            ->where([ProductSet::tableName() . '.[[id]]' => $id])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}