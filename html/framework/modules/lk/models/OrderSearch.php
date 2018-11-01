<?php

namespace app\modules\lk\models;

use yii\base\Model;
use Yii;
use yii2mod\query\ArrayQuery;

/**
 * Created by PhpStorm.
 * User: artlosk
 * Date: 024 24.05.18
 * Time: 18:39
 */
class OrderSearch extends Model
{
    const EXISTS_DOCUMENTS_YES = 1;
    const EXISTS_DOCUMENTS_NO = 0;

    const ORDER_CREATE = 0;
    const ORDER_RESERVE = 1;
    const ORDER_FEATURE = 2;
    const ORDER_READY = 3;
    const ORDER_SHIPPED = 4;

    public static $orders = [
        '' => 'Выберите статус',
        self::ORDER_CREATE => 'Создан',
        self::ORDER_RESERVE => 'Зарезервирован',
        self::ORDER_FEATURE => 'Собирается',
        self::ORDER_READY => 'Готов к отгрузке',
        self::ORDER_SHIPPED => 'Отгружен',

    ];

    public static $iconStatus = [
        self::ORDER_CREATE => 'icon-ok',
        self::ORDER_RESERVE => 'icon-reserve',
        self::ORDER_FEATURE => 'icon-assembly',
        self::ORDER_READY => 'icon-ready',
        self::ORDER_SHIPPED => 'icon-car',
    ];

    public $createdAtFrom;
    public $createdAtTo;
    public $totalSumFrom;
    public $totalSumTo;
    public $status;

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['totalSumFrom', 'totalSumTo'], 'number'],
            [['createdAtFrom', 'createdAtTo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function searchQuery($params)
    {
        $orders = Yii::$app->session['user']['orders'];
        $query = new ArrayQuery();
        $query->from($orders);

        // load the search form data and validate
        if ($this->load($params) && $this->validate()) {
            // adjust the query by adding the filters

            if ($this->createdAtFrom || $this->createdAtTo) {
                if ($this->createdAtFrom && is_null($this->createdAtTo)) {
                    $query->andFilterWhere([
                        '>=', 'createdAtDate', Yii::$app->formatter->asDate($this->createdAtFrom, 'php:Y-m-d')
                    ]);
                } else if (is_null($this->createdAtFrom) && $this->createdAtTo) {
                    $query->andFilterWhere([
                        '>=', 'createdAtDate', Yii::$app->formatter->asDate($this->createdAtTo, 'php:Y-m-d')
                    ]);
                } else if ($this->createdAtFrom && $this->createdAtTo) {
                    $query->andFilterWhere([
                        'AND',
                        ['>=', 'createdAtDate', Yii::$app->formatter->asDate($this->createdAtFrom, 'php:Y-m-d')],
                        ['<=', 'createdAtDate', Yii::$app->formatter->asDate($this->createdAtTo, 'php:Y-m-d')],
                    ]);
                }
            }

            if ($this->totalSumFrom || $this->totalSumTo) {
                $query->andFilterWhere([
                    'AND',
                    ['>=', 'totalSum', $this->totalSumFrom],
                    ['<=', 'totalSum', $this->totalSumTo],
                ]);
            }

            $query->andFilterWhere(['status' => $this->status]);
        }
        return $query;
    }
}