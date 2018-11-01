<?php

namespace app\modules\lk\controllers\frontend;

use app\modules\lk\components\SoapClientComponent;
use app\modules\lk\forms\LoginForm;
use app\modules\lk\models\OrderSearch;
use app\modules\lk\Module;
use krok\storage\models\Storage;
use krok\system\components\frontend\Controller;
use Yii;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class DefaultController
 * @package app\modules\lk\controllers\frontend
 */
class DefaultController extends Controller
{
    public $layout = '//lk';
    public $debug = false;

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var SoapClientComponent
     */
    protected $component;

    /**
     * ImportController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Storage $storage
     * @param SoapClientComponent $component
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        Storage $storage,
        SoapClientComponent $component,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->storage = $storage;
        $this->component = $component;

        ini_set('memory_limit', '256M');
    }

    /**
     * @param $actionID
     * @return array
     */
    public function options($actionID)
    {
        return ['debug'];
    }

    public function beforeAction($action)
    {
        //Yii::$app->session->remove('user');
        //var_dump(Yii::$app->session->get('user'));
        if (!Yii::$app->session->get('user')) {
            if ($action->id != 'login') {
                return $this->redirect(['/']);
            }
        } else {
            if (!isset(Yii::$app->session['user']['_expire']) || (time() - Yii::$app->session['user']['_expire']) > 1800) {
                $this->soapLogin(Yii::$app->session['user']['login'], Yii::$app->session['user']['password']);
            }
        }

        return parent::beforeAction($action);
    }

    public function actionGetOrderDocument($id)
    {
        $documents = [];
        if (isset(Yii::$app->session['user']['orders'])) {
            $orders = Yii::$app->session['user']['orders'];
            foreach ($orders as $key => $row) {
                if ($row['uid'] == $id) {
                    if (isset($row['documents']['DocSchet'])) {
                        if (empty($row['documents']['DocSchet'])) {
                            if ($data = $this->component->getOrderDocs($id, 'DocSchet',
                                Yii::$app->session['user']['uid'])) {
                                $documents['DocSchet'] = $data;
                                $_SESSION['user']['orders'][$key]['documents']['DocSchet'] = $data;
                            }
                        } else {
                            $documents['DocSchet'] = $row['documents']['DocSchet'];
                        }
                    }
                    if (isset($row['documents']['DocUPD'])) {
                        if (empty($row['documents']['DocUPD'])) {
                            if ($data = $this->component->getOrderDocs($id, 'DocUPD',
                                Yii::$app->session['user']['uid'])) {
                                $documents['DocUPD'] = $data;
                                $_SESSION['user']['orders'][$key]['documents']['DocUPD'] = $data;
                            }
                        } else {
                            $documents['DocUPD'] = $row['documents']['DocUPD'];
                        }
                    }
                    if (isset($row['documents']['DocTTN'])) {
                        if (empty($row['documents']['DocTTN'])) {
                            if ($data = $this->component->getOrderDocs($id, 'DocUPD',
                                Yii::$app->session['user']['uid'])) {
                                $documents['DocTTN'] = $data;
                                $_SESSION['user']['orders'][$key]['documents']['DocTTN'] = $data;
                            }
                        } else {
                            $documents['DocTTN'] = $row['documents']['DocTTN'];
                        }
                    }
                }
            }
        }
        return $this->renderAjax('_documents', ['documents' => $documents]);
    }

