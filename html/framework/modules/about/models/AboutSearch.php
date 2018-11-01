<?php

namespace app\modules\about\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AboutSearch represents the model behind the search form about `app\modules\about\models\About`.
 */
class AboutSearch extends About
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publicHistory', 'publishAnApplication', 'blocked'], 'integer'],
            [['title', 'description', 'mainVideo', 'titleForImage', 'descriptionImage', 'titleForBanners', 'titleAdditionalBlock', 'additionalDescription', 'urlYoutubeVideo', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = About::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'publicHistory' => $this->publicHistory,
            'publishAnApplication' => $this->publishAnApplication,
            'blocked' => $this->blocked,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mainVideo', $this->mainVideo])
            ->andFilterWhere(['like', 'titleForImage', $this->titleForImage])
            ->andFilterWhere(['like', 'descriptionImage', $this->descriptionImage])
            ->andFilterWhere(['like', 'titleForBanners', $this->titleForBanners])
            ->andFilterWhere(['like', 'titleAdditionalBlock', $this->titleAdditionalBlock])
            ->andFilterWhere(['like', 'additionalDescription', $this->additionalDescription])
            ->andFilterWhere(['like', 'urlYoutubeVideo', $this->urlYoutubeVideo])
            ->andFilterWhere(['like', 'createdAt', $this->urlYoutubeVideo])
            ->andFilterWhere(['like', 'updatedAt', $this->urlYoutubeVideo]);

        return $dataProvider;
    }
}
