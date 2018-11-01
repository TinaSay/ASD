<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductSection;
use krok\extend\widgets\sortable\actions\UpdateAllAction;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * SectionController implements the CRUD actions for ProductSection model.
 */
class SectionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'update-all' => [
                'class' => UpdateAllAction::class,
                'model' => new ProductSection(),
                'items' => Yii::$app->request->post('item'),
            ],
        ];
    }

    /**
     * Lists all ProductSection models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'tree' => ProductSection::find()
                ->asTree(),
        ]);
    }

    /**
     * Displays a single ProductSection model.
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
     * Finds the ProductSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
