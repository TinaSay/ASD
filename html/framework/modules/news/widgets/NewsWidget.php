<?php

namespace app\modules\news\widgets;

use yii\base\Widget;

/**
 * Class NewsWidget
 *
 * @package app\modules\news\widgets
 */
class NewsWidget extends Widget
{
    /**
     * @var array
     */
    public $newslist;

    /**
     * @var string
     */
    public $className;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('news', ['newslist' => $this->newslist, 'className' => $this->className]);
    }
}
