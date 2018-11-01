<?php

namespace app\modules\advice\widgets;

use yii\base\Widget;

/**
 * Class adviceWidget
 *
 * @package app\modules\advice\widgets
 */
class AdviceWidget extends Widget
{
    /**
     * @var array
     */
    public $adviceList;

    /**
     * @var string
     */
    public $className;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('advice', ['adviceList' => $this->adviceList, 'className' => $this->className]);
    }
}
