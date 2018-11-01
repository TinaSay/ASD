<?php

namespace app\modules\product\models\search;

use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\Product;
use app\modules\product\models\ProductClientCategoryRel;
use app\modules\product\models\ProductSectionRel;
use app\modules\product\models\ProductUsageRel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * @property array $clientCategoryId
 * @property array $usageId
 * @property array $sectionId
 * @property array $brandId
 * @property string $article
 *
 * ProductCatalogSearch represents the model behind the search form about `app\modules\product\models\Product`.
 */
class ProductCatalogSearch extends Model implements ProductTitleInterface
{
    /**
     * @var array
     */
    public $clientCategoryId = [];

    /**
     * @var array
     */
    public $sectionId = [];

    /**
     * @var array
     */
    public $brandId = [];

    /**
     * @var array
     */
    public $usageId = [];

    /**
     * @var string
     */
    public $article;

    /**
     * @var bool
     */
    public $realSearch = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'clientCategoryId',
                    'sectionId',
                    'brandId',
                    'usageId',
                ],
                'each',
                'rule' => ['integer'],
            ],
            [['article'], 'string', 'min' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => $this->searchQuery(),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
    }

    /**
     * @return Query
     */
    public function searchQuery()
    {
        $query = Product::find()
            ->joinWith('brand')
            ->joinWith('promos')
            ->distinct()
            ->active();
        if (!$this->validate()) {
            return $query;
        }

        if ($this->clientCategoryId) {
            $query->joinWith('productClientCategoryRel')
                ->andWhere([
                    ProductClientCategoryRel::tableName() . '.[[clientCategoryId]]' => $this->clientCategoryId,
                ]);
        }
        if ($this->usageId) {
            $query->joinWith('productUsageRel')
                ->andWhere([
                    ProductUsageRel::tableName() . '.[[usageId]]' => $this->usageId,
                ]);
        }
        if ($this->sectionId) {
            $query->joinWith('productSectionRel')
                ->andWhere([
                    ProductSectionRel::tableName() . '.[[sectionId]]' => $this->sectionId,
                ]);
        }

        $query->andFilterWhere([
            Product::tableName() . '.[[brandId]]' => $this->brandId,
        ]);

        $query->andFilterWhere([
                'OR',
                ['like', Product::tableName() . '.[[article]]', $this->article],
                ['like', Product::tableName() . '.[[title]]', $this->article],
            ]
        );

        return $query;
    }

    /**
     * @param int|null $results
     */
    public function saveSelection(?int $results)
    {
        Yii::$app->session->set('catalog.search', $this->getAttributes());
        Yii::$app->session->set('catalog.results', $results);
    }

    /**
     *
     */
    public function loadSelection()
    {
        if (self::hasSavedSelection()) {
            $this->load(Yii::$app->session->get('catalog.search'), '');
        }
    }

    /**
     * @return bool
     */
    public static function hasSavedSelection()
    {
        return Yii::$app->session->has('catalog.search');
    }

    /**
     *
     */
    public function deleteSelection()
    {
        Yii::$app->session->remove('catalog.search');
        Yii::$app->session->remove('catalog.results');
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        foreach ($this->getAttributes() as $value) {
            if ($value || !empty($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isRealSearch()
    {
        return $this->realSearch > 0;
    }

    /**
     * @param int|null $id
     * @param null|string $path
     * @return null|string
     */
    public function getMenuTitle(?int $id, ?string $path = null): ?string
    {
        return 'Ваш подбор';
    }
}
