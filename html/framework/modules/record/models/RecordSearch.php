<?php

namespace app\modules\record\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RecordSearch represents the model behind the search form about `app\modules\record\models\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hidden', 'createdAt', 'updatedAt'], 'integer'],
            [['dateHistory', 'description', 'file'], 'safe'],
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
        $query = Record::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'dateHistory' => $this->dateHistory,
            'hidden' => $this->hidden,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['createdAt', 'file', $this->createdAt])
            ->andFilterWhere(['updatedAt', 'file', $this->updatedAt]);

        return $dataProvider;
    }
}
