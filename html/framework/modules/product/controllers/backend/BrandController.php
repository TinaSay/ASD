<?php

namespace app\modules\product\controllers\backend;

use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductBrandBlock;
use app\modules\product\models\search\ProductBrandSearch;
use krok\system\components\backend\Controller;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

/**
 * BrandController implements the CRUD actions for ProductBrand model.
 */
class BrandController extends Controller
{

    /**
     * Lists all ProductBrand models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductBrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductBrand model.
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
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $blockList = ProductBrandBlock::find()->where([
            'brandId' => $model->id,
        ])->all();

        if (count($blockList) < 3) {
            for ($i = count($blockList); $i < 3; $i++) {
                array_push($blockList, new ProductBrandBlock([
                    'brandId' => $model->id,
                ]));
            }
        }

        if (Yii::$app->request->getIsPost()) {
            Model::loadMultiple($blockList, Yii::$app->request->post());
            foreach ($blockList as $block) {
                $block->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'blockList' => $blockList,
        ]);
    }

    /**
     * Finds the ProductBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ProductBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductBrand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
