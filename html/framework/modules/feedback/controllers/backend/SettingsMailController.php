<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 13.02.18
 * Time: 18:02
 */

namespace app\modules\feedback\controllers\backend;

use app\modules\feedback\form\SettingsMailForm;
use krok\system\components\backend\Controller;
use Yii;
use yii\filters\VerbFilter;

class SettingsMailController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SettingsNotification models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $settingsMail = new SettingsMailForm();
        $settingsMail->loadSettings();

        return $this->render('index', [
            'model' => $settingsMail,
        ]);
    }

    /**
     * Updates an existing SettingsNotification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionUpdate()
    {

        $settingsMail = new SettingsMailForm();
        $settingsMail->loadSettings();

        if ($settingsMail->load(Yii::$app->request->post()) && $settingsMail->saveSettings()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $settingsMail,
            ]);
        }
    }
}
