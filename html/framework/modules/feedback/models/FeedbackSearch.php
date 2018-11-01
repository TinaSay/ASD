<?php

namespace app\modules\feedback\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FeedbackSearch represents the model behind the search form about `app\modules\feedback\models\Feedback`.
 */
class FeedbackSearch extends Feedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msg_type', 'status', 'unsubscribe'], 'integer'],
            [['date_add', 'fio', 'phone', 'email', 'company', 'text', 'city', 'date_sent', 'date_edited'], 'safe'],
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
        $query = Feedback::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                    'fio' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_add' => $this->date_add,
            'msg_type' => $this->msg_type,
            'date_sent' => $this->date_sent,
            'status' => $this->status,
            'date_edited' => $this->date_edited,
            'unsubscribe' => $this->unsubscribe,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'city', $this->city]);


        return $dataProvider;
    }
}
