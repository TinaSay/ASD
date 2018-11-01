<?php

namespace app\modules\about\forms;

use Yii;
use yii\base\Model;
use app\modules\about\models\About;
use app\modules\banner\models\Banner;
use yii\helpers\ArrayHelper;
use krok\extend\interfaces\BlockedAttributeInterface;
use krok\extend\traits\BlockedAttributeTrait;
use yii\web\UploadedFile;
use app\modules\about\models\AboutBanner;
use tina\metatag\behaviors\MetatagBehavior;

/**
 * This is the model class for table "{{%about}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property file $mainVideo
 * @property string $titleForImage
 * @property string $descriptionImage
 * @property string $titleForBanners
 * @property string $titleAdditionalBlock
 * @property string $additionalDescription
 * @property string $urlYoutubeVideo
 * @property boolean $publicHistory
 * @property boolean $publishAnApplication
 * @property boolean $blocked
 * @property array $banners
 * @property image $image
 * @property image $additionalImage
 * @property About $model
 *
 * @property AboutBanner[] $aboutBanners
 */
class AboutForm extends Model implements BlockedAttributeInterface
{
    use BlockedAttributeTrait;

    public $meta;

    public $id;
    public $title;
    public $description;
    public $mainVideo;
    public $titleForImage;
    public $descriptionImage;
    public $titleForBanners;
    public $titleAdditionalBlock;
    public $additionalDescription;
    public $urlYoutubeVideo;
    public $publicHistory;
    public $publishAnApplication;
    public $blocked;
    public $banners;
    public $image;
    public $additionalImage;
    public $model;
    public $createdAt;
    public $updatedAt;

    public function behaviors()
    {
        return [
            'MetatagBehavior' => [
                'class' => MetatagBehavior::class,
                'metaAttribute' => 'meta',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function __construct($model = null)
    {
        if (!$model) {
            $this->model = new About();
        } else {
            $this->model = $model;
            $this->attributes = $model->attributes;
            $this->banners = $this->model->banners;
        }
    }

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
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['urlYoutubeVideo'], 'url'],
            [['description', 'additionalDescription'], 'string'],
            [['publicHistory', 'publishAnApplication', 'blocked'], 'boolean'],
            [['createdAt', 'updatedAt', 'banners'], 'safe'],
            [['banners'], 'each', 'rule' => ['integer']],
            [
                [
                    'title',
                    'titleForImage',
                    'descriptionImage',
                    'titleForBanners',
                    'titleAdditionalBlock',
                    'urlYoutubeVideo',
                ],
                'string',
                'max' => 255,
            ],
            [
                ['image'],
                'image',
                'extensions' => 'jpg, png',
                'skipOnEmpty' => true,
                'minWidth' => 340,
                'minHeight' => 340,
            ],
            [['additionalImage'], 'image', 'extensions' => 'jpg, png', 'skipOnEmpty' => true],
            [['mainVideo'], 'file', 'extensions' => 'mp4, ogv, webm', 'skipOnEmpty' => true],
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
            'description' => 'Описание',
            'image' => 'Изображение',
            'mainVideo' => 'Основное видео',
            'titleForImage' => 'Название к изображению',
            'descriptionImage' => 'Подпись к изображению',
            'titleForBanners' => 'Заголовок к баннерам',
            'banners' => 'Баннеры',
            'titleAdditionalBlock' => 'Заголовок дополнительного блока',
            'additionalDescription' => 'Дополнительное описание',
            'additionalImage' => 'Дополнительное изображение',
            'urlYoutubeVideo' => 'Ссылка на youtube-видео',
            'publicHistory' => 'Публикация истории',
            'publishAnApplication' => 'Публикация заявки',
            'blocked' => 'Заблокирован',
        ];
    }

    /**
     * Сохраняет данные из формы в базу
     *
     * @return boolean|About
     */
    public function save()
    {
        $data = $this->attributes;
        $model = $this->model;
        $model->setAttributes($data);
        $model->setImage(UploadedFile::getInstance($this, 'image'));
        $model->setAdditionalImage(UploadedFile::getInstance($this, 'additionalImage'));
        $model->setMainVideo(UploadedFile::getInstance($this, 'mainVideo'));
        if (!$model->save()) {
            return false;
        }
        $this->createRelations($model->id, $this->banners);
        return $model;
    }

    /**
     * создает связь между записями о компании и быннерами
     *
     * @param array|integer $aboutIds
     * @param array|integer $bannerIds
     *
     * @return boolean
     */
    public function createRelations($aboutIds, $bannerIds)
    {
        if (empty($aboutIds) || empty($bannerIds)) {
            return;
        }
        if (!is_array($aboutIds)) {
            $aboutIds = [$aboutIds];
        }
        if (!is_array($bannerIds)) {
            $bannerIds = [$bannerIds];
        }
        foreach ($bannerIds as $banner) {
            foreach ($aboutIds as $about) {
                $rows[] = [$banner, $about];
            }
        }
        if (empty($rows)) {
            return;
        }
        AboutBanner::deleteAll(['aboutId' => $aboutIds]);
        Yii::$app->db->createCommand()
            ->batchInsert(AboutBanner::tableName(), ['bannerId', 'aboutId'], $rows)
            ->execute();
        return true;
    }

    /**
     * Проверяет новая ли запись в базе
     *
     * @return bool
     */
    public function isNewRecord(): bool
    {
        return $this->model->isNewRecord;
    }

    public function getBannersList()
    {
        $banners = Banner::find()->where(['hidden' => Banner::BANNER_HIDDEN_NO])->all();
        return ArrayHelper::map($banners, 'id', 'title');
    }


}
