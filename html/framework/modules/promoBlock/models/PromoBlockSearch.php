<?php

namespace app\modules\promoBlock\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PromoBlockSearch represents the model behind the search form about `app\modules\promoBlock\models\PromoBlock`.
 */
class PromoBlockSearch extends PromoBlock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hidden', 'position'], 'integer'],
            [['title', 'signature', 'file', 'url', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = PromoBlock::find();

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
            'imageType' => $this->imageType,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt]);

        $query->orderBy(['position' => SORT_DESC]);

        return $dataProvider;
    }
}
