<?php

namespace app\modules\wherebuy\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchWherebuy represents the model behind the search form about `app\modules\wherebuy\models\Wherebuy`.
 */
class SearchWherebuy extends Wherebuy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hidden'], 'integer'],
            [['title', 'subtitle', 'link', 'delivery'], 'safe'],
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
        $query = Wherebuy::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'delivery', $this->delivery]);

        return $dataProvider;
    }
}
