<?php

namespace app\modules\packet\controllers\backend;

use app\modules\feedback\models\SettingsMail;
use app\modules\packet\models\Packet;
use app\modules\packet\models\PacketFile;
use app\modules\packet\models\PacketSearch;
use krok\storage\dto\StorageDto;
use krok\system\components\backend\Controller;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Transaction;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\swiftmailer\Mailer;
use yii\validators\EmailValidator;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;


/**
 * ManageController implements the CRUD actions for Packet model.
 */
class ManageController extends Controller
{

    public $mailerConfig = [
        'class' => '\yii\swiftmailer\Mailer',
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => '',
            'username' => '',
            'password' => '',
            'port' => '',
            'encryption' => '',
        ],
    ];

    /** @var Mailer $mailer */
    protected $mailer;

    /** @var SettingsMail $settingsMail */
    protected $settingsMail;

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
     * Lists all Packet models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PacketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Packet model.
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
     * Creates a new Packet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {

        $model = new Packet();
        $models = $modelItem = [new PacketFile()];

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('PacketFile', []);
            foreach ($data as $i => $row) {
                $models[$i] = new PacketFile();
                $models[$i]->file = UploadedFile::getInstance($models[$i], '[' . $i . ']file');
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if ($model->load(Yii::$app->request->post())) {

            $count = count(Yii::$app->request->post('PacketFile', []));
            for ($i = 1; $i < $count; $i++) {
                $modelItem[] = new PacketFile();
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    if (Model::loadMultiple($modelItem,
                            Yii::$app->request->post()) && Model::validateMultiple($modelItem)) {
                        foreach ($modelItem as $i => $newModel) {
                            $newModel->packetId = $model->id;
                            $newModel->file = UploadedFile::getInstance($newModel, '[' . $i . ']file');
                            if ($newModel->name == '' && $newModel->file instanceof UploadedFile) {
                                $newModel->name = $newModel->file->getBaseName();
                            }
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

        $countryList = ArrayHelper::map(Packet::getCountryList(), 'country', 'country');

        return $this->render('create', [
            'model' => $model,
            'models' => [new PacketFile()],
            'categoryList' => Packet::getCategoryList(),
            'byRegionList' => Packet::getByRegionList(),
            'countryList' => $countryList,
            'cityList' => [],
        ]);
    }

    public function actionCityList()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $model = null;
            $country = Yii::$app->request->post('country');
            $category = is_numeric(Yii::$app->request->post('category')) ? Yii::$app->request->post('category') : null;
            $id = is_numeric(Yii::$app->request->post('id')) ? Yii::$app->request->post('id') : null;
            if ($id) {
                $model = Packet::findOne($id);
            }
            if ($country != '') {

                $cityList = Packet::getCityListById($country, $category, $model);

                return $this->asJson([
                    'success' => true,
                    'list' => $cityList,
                    'model' => $model,
                ]);
            }
            return $this->asJson(['success' => false, 'list' => []]);
        }
        return $this->asJson(['success' => false, 'list' => []]);
    }

    public function actionCountryList()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            $model = null;
            $category = is_numeric(Yii::$app->request->post('category')) ? Yii::$app->request->post('category') : null;
            $id = is_numeric(Yii::$app->request->post('id')) ? Yii::$app->request->post('id') : null;
            if ($id) {
                $model = Packet::findOne($id);
            }
            if ($category != '') {

                //$countryList = ArrayHelper::map(Packet::getCountryList($category, $model), 'country', 'country');

                return $this->asJson([
                    'success' => true,
                    'list' => Packet::getCountryList($category, $model),
                    'model' => $model,
                ]);
            }
            return $this->asJson(['success' => false, 'list' => []]);
        }
        return $this->asJson(['success' => false, 'list' => []]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSend($id)
    {
        $packet = Packet::find()->where(['id' => $id, 'sent' => Packet::STATUS_SENT_NO])->one();
        if (!$packet) {
            return $this->asJson(['success' => false, 'jobs' => [], 'errors' => 'Невозможно отправить уже отправленные рассылки']);
        }

        $list = $packet->getRecipientQuery()->all();
        $queueJobs = [];
        foreach ($list as $model) {
            $validator = new EmailValidator();
            if ($validator->validate($model->email, $error)) {
                $message = $this->getMailer()->compose('job-email', [
                    'now' => new \DateTime(),
                    'model' => $packet,
                    'unsubscribeUrl' => Url::to('/news/subscribe/unsubscribe?email=' . $model->email . '&packet=' . $packet->id, true),
                ]);
                $message->setSubject($packet->subject)
                    ->setFrom([$this->settingsMail->username => $this->settingsMail->sender_name])
                    ->setTo($model->email);

                $files = $packet->getPacketFiles()->all();
                /** @var PacketFile $PacketFile */
                foreach ($files as $PacketFile) {
                    if ($PacketFile->file instanceof StorageDto) {
                        $message->attach(Yii::getAlias('@root') . '/uploads/storage/' . $PacketFile->file->getSrc(), ['fileName' => $PacketFile->name]);
                    }
                }

                $job = Yii::createObject([
                    'class' => \krok\queue\jobs\MailerJob::class,
                    'message' => $message,
                ]);

                $queueJobs[] = \Yii::$app->get('queue')->push($job);

            }

        }

        //$packet->sent = 1;
        //$packet->sendAt = new Expression('NOW()');

        if ($packet->save()) {
            $session = Yii::$app->session;
            if ($session->isActive) {
                $session->set('jobs', $queueJobs);
            }
            return $this->asJson(['success' => true, 'jobs' => $queueJobs]);
        } else {
            return $this->asJson(['success' => false, 'jobs' => [], 'errors' => implode(',', $packet->getErrors())]);
        }


    }

    public function actionStatus($id)
    {
        $packet = Packet::find()->where(['id' => $id, 'sent' => Packet::STATUS_SENT_NO])->one();
        if (!$packet) {
            return $this->asJson(['success' => false, 'errors' => 'Невозможно отправить уже отправленные рассылки']);
        } else {
            $sent = [];
            $session = Yii::$app->session;
            if ($session->isActive) {
                $queueJobs = $session->get('jobs');
                $jobCount = count($queueJobs);
                if ($jobCount > 0 && is_array($queueJobs)) {
                    foreach ($queueJobs as $key => $job) {
                        if (Yii::$app->queue->isDone($job)) {
                            $sent[] = ArrayHelper::remove($queueJobs, $key);
                        }
                    }
                    $countAll = ($jobCount - count($sent));
                    if ($countAll <= 0) {
                        $packet->sent = 1;
                        $packet->sendAt = new Expression('NOW()');
                        $packet->save();
                    }
                    return $this->asJson(['success' => true, 'count' => $countAll, 'sent' => count($sent)]);
                }
            }

            return $this->asJson(['success' => false, 'errors' => 'Для отображения очереди нужно включить поддержку php:session']);
        }
    }

    public function getMailer()
    {
        $this->settingsMail = new SettingsMail();
        $this->mailerConfig['transport'] = array_merge(
            $this->mailerConfig['transport'],
            $this->settingsMail->loadSettings()
        );
        $this->mailer = Yii::createObject($this->mailerConfig);
        return $this->mailer;
    }


    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionFileDelete()
    {
        $PacketFile = PacketFile::findOne(Yii::$app->request->post('fileId'));
        if ($PacketFile && $PacketFile->delete()) {
            return true;
        }
        return false;
    }

    /**
     * Updates an existing Packet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = Packet::find()->where(['id' => $id, 'sent' => Packet::STATUS_SENT_NO])->one();

        if (!$model) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => \Yii::t('system', 'Редактирование отправленных рассылок запрещено.'),
            ]);
            return $this->redirect(['view', 'id' => $id]);
        }

        $model = $this->findModel($id);
        $modelItem = PacketFile::find()->where(['packetId' => $id])->all();
        if ($modelItem == null) {
            $modelItem = [new PacketFile()];
        }

        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) { // Ajax Tabular Validations
            $data = Yii::$app->request->post('PacketFile', []);
            $models = [];
            foreach ($data as $i => $row) {
                $models[$i] = new PacketFile();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }

        if ($model->load(Yii::$app->request->post())) {


            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                if ($model->save()) {
                    $post = Yii::$app->request->post('PacketFile', []);

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
                            $modelItem[$i] = new PacketFile();
                        }

                        $modelItem[$i]->name = $field['name'];

                        if (UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file') !== null) {
                            $modelItem[$i]->file = UploadedFile::getInstance($modelItem[$i], '[' . $i . ']file');

                        }


                    }

                    foreach ($modelItem as $i => $newModel) {
                        $newModel->packetId = $model->id;

                        if ($newModel->name == '') {
                            if ($newModel->file instanceof UploadedFile) {
                                $newModel->name = $newModel->file->getBaseName();
                            } else {
                                $newModel->name = $newModel->file;
                            }
                        }

                        $newModel->save();
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

        $countryList = ArrayHelper::map(Packet::getCountryList(), 'country', 'country');


        return $this->render('update', [
            'model' => $model,
            'models' => $modelItem,
            'categoryList' => Packet::getCategoryList(),
            'byRegionList' => Packet::getByRegionList(),
            'countryList' => $countryList,
            'cityList' => [],
        ]);


    }

    /**
     * Deletes an existing Packet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
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
     * Finds the Packet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Packet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Packet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
