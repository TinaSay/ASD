<?php

namespace app\modules\feedback\models;

use krok\extend\behaviors\TagDependencyBehavior;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $label
 */
class FeedbackSettings extends \yii\db\ActiveRecord
{
    const CALL_SETTINGS = 'callsettings';
    const EMAIL_SETTINGS = 'emailsettings';
    const TITLE_SETTINGS = 'title';
    const SUBTITLE_SETTINGS = 'subtitle';
    const TEXT_SETTINGS = 'text';
    const ORDER_EMAIL_SETTINGS = 'order';
    const PRIVACY_POLICY = 'privacyPolicy';

    private static $list;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedbacksettings}}';
    }

    /**
     * @inheritdoc
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
            ['name', 'safe'],
            ['value', 'required', 'message' => 'Поле не может быть пустым'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Адреса, получающие уведомления',
            'value' => '',
        ];
    }

}
