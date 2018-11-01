<?php

namespace app\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthSearch represents the model behind the search form about `app\modules\auth\models\Auth`.
 */
class AuthSearch extends Auth
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blocked'], 'integer'],
            [['login', 'email', 'created_at', 'updated_at'], 'safe'],
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
        $query = Auth::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'blocked' => $this->blocked,
        ]);

        $query
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
