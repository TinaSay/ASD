<?php

namespace app\modules\packet\models;

use app\modules\auth\models\Auth;
use app\modules\feedback\models\Feedback;
use app\modules\news\models\Subscribe;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\storage\dto\StorageDto;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for table "{{%packet}}".
 *
 * @property integer $id
 * @property string $subject
 * @property integer $category
 * @property string $text
 * @property integer $byRegion
 * @property integer $sent
 * @property string $createdAt
 * @property string $updatedAt
 * @property integer $createdBy
 * @property string $sendAt
 * @property string $country
 * @property string $city
 * @property array $recipients
 */
class Packet extends \yii\db\ActiveRecord
{

    const CATEGORY_NEWS = 1;
    const CATEGORY_ADVICE = 2;
    const CATEGORY_FEEDBACK = 3;
    const CATEGORY_PRODUCT = 4;

    const BY_REGION_NO = 0;
    const BY_REGION_YES = 1;

    const STATUS_SENT_NO = 0;
    const STATUS_SENT_YES = 1;


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
        return '{{%packet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['text'], 'string'],
            [['text'], 'required'],
            [['subject', 'country'], 'string', 'max' => 255],
            [
                ['createdBy'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Auth::class,
                'targetAttribute' => ['createdBy' => 'id'],
            ],
            [['createdAt', 'updatedAt', 'sendAt'], 'safe'],
            [['city', 'category', 'byRegion'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CreatedByBehavior' => CreatedByBehavior::class,
            'TimestampBehavior' => TimestampBehavior::class,

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Заголовок',
            'category' => 'Категории',
            'text' => 'Текст',
            'byRegion' => 'Рассылка по регионам',
            'sent' => 'Отправлено',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
            'createdBy' => 'Автор',
            'sendAt' => 'Дата рассылки',
            'files' => 'Файлы',
            'country' => 'Страна',
            'city' => 'Город',
            'recipients' => 'Количество получателей',
        ];
    }

    /**
     * @return array
     */
    public static function getCategoryList()
    {
        return [
            self::CATEGORY_NEWS => 'Новости',
            self::CATEGORY_ADVICE => 'Советы',
            self::CATEGORY_FEEDBACK => 'Обратная связь',
            self::CATEGORY_PRODUCT => 'Заказ товара',
        ];
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return ArrayHelper::getValue(self::getCategoryList(), $this->category);
    }


    /**
     * @return ActiveQuery
     */
    public function getPacketFiles()
    {
        return $this->hasMany(PacketFile::class, ['packetId' => 'id']);
    }

    /**
     * @return array
     */
    public static function getByRegionList()
    {
        return [
            self::BY_REGION_NO => 'Нет',
            self::BY_REGION_YES => 'Да',

        ];
    }

    /**
     * @return array
     */
    public function getByRegion()
    {
        return ArrayHelper::getValue(self::getByRegionList(), $this->byRegion);
    }

    /**
     * @return array
     */
    public static function getStatusSentList()
    {
        return [
            self::STATUS_SENT_NO => 'Нет',
            self::STATUS_SENT_YES => 'Да',

        ];
    }

    /**
     * @return array
     */
    public function getStatusSent()
    {
        return ArrayHelper::getValue(self::getStatusSentList(), $this->sent);
    }

    /**
     * @return string
     * @var $PacketFile PacketFile
     * @throws \yii\base\InvalidConfigException
     */
    public function getPacketFilesAnchorListStr()
    {
        $PacketFileList = [];
        $list = $this->getPacketFiles()->all();
        if (is_array($list) && count($list) > 0) {
            /** @var PacketFile $PacketFile */
            foreach ($list as $PacketFile) {
                if ($PacketFile->file instanceof StorageDto) {
                    $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);
                    $PacketFileList[] = Html::a($PacketFile->name,
                        $filesystem->getDownloadUrl($PacketFile->file->getSrc()),
                        ['options' => ['target' => '_blank']]);
                }
            }
        }
        return implode('; ', $PacketFileList);
    }

