<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 26.06.18
 * Time: 14:27
 */

namespace app\modules\metaRegister\widgets\backend;

use app\modules\metaRegister\models\Meta;
use app\modules\metaRegister\models\MetaData;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/**
 * Class MetaDataWidget
 *
 * @package app\modules\metaRegister\widgets\backend
 */
class MetaDataWidget extends Widget
{
    /**
     * @var string
     */
    public $view;
    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var Meta
     */
    public $model;

    /**
     * @var string
     */
    public $configurable;

    /**
     * @return string
     */
    public function run(): string
    {
        $metaData = MetaData::find()->where(['metaId' => $this->model->id])->all();
        $openGraph = \Yii::createObject($this->configurable);

        return $this->render('_openGraph', [
            'form' => $this->form,
            'metaData' => $metaData,
            'metaTags' => $openGraph,
        ]);
    }
}
