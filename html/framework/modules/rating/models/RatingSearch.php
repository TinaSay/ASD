<?php

namespace app\modules\rating\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * RatingSearch represents the model behind the search form about `app\modules\rating\models\Rating`.
 */
class RatingSearch extends Rating
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'user_id'], 'integer'],
            [['title', 'module', 'user_ip', 'avgRating', 'created_at', 'date'], 'safe'],
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
        $query = Rating::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'record_id' => $this->record_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'rating', $this->rating])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }

    public function searchRating($params)
    {
        $query = Rating::find()->select([
            Rating::tableName() . '.[[title]]',
            Rating::tableName() . '.[[module]]',
            Rating::tableName() . '.[[record_id]]',
            new Expression('AVG(' . Rating::tableName() . '.[[rating]]) AS avgRating'),
            new Expression('MAX(' . Rating::tableName() . '.[[created_at]]) AS date'),
        ])->groupBy([
            Rating::tableName() . '.[[module]]',
            Rating::tableName() . '.[[record_id]]',
            Rating::tableName() . '.[[title]]',
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $query->asArray()->all();
        }

        $query->andFilterWhere([
            'record_id' => $this->record_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'module', $this->module]);

        $query->andFilterHaving(['like', 'date', $this->date])
            ->andFilterHaving(['avgRating' => $this->avgRating]);


        return $query->asArray()->all();
    }
}
