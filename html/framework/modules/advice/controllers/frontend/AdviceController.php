<?php

namespace app\modules\advice\controllers\frontend;

use app\modules\advice\models\Advice;
use app\modules\advice\models\AdviceGroup;
use app\modules\contact\models\Network;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use tina\metatag\components\Metatag;
use yii;
use yii\base\Module;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Class adviceController
 *
 * @package app\modules\advice\controllers\frontend
 */
class AdviceController extends Controller
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @var Metatag
     */
    protected $metatag;

    /**
     * AdviceController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param MetaInterface $meta
     * @param Metatag $metatag
     * @param array $config
     */
    public function __construct(string $id, Module $module, MetaInterface $meta, Metatag $metatag, array $config = [])
    {
        $this->meta = $meta;
        $this->metatag = $metatag;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {

        $query = Advice::find()->where(['hidden' => Advice::HIDDEN_NO]);

        if (Yii::$app->request->get('group')) {

            $id = (int)Yii::$app->request->get('group');
            $group = AdviceGroup::findOne($id);
            $query = $group->getAdvices();

        }

        $countQuery = clone $query; // cloning query object
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 8]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $countAdvices = count($models);


        switch ($countAdvices) {
            case 8 :
                list($topBigAdvice) = array_slice($models, 0, 1);
                $topAdviceList = array_slice($models, 1, 3);
                list($bottomBigAdvice) = array_slice($models, 4, 1);
                $bottomAdviceList = array_slice($models, 5, 3);
                break;
            default:
                $topBigAdvice = $bottomBigAdvice = null;
                $topAdviceList = array_slice($models, 0, 3);
                $bottomAdviceList = array_slice($models, 3, 3);
                break;
        }


        $groupList = AdviceGroup::getActualList();

        $networkList = Network::getList();

        return $this->render('index', [
            'topAdviceList' => $topAdviceList,
            'bottomAdviceList' => $bottomAdviceList,
            'topBigAdvice' => $topBigAdvice,
            'bottomBigAdvice' => $bottomBigAdvice,
            'pagination' => $pages,
            'groupList' => $groupList,
            'networkList' => $networkList,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws yii\base\InvalidConfigException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $groups = $model->getGroupsArray();

        $this->meta->register($model);
        $this->metatag->metatagComposer($model->meta, $model->title);

        return $this->render('view', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    /**
     * Finds the Advice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Advice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advice::findOne(['id' => $id, 'hidden' => Advice::HIDDEN_NO])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
