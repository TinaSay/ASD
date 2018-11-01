<?php

namespace app\modules\about\models;

use app\modules\banner\models\Banner;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%about_banner}}".
 *
 * @property integer $id
 * @property integer $aboutId
 * @property integer $bannerId
 *
 * @property About $about
 * @property Banner $banner
 */
class AboutBanner extends ActiveRecord
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
        return '{{%about_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aboutId', 'bannerId'], 'required'],
            [['aboutId', 'bannerId'], 'integer'],
            [
                ['aboutId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => About::class,
                'targetAttribute' => ['aboutId' => 'id'],
            ],
            [
                ['bannerId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Banner::class,
                'targetAttribute' => ['bannerId' => 'id'],
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
            'aboutId' => 'About ID',
            'bannerId' => 'Banner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbout()
    {
        return $this->hasOne(About::class, ['id' => 'aboutId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::class, ['id' => 'bannerId']);
    }
}
