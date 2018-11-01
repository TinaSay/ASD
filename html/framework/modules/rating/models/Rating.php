<?php

namespace app\modules\rating\models;

use Yii;
use app\modules\auth\models\Auth;
use krok\extend\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%rating}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $module
 * @property integer $record_id
 * @property integer $user_id
 * @property string $user_ip
 * @property integer $rating
 * @property string $created_at
 * @property string $sessionId
 * @property Client $user
 */
class Rating extends \yii\db\ActiveRecord
{

    /**
     * @var float
     */
    public $avgRating;

    /**
     * @var string
     */
    public $date;

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rating}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'user_id', 'rating'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['module'], 'string', 'max' => 64],
            [['user_ip'], 'string', 'max' => 39],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'module' => 'Модуль',
            'record_id' => 'ID записи',
            'user_id' => 'Пользователь',
            'user_ip' => 'IP пользователя',
            'rating' => 'Оценка',
            'avgRating' => 'Средняя оценка',
            'created_at' => 'Создано',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Auth::class, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return RatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RatingQuery(get_called_class());
    }

    public static function getAvgRating($module, $record_id)
    {
        if (empty($module) || empty($record_id)) {
            return 0;
        }

        $avgRating = Rating::find()->select([
            new Expression('AVG(' . Rating::tableName() . '.[[rating]]) AS avgRating'),
        ])->where([
            Rating::tableName() . '.[[module]]' => $module,
            Rating::tableName() . '.[[record_id]]' => $record_id,
        ])->scalar();

        return ceil($avgRating);
    }
}
