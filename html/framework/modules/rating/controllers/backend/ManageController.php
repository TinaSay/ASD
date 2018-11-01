<?php

namespace app\modules\rating\controllers\backend;

use Yii;
use app\modules\rating\models\RatingSearch;
use krok\system\components\backend\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;

/**
 * ManageController implements the CRUD actions for Rating model.
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
     * Lists all Rating models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RatingSearch();
        $models = $searchModel->searchRating(Yii::$app->request->queryParams);
        foreach ($models as $id => &$model) {
            $model['id'] = $id;
        }

        $dataProvider = new ArrayDataProvider(['key' => 'id', 'models' => $models]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($module, $record_id)
    {
        $searchModel = new RatingSearch();
        $searchModel->module = $module;
        $searchModel->record_id = $record_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
