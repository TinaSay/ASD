<?php

namespace app\modules\product\models\search;

use app\modules\product\models\ProductUsage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductUsageSearch represents the model behind the search form about `app\modules\product\models\ProductUsage`.
 */
class ProductUsageSearch extends ProductUsage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hidden'], 'integer'],
            [['uuid', 'title', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = ProductUsage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'hidden' => $this->hidden,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
