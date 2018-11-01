<?php

namespace app\modules\product\models\search;

use app\modules\product\models\Product;
use app\modules\product\models\ProductPromoRel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property array $promoId
 *
 * ProductSearch represents the model behind the search form about `app\modules\product\models\Product`.
 */
class ProductSearch extends Product
{
    public $promoId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brandId', 'hidden'], 'integer'],
            [
                [
                    'uuid',
                    'article',
                    'title',
                    'createdAt',
                    'updatedAt',
                ],
                'safe',
            ],
            [
                [
                    'promoId',
                ],
                'each',
                'rule' => ['integer'],
            ],
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()
            ->notDeleted();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->promoId) {
            $query->joinWith('productPromoRel')
                ->andWhere([
                    ProductPromoRel::tableName() . '.[[promoId]]' => $this->promoId,
                ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'brandId' => $this->brandId,
            'hidden' => $this->hidden,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'article', $this->article])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
