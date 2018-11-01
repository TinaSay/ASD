<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductClientCategory;
use app\modules\product\models\search\ProductClientCategorySearch;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ClientCategoryController implements the CRUD actions for ProductClientCategory model.
 */
class ClientCategoryController extends Controller
{
    /**
     * Lists all ProductClientCategory models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductClientCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductClientCategory model.
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
     * Finds the ProductClientCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductClientCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductClientCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
