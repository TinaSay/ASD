<?php

namespace app\modules\system\widgets;

use app\modules\product\models\Product;
use yii\base\Widget;

/**
 * Class ProductCountWidget
 *
 * @package app\modules\system\widgets
 */
class ProductCountWidget extends Widget
{
    /**
     * @var string
     */
    public $name = 'product';


    public function run()
    {
        return $this->render($this->name, ['count' => Product::find()->count()]);
    }
}
