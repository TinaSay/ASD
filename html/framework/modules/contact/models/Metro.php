<?php

namespace app\modules\contact\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%metro}}".
 *
 * @property integer $id
 * @property integer $divisionId
 * @property string $name
 * @property string $distance
 * @property string $color
 *
 * @property Division $division
 */
class Metro extends ActiveRecord
{

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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metro}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['divisionId'], 'integer'],
            [['name', 'distance'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 6, 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'divisionId' => 'Division ID',
            'name' => 'Name',
            'distance' => 'Distance',
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::class, ['id' => 'divisionId']);
    }

    /**
     * @inheritdoc
     * @return MetroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetroQuery(get_called_class());
    }
}
