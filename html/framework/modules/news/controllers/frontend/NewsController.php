<?php

namespace app\modules\news\controllers\frontend;

use app\modules\news\models\News;
use krok\meta\Meta;
use krok\system\components\frontend\Controller;
use tina\metatag\components\Metatag;
use yii\base\Module;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 *
 * @package app\modules\news\controllers\frontend
 */
class NewsController extends Controller
{
    /**
     * @var Meta
     */
    protected $meta;

    /**
     * @var Metatag
     */
    protected $metatag;

    /**
     * NewsController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Meta $meta
     * @param Metatag $component
     * @param array $config
     */
    public function __construct(string $id, Module $module, Meta $meta, Metatag $component, array $config = [])
    {
        $this->meta = $meta;
        $this->metatag = $component;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = News::find()->where(['hidden' => News::HIDDEN_NO]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 6]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['createdAt' => SORT_DESC])
            ->all();

        $topNewslist = array_slice($models, 0, 3);
        $bottomNewslist = array_slice($models, 3, 3);

        return $this->render('index', [
            'topNewslist' => $topNewslist,
            'bottomNewslist' => $bottomNewslist,
            'pagination' => $pages,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->meta->register($model);
        $this->metatag->metatagComposer($model->meta, $model->title);

        return $this->render('view', [
            'model' => $model,
        ]);

    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne(['id' => $id, 'hidden' => News::HIDDEN_NO])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
