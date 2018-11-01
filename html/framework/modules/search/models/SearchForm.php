<?php

namespace app\modules\search\models;

use yii\base\Model;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property string $term
 */
class SearchForm extends Model
{

    const TYPE_ALL = 0;
    const TYPE_ADVICE = 1;
    const TYPE_NEWS = 2;
    const TYPE_GENERAL = 3;
    const TYPE_PRODUCT = 4;
    const TYPE_PRODUCT_SET = 5;


    /**
     * @var int
     */
    public $type = self::TYPE_ALL;

    /**
     * @var string
     */
    public $term = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term'], 'required'],
            [['term'], 'string'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'term' => 'Поисковый запрос',
        ];
    }

    public function search()
    {
        if (empty($this->term)) {
            return null;
        }

        $model = Yii::createObject(Sphinx::class);

        /* @var $query \yii\db\QueryInterface */
        $query = $model->find(['term' => $this->term]);

        return $query;
    }

    public function getTypesList()
    {
        if (empty($this->term)) {
            return null;
        }

        $model = Yii::createObject(Sphinx::class);

        /* @var $query \yii\db\QueryInterface */
        $query = $model->find(['term' => $this->term]);

        $models = $query->all();
        $types = ArrayHelper::getColumn($models, 'type');
        $types = array_unique($types);

        return $types;
    }
}
