<?php

namespace app\modules\auth\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form about `app\modules\auth\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'auth_id', 'status'], 'integer'],
            [['ip', 'created_at'], 'safe'],
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
        $query = Log::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'auth_id' => $this->auth_id,
            'status' => $this->status,
            'ip' => $this->ip ? ip2long($this->ip) : null,
        ])->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
