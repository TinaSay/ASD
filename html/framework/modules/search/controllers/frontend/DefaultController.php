<?php

namespace app\modules\search\controllers\frontend;

use krok\system\components\frontend\Controller;
use Yii;
use app\modules\search\models\SearchForm;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * Default controller for the `search` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchForm();

        $term = Yii::$app->request->get('term');
        $type = Yii::$app->request->get('type');
        $page = Yii::$app->request->get('page');
        $pageSize = Yii::$app->request->get('per-page', 20);

        if (!empty($term)) {
            $searchModel = new SearchForm(['term' => $term]);
        } else {
            $searchModel->load(Yii::$app->request->get());
        }


        $filters = [
            SearchForm::TYPE_ALL => false,
            SearchForm::TYPE_ADVICE => false,
            SearchForm::TYPE_NEWS => false,
            SearchForm::TYPE_GENERAL => false,
            SearchForm::TYPE_PRODUCT => false,
            SearchForm::TYPE_PRODUCT_SET => false,
        ];

        if (!empty($searchModel->term)) {
            $types = $searchModel->getTypesList();
            $query = $searchModel->search();

            $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => ['route' => '/search/default/index', 'pageSize' => $pageSize],
            ]);
            $totalCount = $provider->totalCount;

            if (!empty($type)) {
                $query->where(['type' => $type]);
                $provider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => ['route' => '/search/default/index', 'pageSize' => $pageSize],
                ]);
            }

            $models = $provider->getModels();
            if (count($models) > 0) {
                $filters[SearchForm::TYPE_ALL] = true;

                $filters[SearchForm::TYPE_ADVICE] = in_array(SearchForm::TYPE_ADVICE, $types);
                $filters[SearchForm::TYPE_NEWS] = in_array(SearchForm::TYPE_NEWS, $types);
                $filters[SearchForm::TYPE_GENERAL] = in_array(SearchForm::TYPE_GENERAL, $types);
                $filters[SearchForm::TYPE_PRODUCT] = in_array(SearchForm::TYPE_PRODUCT, $types);
                $filters[SearchForm::TYPE_PRODUCT_SET] = in_array(SearchForm::TYPE_PRODUCT_SET, $types);
            }

            $pagination = new Pagination([
                'route' => '/search/default/index',
                'pageSize' => $pageSize,
                'page' => $page - 1,
                'totalCount' => $totalCount,
            ]);
            $numFirstItem = $pagination->pageSize * $pagination->getPage() + 1;

        } else {
            $models = [];
            $pagination = null;
            $numFirstItem = 1;
            $totalCount = 0;
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_search_result', [
                'models' => $models,
                'pagination' => $pagination,
                'numFirstItem' => $numFirstItem,
                'totalCount' => $totalCount
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'models' => $models,
                'pagination' => $pagination,
                'numFirstItem' => $numFirstItem,
                'totalCount' => $totalCount,
                'filters' => $filters,
                'type' => $type,
            ]);
        }
    }
}
