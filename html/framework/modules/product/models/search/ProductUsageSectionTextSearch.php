<?php

namespace app\modules\product\models\search;

use app\modules\product\models\ProductUsageSectionText;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductUsageSectionTextSearch represents the model behind the search form about `app\modules\product\models\ProductUsageSectionText`.
 */
class ProductUsageSectionTextSearch extends ProductUsageSectionText
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usageId', 'sectionId', 'hidden'], 'integer'],
            [['title'], 'string'],
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
        $query = ProductUsageSectionText::find()->where([
            ProductUsageSectionText::tableName() . '.[[language]]' => Yii::$app->language
        ])->joinWith('usage')
            ->joinWith('section');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            ProductUsageSectionText::tableName() . '.[[id]]' => $this->id,
            ProductUsageSectionText::tableName() . '.[[usageId]]' => $this->usageId,
            ProductUsageSectionText::tableName() . '.[[sectionId]]' => $this->sectionId,
            ProductUsageSectionText::tableName() . '.[[hidden]]' => $this->hidden,
        ]);

        $query->andFilterWhere(['like', ProductUsageSectionText::tableName() . '.[[title]]', $this->title]);

        return $dataProvider;
    }
}
