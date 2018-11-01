<?php

namespace app\modules\contact\controllers\backend;

use app\modules\contact\models\Contactsetting;
use krok\system\components\backend\Controller;
use yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * SettingController implements the CRUD actions for Contactsetting model.
 */
class SettingController extends Controller
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
     * Lists all Contactsetting models.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $request = Yii::$app->getRequest();
        if ($request->isPost) {
            $data = Yii::$app->request->post('Contactsetting', []);

            foreach ($data as $id => $item) {
                $model = Contactsetting::findOne($id);
                $model->value = $data[$id]['value'];
                $model->save();
            }
        }


        return $this->render('index', [
            'list' => Contactsetting::find()->orderBy(['id' => 'asc'])->all(),
        ]);
    }

    /**
     * @param $name
     *
     * @return null|static|Contactsetting
     * @throws NotFoundHttpException
     */
    protected function findValue($name)
    {
        if (($model = Contactsetting::findOne(['name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
