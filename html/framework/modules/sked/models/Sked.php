<?php

namespace app\modules\sked\models;

use app\modules\auth\models\Auth;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TagDependencyBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sked}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $route
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdBy
 * @property integer $hidden
 *
 * @property Item[] $items
 * @property Auth $createdBy0
 */
class Sked extends ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    const ROUTE_CONTENT = 1;


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
        return '{{%sked}}';
    }

    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
            'CreatedByBehavior' => CreatedByBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['createdBy', 'hidden'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['route'], 'string', 'max' => 100],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::class, 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => \Yii::t('system', 'Title'),
            'route' => \Yii::t('system', 'Route'),
            'createdAt' => \Yii::t('system', 'Created At'),
            'updatedAt' => \Yii::t('system', 'Updated At'),
            'createdBy' => \Yii::t('system', 'Created By'),
            'hidden' => \Yii::t('system', 'Hidden'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['skedId' => 'id']);
    }

    /**
     * @return string
     */
    public function getItemFileListStr()
    {
        $ItemList = [];
        $list = $this->getItems();
        if (is_array($list) && count($list) > 0) {
            /** @var Item $item */
            foreach ($list as $item) {
                if ($item->getFile()) {
                    $ItemList[] = Html::a($item->name, $item->getFilePathUrl(), ['target' => '_blank']);
                }
            }
        }
        return (count($ItemList) > 0 ? implode('; ', $ItemList) : 'Не добавлено');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Auth::class, ['id' => 'createdBy']);
    }

    public function getRouteList()
    {
        return [
            self::ROUTE_CONTENT => 'Типовые страницы',
        ];
    }

    public function getDefaultRoute()
    {
        return self::ROUTE_CONTENT;
    }

    /**
     * @inheritdoc
     * @return SkedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SkedQuery(get_called_class());
    }

    public function getItemAsComma()
    {
        $list = ArrayHelper::map($this->getItems()->all(), 'id', 'title');
        return (count($list) > 0 ? implode('; ', $list) : 'Не добавлено');
    }

    public function getRoute()
    {
        return ArrayHelper::getValue($this->getRouteList(), $this->route);
    }

}
