<?php

namespace app\modules\system\widgets;

use app\modules\auth\models\Auth;
use app\modules\auth\models\Log;
use Yii;
use yii\base\Widget;


/**
 * Class WelcomeWidget
 *
 * @package app\modules\system\widgets
 */
class WelcomeWidget extends Widget
{
    /**
     * @var string
     */
    public $name = 'welcome';


    public function run()
    {
        $user = Auth::findOne(Yii::$app->getUser()->getId());
        $lastTwoRecords = Log::find()->where(['auth_id' => $user->getId(), 'status' => Log::STATUS_LOGGED])->orderBy(['id' => SORT_DESC])->limit(2)->all();
        $authLog = array_pop($lastTwoRecords);
        return $this->render($this->name, ['user' => $user, 'authLog' => $authLog]);
    }
}
