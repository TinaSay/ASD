<?php

namespace app\modules\promoBlock\controllers\backend;

use app\modules\promoBlock\models\PromoBlock;
use krok\extend\widgets\sortable\actions\UpdateAllAction;
use krok\system\components\backend\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * PromoController implements the CRUD actions for PromoBlock model.
 */
class PromoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'update-all' => [
                'class' => UpdateAllAction::class,
                'model' => new PromoBlock(),
                'items' => Yii::$app->request->post('items'),
            ],
        ];
    }

    /**
     * Lists all PromoBlock models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $promoBlockItems = PromoBlock::getItemList();

        return $this->render('index', [
            'promoBlockItems' => $promoBlockItems,
        ]);
    }

    /**
     * Displays a single PromoBlock model.
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
     * Creates a new PromoBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PromoBlock();

        if ($model->load(Yii::$app->request->post())) {
            $model->setScenario($model::IMAGE_TYPE_SCENARIO[$model->imageType]);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PromoBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->setScenario($model::IMAGE_TYPE_SCENARIO[$model->imageType]);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PromoBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PromoBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return PromoBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromoBlock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
