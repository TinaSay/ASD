<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 20.06.18
 * Time: 11:47
 */

namespace app\modules\product\widgets;


use app\modules\product\models\ProductUsageSectionText;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;

/**
 * Class ProductUsageSectionTextWidget
 * @package app\modules\product\widgets
 */
class ProductUsageSectionTextWidget extends Widget
{

    /**
     * @var int
     */
    public $usageId;

    /**
     * @var int
     */
    public $sectionId;

    /**
     * @var ProductUsageSectionText
     */
    protected $model;

    /**
     * init widget
     */
    public function init()
    {
        parent::init();

        if (!$this->usageId) {
            throw new InvalidArgumentException('Property "usageId" must be set');
        }
        if (!$this->sectionId) {
            throw new InvalidArgumentException('Property "sectionId" must be set');
        }

        $this->model = ProductUsageSectionText::find()->where([
            'language' => Yii::$app->language,
            'hidden' => ProductUsageSectionText::HIDDEN_NO,
            'sectionId' => $this->sectionId,
            'usageId' => $this->usageId,
        ])->one();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('product-usage-section-text', ['model' => $this->model]);
    }
}