<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 12.07.18
 * Time: 14:48
 */

namespace app\modules\meta\adapters;

use app\modules\advice\models\Advice;
use krok\meta\strategies\ComposeStrategy;
use krok\meta\strategies\StrategyInterface;
use yii\di\Instance;
use yii\helpers\Url;

/**
 * Class AdviceOpenGraphAdapter
 *
 * @package app\modules\meta\adapters
 */
class AdviceOpenGraphAdapter extends OpenGraphAdapter
{
    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        $compose['og:image'] = function (Advice $model) {
            return $model->getMainWidgetImage() ? Url::to($model->getMainWidgetImage(),
                true) : Url::to('/static/asd/img/noimg.png', true);
        };

        if ($this->useTitle == static::USE_TITLE_YES) {
            $compose['og:title'] = 'title';
        }

        $this->strategy = [
            'class' => ComposeStrategy::class,
            'compose' => $compose,
        ];

        /** @var StrategyInterface $strategy */
        $strategy = Instance::ensure($this->strategy, StrategyInterface::class);

        return $strategy;
    }
}
