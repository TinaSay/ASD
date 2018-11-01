<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 14:14
 */

namespace app\modules\product\controllers\backend;

use app\modules\product\jobs\ImportJob;
use app\modules\product\services\ImportService;
use krok\system\components\backend\Controller;
use Yii;
use yii\queue\Queue;

class ImportController extends Controller
{

    const SESSION_JOB_KEY = 'product.import.job';

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $job = [];
        if ($jobId = Yii::$app->session->get(self::SESSION_JOB_KEY)) {
            $job['id'] = $jobId;
            $job['status'] = Yii::$app->get('queue')->status($jobId);
            if ($job['status'] === Queue::STATUS_DONE) {
                Yii::$app->session->remove(self::SESSION_JOB_KEY);
            }
        }
        /** @var ImportService $service */
        $service = Yii::createObject(ImportService::class);

        if (Yii::$app->request->post('import')) {
            $jobId = Yii::$app->get('queue')->push(new ImportJob($service));
            Yii::$app->session->addFlash('info', 'Задача для экспорта данных поставлен в очередь.');
            Yii::$app->session->set(self::SESSION_JOB_KEY, $jobId);

            return $this->redirect(['index']);
        }
        return $this->render('index', [
            'job' => $job,
            'stat' => $service->getLogDetails(),
        ]);

    }

}