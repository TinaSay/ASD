<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
    public $year;
    public $month;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group', 'hidden', 'year', 'month'], 'integer'],
            [['title', 'createdAt', 'updatedAt'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'year' => 'Год',
                'month' => 'Месяц',
            ]);
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
        $query = News::find()->with('groupRelation')->language();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'group' => $this->group,
            'hidden' => $this->hidden,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedAt', $this->updatedAt]);

        $query->andFilterWhere(['=', new Expression('MONTH(date)'), $this->month]);
        $query->andFilterWhere(['=', new Expression('YEAR(date)'), $this->year]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public static function getYears()
    {
        $now = new \DateTime();
        $curYear = $now->format('Y');
        $beginYear = 2016;
        $years = ['' => 'Выберите...'];
        for ($i = $beginYear; $i <= $curYear; $i++) {
            $years[$i] = $i;
        }

        return $years;
    }

    /**
     * @return array
     */
    public static function getMonths()
    {
        return [
            '' => Yii::t('frontend', 'Select...'),
            '01' => Yii::t('frontend', 'January'),
            '02' => Yii::t('frontend', 'February'),
            '03' => Yii::t('frontend', 'March'),
            '04' => Yii::t('frontend', 'April'),
            '05' => Yii::t('frontend', 'May'),
            '06' => Yii::t('frontend', 'June'),
            '07' => Yii::t('frontend', 'July'),
            '08' => Yii::t('frontend', 'August'),
            '09' => Yii::t('frontend', 'September'),
            '10' => Yii::t('frontend', 'October'),
            '11' => Yii::t('frontend', 'November'),
            '12' => Yii::t('frontend', 'December'),
        ];
    }
}
