<?php

namespace app\modules\news\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SubscribeSearch represents the model behind the search form about `app\modules\news\models\Subscribe`.
 */
class SubscribeSearch extends Subscribe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'unsubscribe'], 'integer'],
            [['email', 'country', 'city', 'type'], 'safe'],
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
        $query = Subscribe::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere([
            'unsubscribe' => $this->unsubscribe,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}
