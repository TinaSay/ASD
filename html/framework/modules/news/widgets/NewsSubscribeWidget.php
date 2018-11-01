<?php

namespace app\modules\news\widgets;

use yii\base\Widget;

/**
 * Class NewsSubscribeWidget
 *
 * @package app\modules\news\widgets
 */
class NewsSubscribeWidget extends Widget
{
    /**
     * @var array
     */
    public $newslist;

    /**
     * @var string
     */
    public $className;

    public $subscribeType;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('subscribe_form', ['newslist' => $this->newslist, 'className' => $this->className, 'subscribeType' => $this->subscribeType]);
    }
}
