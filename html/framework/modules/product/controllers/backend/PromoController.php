<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductPromo;
use app\modules\product\models\search\ProductPromoSearch;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * PromoController implements the CRUD actions for ProductPromo model.
 */
class PromoController extends Controller
{
    /**
     * Lists all ProductPromo models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPromoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductPromo model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the ProductPromo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductPromo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPromo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
