<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 19.07.17
 * Time: 18:22
 */

namespace app\modules\auth\controllers\backend;

use app\modules\auth\models\Profile;
use krok\system\components\backend\Controller;
use Yii;

/**
 * Class ProfileController
 *
 * @package app\modules\auth\controllers\backend
 */
class ProfileController extends Controller
{
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = $this->findModel();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => \Yii::t('system', 'Your profile password saved.')
            ]);
            return $this->redirect(['index']);
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * @return Profile
     */
    protected function findModel()
    {
        return Profile::findOne(Yii::$app->getUser()->getIdentity()->getId());
    }
}
