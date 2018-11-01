<?php

namespace app\modules\news\controllers\backend;

use app\modules\news\models\Subscribe;
use app\modules\news\models\SubscribeSearch;
use krok\extend\widgets\export\Export;
use krok\system\components\backend\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SubscribeController implements the CRUD actions for Subscribe model.
 */
class SubscribeController extends Controller
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
     * Lists all Subscribe models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscribeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
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
     * @param $id
     * @return \yii\web\Response
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
     * @param $format
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\NotSupportedException
     */
    public function actionDownload($format)
    {
        ini_set('memory_limit', '128M');
        ini_set('max_execution_time', 1 * 60 * 60);

        $dataProvider = (new SubscribeSearch())->search(Yii::$app->getRequest()->getQueryParams());

        (new Export([
            'model' => new Subscribe(),
            'dataProvider' => $dataProvider,
            'attributes' => [
                'email',
                'country',
                'city',
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return $model->getTypeSubscribe();
                    },
                ],
                [
                    'attribute' => 'createdAt',
                    'value' => function ($model) {
                        return Yii::$app->getFormatter()->asDate($model->createdAt, 'php:d-m-Y');
                    },
                ],

            ],
        ]))->generate()->sendFile(
            'Subscribe-' . Yii::$app->getFormatter()->asDate(time(), 'php:d-m-Y') . '.' . $format,
            $format
        );
    }

    /**
     * Finds the Subscribe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Subscribe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscribe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
