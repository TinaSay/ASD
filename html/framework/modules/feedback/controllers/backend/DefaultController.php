<?php

namespace app\modules\feedback\controllers\backend;

use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackSearch;
use app\modules\feedback\models\FeedbackSettings;
use krok\system\components\backend\Controller;
use yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
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
     * Lists all Feedback models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => new Feedback(),
        ]);
    }

    /**
     * Displays a single Feedback model.
     *
     * @param integer $id
     *
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
     * Displays a single Feedback model.
     *
     * @return string
     */
    public function actionSettings()
    {
        $callSettings = FeedbackSettings::find()->where(['name' => 'callsettings'])->one();
        $callSettings->value = Yii::$app->request->post('callsettings');
        $callSettings->save();

        $FeedbackSettings = new FeedbackSettings();
        $emailSettings = $FeedbackSettings->find()->where(['name' => 'emailsettings'])->one();
        $emailSettings->value = Yii::$app->request->post('emailsettings');
        $emailSettings->save();

        return $this->render('settings', [
            'list' => $FeedbackSettings->find()->all(),
        ]);
    }

    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
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
     * Deletes an existing Feedback model.
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

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
