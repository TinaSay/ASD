<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 15.02.18
 * Time: 11:39
 */

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductPage;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PageController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = ProductPage::find()->one();

        return $this->render('index', ['model' => $model]);
    }

    /**
     * @param $id
     *
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return null|static|ProductPage
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ProductPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}