<?php

namespace app\modules\banner\widget\banner;

use app\modules\banner\models\Banner;
use app\modules\banner\models\BannerPublicationPlace;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\caching\TagDependency;
use yii\db\Expression;

/**
 * Виджет для вывода баннеров
 *
 * @property string $type
 * @property string $bannerLimit
 * @property string $pageType
 * @property array $bannerIds
 */
class BannerWidget extends Widget
{
    /**
     * @var int
     */
    public $bannerLimit = 3;
    /**
     * @var string
     */
    public $pageType;

    public $bannerIds = [];
    public $bannerColor = 'yellow';

    /**
     * @var Banner[]
     */
    protected $list = [];

    /**
     * @var string
     */
    public $template = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();


        if (is_null($this->pageType)) {
            throw new InvalidArgumentException('Option "pageType" must be set');
        }
        if (!$this->bannerLimit) {
            throw new InvalidArgumentException('Option "bannerLimit" must be set');
        }

        $key = [
            __METHOD__,
            __FILE__,
            __LINE__,
            $this->pageType,
            $this->bannerIds
        ];

        $dependency = new TagDependency([
            'tags' => [
                Banner::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {

            switch ($this->pageType) {
                case Banner::PUBLICATION_PLACE_MAIN_PAGE:
                    $query = Banner::find()
                        ->where([
                            Banner::ATTR_SHOWONINDEX => Banner::SHOW_ON_INDEX_YES,
                            Banner::ATTR_HIDDEN => Banner::HIDDEN_NO,
                        ]);

                    break;
                case Banner::PUBLICATION_PLACE_CONTENT:
                    $query = Banner::find()
                        ->where([
                            Banner::ATTR_HIDDEN => Banner::HIDDEN_NO,
                            Banner::ATTR_ID => $this->bannerIds
                        ]);
                    break;
                case Banner::PUBLICATION_PLACE_WHEREBUY:
                    $query = Banner::find()
                        ->where([
                            Banner::ATTR_SHOWONWHEREBUY => Banner::SHOW_ON_WHEREBUY_YES,
                            Banner::ATTR_HIDDEN => Banner::HIDDEN_NO,
                        ]);
                    break;
                default:
                    $query = Banner::find()
                        ->joinWith('bannerPublicationPlace', false, 'INNER JOIN')
                        ->where([
                            BannerPublicationPlace::tableName() . '.[[' . BannerPublicationPlace::ATTR_PLACE_ID . ']]' => $this->pageType,
                            Banner::tableName() . '.[[hidden]]' => Banner::HIDDEN_NO,
                        ])
                        ->orderBy([Banner::tableName() . '.[[position]]' => SORT_ASC]);
                    break;
            }

            $this->list = $query->orderBy(new Expression('RAND()'))
                ->limit($this->bannerLimit)
                ->all();

            Yii::$app->cache->set($key, $this->list, 600, $dependency);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        shuffle($this->list);

        return $this->render($this->template, [
            'list' => count($this->list) < 3 ? null : $this->list,
            'bannerColor' => $this->bannerColor,
        ]);
    }
}
