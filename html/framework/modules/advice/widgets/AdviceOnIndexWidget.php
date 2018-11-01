<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\advice\widgets;

use app\modules\advice\models\Advice;
use yii\base\Widget;
use app\modules\contact\models\Network;

/**
 * Class AdviceOnIndexWidget
 *
 * @package app\modules\advice\widgets
 */
class AdviceOnIndexWidget extends Widget
{
    /**
     * @var array
     */
    public $adviceList;

    public $networkList;

    /**
     * @var string
     */
    public $className;

    /**
     * @return string
     */
    public function run(): string
    {
        if (count($this->adviceList) <= 0) {
            $this->adviceList = Advice::find()->where(['hidden' => Advice::HIDDEN_NO])->limit(3)->orderBy(['createdAt' => 'desc'])->all();
        }

        $this->networkList = Network::getList();

        return $this->render('advice-index', ['adviceList' => $this->adviceList, 'className' => $this->className, 'networkList' => $this->networkList]);
    }
}
