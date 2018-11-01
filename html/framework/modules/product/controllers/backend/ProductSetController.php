<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductSet;
use app\modules\product\models\search\ProductSetSearch;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProductSetController implements the CRUD actions for ProductSet model.
 */
class ProductSetController extends Controller
{
    /**
     * Lists all ProductSet models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductSet model.
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
     * Finds the ProductSet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductSet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
