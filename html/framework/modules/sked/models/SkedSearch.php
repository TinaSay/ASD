<?php

namespace app\modules\sked\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SkedSearch represents the model behind the search form about `app\modules\sked\models\Sked`.
 */
class SkedSearch extends Sked
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hidden'], 'integer'],
            [['title', 'route', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Sked::find();

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
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt])
            ->andFilterWhere(['like', 'route', $this->route]);

        return $dataProvider;
    }
}
