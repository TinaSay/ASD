<?php

namespace app\modules\system\widgets;

use app\modules\feedback\models\Feedback;
use yii\base\Widget;

/**
 * Class FeedbackCountWidget
 *
 * @package app\modules\system\widgets
 */
class FeedbackCountWidget extends Widget
{
    /**
     * @var string
     */
    public $name = 'feedback';


    public function run()
    {
        return $this->render($this->name, ['count' => Feedback::find()->where(['status' => Feedback::FSTATUS_NOT_PROCESSED])->count()]);
    }
}
