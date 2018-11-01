<?php

namespace app\modules\brand\controllers\backend;

use app\modules\brand\models\Brand;
use app\modules\product\models\ProductBrand;
use krok\extend\widgets\sortable\actions\UpdateAllAction;
use krok\system\components\backend\Controller;
use Yii;
use yii\web\Response;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
            'update-position' => [
                'class' => UpdateAllAction::class,
                'model' => new Brand(),
                'items' => Yii::$app->request->post('item'),
            ],
        ];
    }

    /**
     * Lists all Brand models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $items = Brand::find()->asArray()->orderBy(['position' => SORT_ASC])->all();

        return $this->render('index', [
            'items' => $items,
        ]);
    }

    /**
     * Displays a single Brand model.
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
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->productBrandId) {
                $brandModel = ProductBrand::findOne(['id' => $model->productBrandId]);
                if ($brandModel) {
                    $brandModel->setScenario(ProductBrand::SCENARIO_SET_BRAND);
                    $brandModel->brandId = $model->id;
                    $brandModel->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->productBrandId = ProductBrand::find()->select('id')->where([
            'brandId' => $id
        ])->scalar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->productBrandId) {
                $brandModel = ProductBrand::findOne(['id' => $model->productBrandId]);
                if ($brandModel && $brandModel->brandId != $model->id) {
                    $brandModel->setScenario(ProductBrand::SCENARIO_SET_BRAND);
                    $brandModel->brandId = $model->id;
                    $brandModel->save();
                }
            } else {
                ProductBrand::updateAll([
                    'brandId' => new Expression('NULL'),
                ], ['brandId' => $model->id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Brand model.
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
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
