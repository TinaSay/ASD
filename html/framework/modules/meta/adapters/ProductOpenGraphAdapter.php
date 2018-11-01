<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 10.07.18
 * Time: 16:37
 */

namespace app\modules\meta\adapters;

use app\modules\product\models\Product;
use krok\meta\strategies\ComposeStrategy;
use krok\meta\strategies\StrategyInterface;
use yii\di\Instance;
use yii\helpers\Url;

/**
 * Class ProductOpenGraphAdapter
 *
 * @package app\modules\meta\adapters
 */
class ProductOpenGraphAdapter extends OpenGraphAdapter
{
    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        $compose['og:image'] = function (Product $model) {
            $images = $model->getImages();

            if ($images) {
                $image = array_shift($images);

                return Url::to($model->getImageUrl($image), true);
            }

            return null;
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