    /**
     * @return string
     */
    public function actionData()
    {
        $data = Yii::$app->session->get('user');
        return $this->render('data', [
            'data' => $data,
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (isset(Yii::$app->session['user']['orders'])) {
            $orders = Yii::$app->session['user']['orders'];
            $data['balance'] = Yii::$app->session['user']['balance'] ?? 0;
            $data['_expire'] = Yii::$app->session['user']['_expire'] ?? '';

            $searchModel = new OrderSearch();
            $query = $searchModel->searchQuery(Yii::$app->request->queryParams);


            $sort = new Sort([
                'attributes' => [
                    'createdAtDate' => [
                        'asc' => ['createdAtDate' => SORT_ASC],
                        'desc' => ['createdAtDate' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                    'orderNumber' => [
                        'asc' => ['orderNumber' => SORT_ASC],
                        'desc' => ['orderNumber' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'totalBox' => [
                        'asc' => ['totalBox' => SORT_ASC],
                        'desc' => ['totalBox' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'totalSum' => [
                        'asc' => ['totalSum' => SORT_ASC],
                        'desc' => ['totalSum' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'status' => [
                        'asc' => ['status' => SORT_ASC],
                        'desc' => ['status' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'updatedAtDate' => [
                        'asc' => ['updatedAtDate' => SORT_ASC],
                        'desc' => ['updatedAtDate' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ],
                'defaultOrder' => ['createdAtDate' => SORT_DESC],
                'route' => Url::to(['filter-orders']),
            ]);

            $provider = new ArrayDataProvider([
                'allModels' => $query->orderBy($sort->orders)->all(),
                'pagination' => [
                    'pageSize' => 20,
                    'route' => Url::to(['filter-orders']),
                ],
                'sort' => [
                    'attributes' => $sort->attributes,
                ],
            ]);

            return $this->render('index', [
                'provider' => $provider,
                'data' => $data,
                'searchModel' => $searchModel,
                'sort' => $sort,
            ]);
        }
    }

    /**
     * @return string
     */
    public function actionFilterOrders()
    {
        $searchModel = new OrderSearch();
        $query = $searchModel->searchQuery(Yii::$app->request->queryParams);

        $sort = new Sort([
            'attributes' => [
                'createdAtDate' => [
                    'asc' => ['createdAtDate' => SORT_ASC],
                    'desc' => ['createdAtDate' => SORT_DESC],
                    'default' => SORT_DESC,
                ],
                'orderNumber' => [
                    'asc' => ['orderNumber' => SORT_ASC],
                    'desc' => ['orderNumber' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'totalBox' => [
                    'asc' => ['totalBox' => SORT_ASC],
                    'desc' => ['totalBox' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'totalSum' => [
                    'asc' => ['totalSum' => SORT_ASC],
                    'desc' => ['totalSum' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'status' => [
                    'asc' => ['status' => SORT_ASC],
                    'desc' => ['status' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'updatedAtDate' => [
                    'asc' => ['updatedAtDate' => SORT_ASC],
                    'desc' => ['updatedAtDate' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
            ],
            'defaultOrder' => ['createdAtDate' => SORT_DESC],
        ]);

        $provider = new ArrayDataProvider([
            'allModels' => $query->orderBy($sort->orders)->all(),
            'pagination' => [
                'pageSize' => 20,
            ],

            'sort' => [
                'attributes' => $sort->attributes,
            ],
        ]);

        return $this->renderAjax('_order-table', [
            'provider' => $provider,
            'searchModel' => $searchModel,
            'sort' => $sort,
            'documents' => [],
        ]);

    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        if (Yii::$app->session->has('user')) {
            $this->redirect(['/lk/default/index']);
            //var_dump($this->component->login('testuser', '%a%JiEWP'));

        }
        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                $this->soapLogin($model->login, $model->password);
                if ($model->login()) {
                    return $this->redirect(['index']);
                }
            }

            $result = [];
            // The code below comes from ActiveForm::validate(). We do not need to validate the model
            // again, as it was already validated by save(). Just collect the messages.
            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }
            return $this->asJson(['validation' => $result]);

        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }
    }

    /**
     * @param $login
     * @param $password
     */
    private function soapLogin($login, $password)
    {
        if ($data = $this->component->login($login, $password)) {
            if (!empty($data)) {
                $data['_expire'] = time();
                $user = $data;
                Yii::$app->session->set('user', $user);
            }
        }
    }

    /**
     * Destroy session
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('user');
        return $this->redirect(['/']);
    }

    /**
     * @param $uid
     * @return string
     */
    public function actionOrder($orderNumber)
    {
        if (isset(Yii::$app->session['user']['orders'])) {
            $orders = Yii::$app->session['user']['orders'];
            $orders = ArrayHelper::index($orders, 'orderNumber');
            $order = $orders[$orderNumber];

            $data['balance'] = Yii::$app->session['user']['balance'] ?? 0;
            $data['_expire'] = Yii::$app->session['user']['_expire'] ?? '';

            return $this->render($this->getOrderView($order['status']), ['order' => $order, 'data' => $data]);
        }
    }


    /**
     * @param $status
     * @return string
     */
    private function getOrderView($status)
    {
        switch ($status) {
            case OrderSearch::ORDER_CREATE:
                $view = 'view_create';
                break;
            case OrderSearch::ORDER_RESERVE:
                $view = 'view_reserve';
                break;
            case OrderSearch::ORDER_FEATURE:
                $view = 'view_feature';
                break;
            case OrderSearch::ORDER_READY:
                $view = 'view_ready';
                break;
            case OrderSearch::ORDER_SHIPPED:
                $view = 'view_shipped';
                break;
            default:
                $view = 'view_create';
        }
        return $view;
    }
}
