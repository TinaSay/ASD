<?php

namespace app\modules\feedback\widget\feedback;

use app\modules\feedback\assets\FeedbackAssets;
use app\modules\feedback\models\Feedback;
use yii\base\Widget;

/**
 * Виджет для вывода записей
 *
 * @property string $year
 */
class FeedbackWidget extends Widget
{
    public $view = 'mini';

    /**
     * @var string
     */
    public $cssClass = 'section-request cbp-so-section cbp-so-animate';

    /**
     * @var string
     */
    public $type;

    /**
     * @var int|null
     */
    public $productId;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->getView()->registerAssetBundle(FeedbackAssets::class);

        $model = new Feedback();
        if (isset($_COOKIE['country_ru'])) {
            $model->setAttribute('country', $_COOKIE['country_ru']);
        }

        return $this->render($this->view, [
            'model' => $model,
            'cssClass' => $this->cssClass,
            'productId' => $this->productId,
        ]);
    }
}
