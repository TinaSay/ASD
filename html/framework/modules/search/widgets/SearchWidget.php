<?php

namespace app\modules\search\widgets;

use yii\base\Widget;
use app\modules\search\models\SearchForm;

/**
 * Виджет для вывода новостей
 */
class SearchWidget extends Widget
{
    /**     *
     * @var string
     */
    public $view = 'form-search';

    /**
     * @var string
     */
    public $formClass = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new SearchForm();
        return $this->render($this->view, [
            'model' => $model,
            'class' => $this->formClass,
        ]);
    }
}
