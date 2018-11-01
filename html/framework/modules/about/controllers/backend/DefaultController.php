<?php

namespace app\modules\about\controllers\backend;

use app\modules\about\forms\AboutForm;
use app\modules\about\models\About;
use krok\extend\widgets\sortable\actions\UpdateAllAction;
use krok\system\components\backend\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for About model.
 */
class DefaultController extends Controller
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
                'model' => new About(),
                'items' => Yii::$app->request->post('item'),
            ],
        ];
    }

    /**
     * Lists all About models.
     * @return mixed
     */
    public function actionIndex()
    {
        $items = About::find()->asArray()->orderBy(['position' => SORT_ASC])->all();

        return $this->render('index', [
                    'items' => $items,
        ]);
    }

    /**
     * Displays a single About model.
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
     * Creates a new About model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AboutForm();
        if ($model->load(Yii::$app->request->post())) {
            $save = $model->save();
            if ($save) {
                return $this->redirect(['view', 'id' => $save->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing About model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new AboutForm($this->findModel($id));
        if ($model->load(Yii::$app->request->post())) {
            $save = $model->save();
            if ($save) {
                return $this->redirect(['view', 'id' => $save->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing About model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the About model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return About the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = About::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionRemoveFile(int $id, string $attribute)
    {
        $model = $this->findModel($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($model !== null && $file = Yii::$app->request->post('key')) {

            if ($model->deleteFile($model, $file, $attribute) !== false) {
                return ['success' => 'Файл успешно удален'];
            } else {
                return ['error' => 'Ошибка удаления файла'];
            }
        }
    }
}
