<?php

namespace app\modules\lk\widgets\login;

use app\modules\lk\forms\LoginForm;
use yii\base\Widget;

/**
 * Class LoginWidget
 * @package app\modules\lk\widgets\login
 */
class LoginWidget extends Widget
{
    public $view = 'login';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new LoginForm();
        return $this->render($this->view, [
            'model' => $model,
        ]);
    }
}
