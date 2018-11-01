<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 14:11
 */

namespace app\modules\product\jobs;


use app\modules\product\services\ImportService;
use yii\queue\Queue;
use yii\queue\RetryableJobInterface;

/**
 * Class ImportJob
 * @package app\modules\product\jobs
 */
class ImportJob implements RetryableJobInterface
{
    /**
     * @var ImportService
     */
    protected $service;

    /**
     * ImportJob constructor.
     * @param ImportService $service
     */
    public function __construct(ImportService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {
        $this->service->setLog(true);

        $this->service->import();
    }

    /**
     * @return float|int
     */
    public function getTtr()
    {
        return 30 * 60;
    }

    /**
     * @param int $attempt
     * @param \Exception|\Throwable $error
     * @return bool
     */
    public function canRetry($attempt, $error)
    {
        return false;
    }
}