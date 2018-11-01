<?php

namespace app\modules\contact\models;

use krok\extend\behaviors\TagDependencyBehavior;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%contactsetting}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $label
 */
class Contactsetting extends \yii\db\ActiveRecord
{

    private static $list;

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
        return '{{%contactsetting}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max'=>1000],
            [['name'], 'string', 'max' => 50],
            [['label'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'label' => 'Label',
        ];
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $key = [
            __CLASS__,
            __METHOD__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                Contactsetting::class,
            ],
        ]);

        if (!self::$list && (self::$list = Yii::$app->cache->get($key)) === false) {
            self::$list = self::find()->select([
                'value',
                'name',
            ])->indexBy('name')->column();

            Yii::$app->cache->set($key, self::$list, null, $dependency);
        }

        return self::$list;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public static function has(string $code)
    {
        return array_key_exists($code, self::getList());
    }

    /**
     * @param string $code
     *
     * @return string
     */
    public static function getValue(string $code)
    {
        return ArrayHelper::getValue(self::getList(), $code, '');
    }

    /**
     * @return null|string|string[]
     */
    public static function getCallablePhone()
    {
        return preg_replace('#([^\+\d]+)#', '',
            self::getValue('code') . self::getValue('phone'));
    }
}
