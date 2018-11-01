<?php

namespace app\modules\sked\controllers\backend;

use app\modules\sked\models\Item;
use app\modules\sked\models\Sked;
use app\modules\sked\models\SkedSearch;
use krok\system\components\backend\Controller;
use Yii;
use yii\base\Model;
use yii\db\Transaction;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * ManageController implements the CRUD actions for Sked model.
 */
class ManageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sked models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sked model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sked model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Sked();

        $models = $modelItem = [new Item()];

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->isAjax) {
            $data = Yii::$app->request->post('Item', []);
            foreach ($data as $i => $row) {
                $models[$i] = new Item();
                $models[$i]->file = UploadedFile::getInstance($models[$i], '[' . $i . ']file');
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);

            $model->load(Yii::$app->request->post());
            $resultParent = ActiveForm::validate($model);
            return ArrayHelper::merge($result, $resultParent);
        }


        if ($model->load(Yii::$app->request->post())) {
            $count = count(Yii::$app->request->post('Item', []));
            for ($i = 1; $i < $count; $i++) {
                $modelItem[] = new Item();
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    if (Model::loadMultiple($modelItem, Yii::$app->request->post())) {
                        foreach ($modelItem as $i => $newModel) {
                            $newModel->skedId = $model->id;
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

        return $this->render('create', ['model' => $model, 'models' => $models]);
    }

    /**
     * Updates an existing Sked model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelItem = $model->getItems()->all();
        if ($modelItem == null) {
            $modelItem = [new Item()];
        }

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) { // Ajax Tabular Validations
            $data = Yii::$app->request->post('Item', []);
            $models = [];
            foreach ($data as $i => $row) {
                $models[$i] = new Item();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);

            $model->load(Yii::$app->request->post());
            $resultParent = ActiveForm::validate($model);
            return ArrayHelper::merge($result, $resultParent);
        }

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    $post = Yii::$app->request->post('Item', []);

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
                            $modelItem[$i] = new Item();
                        }

                        if (UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file') !== null) {
                            $modelItem[$i]->setFile(UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file'));
                        }
                        $modelItem[$i]->title = $field['title'];
                        $modelItem[$i]->description = $field['description'];
                        $modelItem[$i]->btnLink = $field['btnLink'];
                        $modelItem[$i]->btnText = $field['btnText'];
                        $modelItem[$i]->skedId = $model->id;
                        $modelItem[$i]->save();

                    }
                    /*
                                        foreach ($modelItem as $i => $newModel) {
                                            $newModel->skedId = $model->id;
                                            $newModel->save();
                                        }
                    */
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


        return $this->render('update', [
            'model' => $model,
            'models' => $modelItem
        ]);
    }

    /**
     * Deletes an existing Sked model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionItemDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $item = Item::findOne($id);
        if ($item && $item->delete()) return true;
        return false;
    }

    /**
     * Finds the Sked model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sked the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sked::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