    /**
     * @return \app\modules\news\models\SubscribeQuery|int|ActiveQuery
     */
    public function getRecipientQuery()
    {
        $query = null;
        $select = ['id', 'email', 'country', 'city', 'unsubscribe'];
        switch ($this->category) {
            case self::CATEGORY_NEWS:
                $query = Subscribe::find()->select($select)->where(" `email`<>'' ")
                    ->andWhere(['type' => [Subscribe::TYPE_SUBSCRIBE_NEWSCARD, Subscribe::TYPE_SUBSCRIBE_NEWSLIST]])
                    ->andWhere(['unsubscribe' => 0]);
                break;
            case self::CATEGORY_ADVICE:
                $query = Subscribe::find()->select($select)->where(" `email`<>'' ")
                    ->andWhere(['type' => [Subscribe::TYPE_SUBSCRIBE_ADVICECARD, Subscribe::TYPE_SUBSCRIBE_ADVICELIST]])
                    ->andWhere(['unsubscribe' => 0]);
                break;
            case self::CATEGORY_FEEDBACK:
                $query = Feedback::find()->select($select)->where(" `email`<>'' ")
                    ->andWhere(['msg_type' => Feedback::FTYPE_MESSAGE])
                    ->andWhere(['unsubscribe' => 0]);
                break;
            case self::CATEGORY_PRODUCT:
                $query = Feedback::find()->select($select)->where(" `email`<>'' ")
                    ->andWhere(['msg_type' => Feedback::FTYPE_ORDER])
                    ->andWhere(['unsubscribe' => 0]);
                break;
        }

        if ($this->byRegion > 0 && !empty($this->country) && !empty($this->city)) {
            $city = explode('; ', $this->city); // look at https://github.com/lordfriend/nya-bootstrap-select/issues/5
            $query->andWhere(['country' => $this->country, 'city' => $city]);
        }

        return $query;
    }

    public function getRecipients()
    {
        $query = $this->getRecipientQuery();
        //return $query->createCommand()->getRawSql();
        if ($query instanceof ActiveQuery) {
            return $query->count();
        } else {
            return 0;
        }
    }

    /**
     * @param $country
     *
     * @param Packet|null $model
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCityListById($country, $category, $model = null)
    {

        $list = [];
        $subscribeQuery = Subscribe::find()
            ->select('city')
            ->distinct()
            ->where(['!=', 'city', ''])
            ->andWhere(['country' => $country]);

        $feedbackQuery = Feedback::find()
            ->select('city')
            ->distinct()
            ->where(['!=', 'city', ''])
            ->andWhere(['country' => $country]);

        if ($category) {
            $list = self::getQueryByCategory($category, $subscribeQuery, $feedbackQuery)->asArray()->all();
        }

        if ($model) {
            $citylist = explode('; ', $model->city); // look at https://github.com/lordfriend/nya-bootstrap-select/issues/5
            foreach ($list as $key => $item) {
                if (ArrayHelper::isIn($item['city'], $citylist)) {
                    $list[$key]['selected'] = true;
                } else $list[$key]['selected'] = false;
            }
        }
        return $list;
    }

    /**
     * @param $category
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCountryList($category = null)
    {
        $list = [];
        $subscribeQuery = Subscribe::find()
            ->select('country')
            ->distinct()
            ->where(['!=', 'city', ''])
            ->andWhere(['!=', 'country', '']);

        $feedbackQuery = Feedback::find()
            ->select('country')
            ->distinct()
            ->where(['!=', 'city', ''])
            ->andWhere(['!=', 'country', '']);

        if ($category) {
            $list = self::getQueryByCategory($category, $subscribeQuery, $feedbackQuery)->all();
        }

        return $list;
    }

    /**
     * @param $category integer
     * @param $subscribeQuery ActiveQuery
     * @param $feedbackQuery ActiveQuery
     * @return ActiveQuery $query ActiveQuery
     */
    public static function getQueryByCategory($category, $subscribeQuery, $feedbackQuery)
    {
        switch ($category) {
            case self::CATEGORY_NEWS:
                $query = $subscribeQuery->andWhere(['type' => [Subscribe::TYPE_SUBSCRIBE_NEWSCARD, Subscribe::TYPE_SUBSCRIBE_NEWSLIST]]);
                break;
            case self::CATEGORY_ADVICE:
                $query = $subscribeQuery->andWhere(['type' => [Subscribe::TYPE_SUBSCRIBE_ADVICECARD, Subscribe::TYPE_SUBSCRIBE_ADVICELIST]]);
                break;
            case self::CATEGORY_FEEDBACK:
                $query = $feedbackQuery->andWhere(['msg_type' => Feedback::FTYPE_MESSAGE]);
                break;
            case self::CATEGORY_PRODUCT:
                $query = $feedbackQuery->andWhere(['msg_type' => Feedback::FTYPE_ORDER]);
                break;
            default:
                $query = $subscribeQuery->andWhere(['type' => [Subscribe::TYPE_SUBSCRIBE_NEWSCARD, Subscribe::TYPE_SUBSCRIBE_NEWSLIST]]);
                break;
        }
        return $query;
    }

    /**
     * @inheritdoc
     * @return PacketQuery the active query used by this AR class.
     */
    public
    static function find()
    {
        return new PacketQuery(get_called_class());
    }
}
