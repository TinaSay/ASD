<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 27.08.15
 * Time: 18:36
 */

namespace app\modules\auth\components;

use app\modules\auth\models\Log;
use yii\db\Exception;
use yii\web\UserEvent;

/**
 * Class UserEventHandler
 *
 * @package app\modules\auth\components
 */
class UserEventHandler
{
    /**
     * @param UserEvent $event
     *
     * @throws \yii\db\Exception
     */
    public static function handleAfterLogin(UserEvent $event)
    {
        $model = new Log([
            'auth_id' => $event->identity->getId(),
            'status' => Log::STATUS_LOGGED,
        ]);
        if (!$model->save()) {
            throw new Exception('Ошибка записи в журнал', $model->getErrors());
        }
    }

    /**
     * @param UserEvent $event
     *
     * @throws \yii\db\Exception
     */
    public static function handleAfterLogout(UserEvent $event)
    {
        $model = new Log([
            'auth_id' => $event->identity->getId(),
            'status' => Log::STATUS_LOGOUT,
        ]);
        if (!$model->save()) {
            throw new Exception('Ошибка записи в журнал', $model->getErrors());
        }
    }
}
