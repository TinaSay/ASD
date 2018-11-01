<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\contact\controllers\backend;

use app\modules\contact\models\Division;
use app\modules\contact\models\Metro;
use app\modules\contact\models\Requisite;
use krok\system\components\backend\Controller;
use yii;
use yii\base\Model;
use yii\db\Transaction;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * DivisionController implements the CRUD actions for division model.
 */
class DivisionController extends Controller
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
     * Lists all division models.
     * @return mixed
     */
    public function actionIndex()
    {

        $list = Division::find()->orderBy(['position' => 'asc'])->asArray()->all();

        return $this->render('index', [
            'list' => $list,
        ]);
    }

    /**
     * Displays a single division model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new division model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws BadRequestHttpException
     * @throws yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Division();
        $models = $modelItem = [new Requisite()];

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('Requisite', []);
            foreach ($data as $i => $row) {
                $models[$i] = new Requisite();
                $models[$i]->file = UploadedFile::getInstance($models[$i], '[' . $i . ']file');
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }


        if ($model->load(Yii::$app->request->post())) {
            $count = count(Yii::$app->request->post('Requisite', []));
            for ($i = 1; $i < $count; $i++) {
                $modelItem[] = new Requisite();
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    if (Model::loadMultiple($modelItem, Yii::$app->request->post()) && Model::validateMultiple($modelItem)) {
                        foreach ($modelItem as $i => $newModel) {
                            $newModel->divisionId = $model->id;
                            $newModel->file = UploadedFile::getInstance($newModel, '[' . $i . ']file');
                            $newModel->save();
                        }

                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        }

        $hiddenList = Division::getHiddenList();
        return $this->render('create', [
            'model' => $model,
            'models' => $models,
            'hiddenList' => $hiddenList,
        ]);


    }

    /**
     * Updates an existing division model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelItem = Requisite::find()->where(['divisionId' => $id])->all();
        if ($modelItem == null) {
            $modelItem = [new Requisite()];
        }

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) { // Ajax Tabular Validations
            $data = Yii::$app->request->post('Requisite', []);
            $models = [];
            foreach ($data as $i => $row) {
                $models[$i] = new Requisite();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    $post = Yii::$app->request->post('Requisite', []);

                    if (!empty($modelItem)) {
                        foreach ($modelItem as $k => $row) {
                            if (!isset($post[$k]) && isset($row->id)) {
                                $row->delete();
                                unset($modelItem[$k]);
                            }
                        }
                    }

                    foreach ($post as $i => $field) {

                        if (!isset($modelItem[$i])) {
                            $modelItem[$i] = new Requisite();
                        }

                        if (UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file') !== null) {
                            $modelItem[$i]->setFile(UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file'));
                        }
                        $modelItem[$i]->name = $field['name'];

                    }

                    foreach ($modelItem as $i => $newModel) {
                        $newModel->divisionId = $model->id;
                        $newModel->save();
                    }

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        }

        $hiddenList = Division::getHiddenList();
        return $this->render('update', [
            'model' => $model,
            'hiddenList' => $hiddenList,
            'models' => $modelItem
        ]);


    }


    /**
     * @throws \yii\db\Exception
     */
    public function actionUpdatePosition()
    {
        $position = 0;
        $items = Yii::$app->getRequest()->post('item', []);

        if (is_array($items)) {
            foreach ($items as $id) {
                $model = Division::findOne($id);
                $model->setAttribute('position', ++$position);
                if (!$model->save()) {
                    throw new yii\db\Exception('', $model->getErrors());
                }
            }
        }
    }

    /**
     * Deletes an existing division model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionMetroDelete()
    {
        $metro = Metro::findOne(Yii::$app->request->post('metro_id'));
        if ($metro && $metro->delete()) return true;
        return false;
    }

    public function actionRequisiteDelete()
    {
        $Requisite = Requisite::findOne(Yii::$app->request->post('requisite_id'));
        if ($Requisite && $Requisite->delete()) return true;
        return false;
    }


    public function actionGetMetroList()
    {
        $term = Yii::$app->request->get('term');
        $list = array();
        $xmlstr = file_get_contents(Yii::getAlias('@root') . '/static/asd/data/metro-moscow.xml');
        $metro = new \SimpleXMLElement($xmlstr);
        foreach ($metro as $location) {
            $locationString = (string)$location;
            $locationString = mb_strtolower($locationString);
            $term = mb_strtolower($term);
            if (stripos($locationString, $term) !== false) {
                $id = (int)$location['id'];
                $list[$id] = (string)$location;
            }
        }
        return json_encode($list);
    }

    /**
     * Finds the division model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return division the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Division::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
