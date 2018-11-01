<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.05.18
 * Time: 12:49
 */

namespace app\modules\contact\widgets;

use app\modules\contact\models\Network;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

class FooterSocialsWidget extends Widget
{

    /**
     * @var Network[]
     */
    protected $list;

    /**
     * @inheritdoc
     */
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
                Network::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {
            $this->list = Network::getList();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('socials', ['list' => $this->list]);
    }
}