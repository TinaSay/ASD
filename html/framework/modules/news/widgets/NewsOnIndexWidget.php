<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\news\widgets;

use app\modules\contact\models\Network;
use app\modules\news\models\News;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Class NewsWidget
 *
 * @package app\modules\news\widgets
 */
class NewsOnIndexWidget extends Widget
{
    /**
     * @var array
     */
    protected $newslist;

    /**
     * @var Network[]
     */
    protected $networkList;

    /**
     * @var string - css class name
     */
    public $className;


    public function init()
    {
        parent::init();

        $key = [
            __METHOD__,
            __FILE__,
            __LINE__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                News::class,
                Network::class,
            ],
        ]);

        if (($data = Yii::$app->cache->get($key)) === false) {
            $this->newslist = News::find()->joinWith('groupRelation', true)
                ->where([News::tableName() . '.[[hidden]]' => News::HIDDEN_NO])
                ->limit(3)
                ->orderBy([News::tableName() . '.[[createdAt]]' => SORT_DESC])
                ->all();
            $this->networkList = Network::getList();

            $data = [$this->newslist, $this->networkList];

            Yii::$app->cache->set($key, $data, null, $dependency);
        } else {
            list($this->newslist, $this->networkList) = $data;
        }
    }

    /**
     * @return string
     */
    public function run(): string
    {

        return $this->render('news-index', [
            'newslist' => $this->newslist,
            'className' => $this->className,
            'networkList' => $this->networkList,
        ]);
    }
}
