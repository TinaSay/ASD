<?php

namespace app\modules\advice\widgets;

use yii\base\Widget;

/**
 * Class adviceWidget
 *
 * @package app\modules\advice\widgets
 */
class AdviceBigWidget extends Widget
{
    /**
     * @var array
     */
    public $advice;

    /**
     * @var string
     */
    public $className;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('advice-big', ['advice' => $this->advice, 'className' => $this->className]);
    }
}
