<?php

namespace app\modules\contact\widgets;

use yii\base\Widget;


/**
 * Class NewsSubscribeWidget
 *
 * @package app\modules\news\widgets
 */
class RequisiteWidget extends Widget
{
    /**
     * @var object
     */
    public $model;

    public $form;


    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('requisite', ['model' => $this->model, 'form' => $this->form]);
    }
}
