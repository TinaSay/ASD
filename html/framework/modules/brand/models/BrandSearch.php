<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\brand\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
* BrandSearch represents the model behind the search form about `app\modules\brand\models\Brand`.
*/
class BrandSearch extends Brand
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'blocked'], 'integer'],
            [['title', 'text', 'title2', 'text2', 'link'], 'safe'],
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
$query = Brand::find();

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

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title2', $this->title2])
            ->andFilterWhere(['like', 'text2', $this->text2])
            ->andFilterWhere(['like', 'link', $this->link]);

return $dataProvider;
}
}
