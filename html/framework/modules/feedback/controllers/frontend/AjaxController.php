<?php
/**
 * Created by PhpStorm.
 * User: Rustam
 * Date: 10.05.2018
 * Time: 16:05
 */

namespace app\modules\feedback\controllers\frontend;


use krok\system\components\frontend\Controller;
use yii\web\View;
use yii\base\Event;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class AjaxController extends Controller
{

    public function actionCooperation()
    {
        // task 37762
        Event::on(View::class, View::EVENT_AFTER_RENDER, function ($e) {
            $e->sender->assetBundles = [];
        });
        $life_time = 1 * 60 * 60; // кешируем на 1 час
        \Yii::$app->getResponse()->getHeaders()->set('Expires', gmdate('D, d M Y H:i:s', time() + $life_time) . ' GMT');
        return $this->renderAjax('cooperation');
    }

}
