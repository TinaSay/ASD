<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductUsage;
use krok\extend\widgets\sortable\actions\UpdateAllAction;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UsageController implements the CRUD actions for ProductUsage model.
 */
class UsageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'update-all' => [
                'class' => UpdateAllAction::class,
                'model' => new ProductUsage(),
                'items' => Yii::$app->request->post('item'),
            ],
        ];
    }

    /**
     * Lists all ProductUsage models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'tree' => ProductUsage::find()
                ->orderBy(['position' => SORT_ASC])
                ->asArray()->all(),
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single ProductUsage model.
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
     * Finds the ProductUsage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductUsage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductUsage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
