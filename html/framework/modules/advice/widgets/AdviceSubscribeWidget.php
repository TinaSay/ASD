<?php

namespace app\modules\advice\widgets;

use yii\base\Widget;
use app\modules\news\models\Subscribe;

/**
 * Class AdviceSubscribeWidget
 *
 * @package app\modules\advice\widgets
 */
class AdviceSubscribeWidget extends Widget
{
    /**
     * @var array
     */
    public $adviceList;

    /**
     * @var string
     */
    public $className;

    public $subscribeType;

    public $count = 0;

    /**
     * @return string
     */
    public function run(): string
    {

        if ($this->count <= 0) {
            $this->count = Subscribe::find()->count();
        }

        return $this->render('subscribe_form', [
            'adviceList' => $this->adviceList,
            'className' => $this->className,
            'subscribeType' => $this->subscribeType,
            'subscribersCount' => $this->count
        ]);
    }
}
