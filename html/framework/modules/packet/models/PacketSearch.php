<?php

namespace app\modules\packet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PacketSearch represents the model behind the search form about `app\modules\packet\models\Packet`.
 */
class PacketSearch extends Packet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category', 'byRegion', 'sent', 'createdBy'], 'integer'],
            [['subject', 'text', 'createdAt', 'updatedAt', 'sendAt'], 'safe'],
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
        $query = Packet::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category' => $this->category,
            'byRegion' => $this->byRegion,
            'sent' => $this->sent,
            'createdBy' => $this->createdBy,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt])
            ->andFilterWhere(['like', 'sendAt', $this->sendAt]);

        return $dataProvider;
    }
}
