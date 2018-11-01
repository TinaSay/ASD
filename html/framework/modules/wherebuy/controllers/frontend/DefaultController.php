<?php

namespace app\modules\wherebuy\controllers\frontend;

use krok\system\components\frontend\Controller;

/**
 * Class DefaultController
 *
 * @package app\modules\wherebuy\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
