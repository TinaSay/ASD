<?php

namespace app\modules\wherebuy\widgets;

use app\modules\wherebuy\models\Wherebuy;
use yii\base\Widget;

/**
 * Виджет для вывода баннеров
 *
 * @property string $type
 * @property string $bannerLimit
 * @property string $pageType
 */
class WhereBuyListWidget extends Widget
{

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

        $list = Wherebuy::find()->active()
            ->language()
            ->all();


        return $this->render('wherebuy-list', [
            'list' => $list,
        ]);
    }
}
