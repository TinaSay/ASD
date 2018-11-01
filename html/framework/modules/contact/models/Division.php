<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\contact\models;

use app\modules\meta\adapters\OpenGraphAdapter;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use krok\meta\behaviors\MetaBehavior;
use tina\metatag\behaviors\MetatagBehavior;
use yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%division}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $subtitle
 * @property string $phone
 * @property string $address
 * @property string $metro
 * @property string $email
 * @property string $working
 * @property string $requisite
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $hidden
 *
 * @property Requisite[] $requisites
 * @property Metro[] $metros
 */
class Division extends ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    public $meta;

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
     * @return yii\db\ActiveQuery
     */
    public function getMetros()
    {
        return $this->hasMany(Metro::class, ['divisionId' => 'id']);
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getRequisites()
    {
        return $this->hasMany(Requisite::class, ['divisionId' => 'id']);
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'MetatagBehavior' => [
                'class' => MetatagBehavior::class,
                'metaAttribute' => 'meta',
            ],
            'MetaBehavior' => [
                'class' => MetaBehavior::class,
                'adapters' => [
                    OpenGraphAdapter::class,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return [
            'address' => 'Выберите адрес из списка. Введите несколько букв для отображения списка.',
            'metro' => 'Введите несколько букв для отображения списка.',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%division}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['metro'], 'string'],
            [['email'], 'email', 'message' => 'Введите корректный адрес электронной почты'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['lat', 'long'], 'safe'],
            [['hidden'], 'integer'],
            [['title', 'subtitle', 'phone', 'address', 'working', 'requisite'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],

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
            'subtitle' => 'Подзаголовок',
            'phone' => 'Телефон/факс',
            'address' => 'Адрес',
            'metro' => 'Ближайшие станции метро',
            'email' => 'Адрес электронной почты',
            'working' => 'Режим работы',
            'requisite' => 'Реквизиты',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата редактирования',
            'hidden' => 'Заблокировано',
        ];
    }


    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $boolean = parent::save($runValidation, $attributeNames);

        $MetroInsert = Yii::$app->request->post('Metro');
        if (count($MetroInsert) > 0) {
            foreach ($MetroInsert as $item) {
                if ($item['name'] != '') {
                    $metro = new Metro();
                    $metro->name = $item['name'];
                    $metro->distance = $item['distance'];
                    $metro->color = $item['color'];
                    $metro->divisionId = $this->id;
                    $metro->save();
                }
            }
        }

        $MetroUpdate = Yii::$app->request->post('MetroUpdate');
        if (count($MetroUpdate) > 0) {
            foreach ($MetroUpdate as $id => $item) {
                if ($item['name'] != '') {
                    $metro = Metro::findOne($id);
                    $metro->name = $item['name'];
                    $metro->distance = $item['distance'];
                    $metro->color = $item['color'];
                    $metro->divisionId = $this->id;
                    $metro->save();
                }
            }
        }

        return $boolean;
    }

    /**
     * @return string
     */
    public function getMetroListStr()
    {
        $metrolist = [];
        $list = $this->metros;
        if (is_array($list)) {
            foreach ($list as $metro) {
                $metrolist[] = $metro->name . ($metro->distance != '' ? ', ' . $metro->distance : '');
            }
        }

        return implode('; ', $metrolist);
    }

    /**
     * @return string
     */
    public function getRequisiteAnchorListStr()
    {
        $RequisiteList = [];
        $list = $this->requisites;
        if (is_array($list) && count($list) > 0) {
            foreach ($list as $requisite) {
                if ($requisite->getFile()) {
                    $RequisiteList[] = Html::a($requisite->name, $requisite->getFilePathUrl(), ['target' => '_blank']);
                }
            }
        }

        return implode('; ', $RequisiteList);
    }


    /**
     * @return DivisionQuery
     */
    public static function find()
    {
        return new DivisionQuery(get_called_class());
    }
}
