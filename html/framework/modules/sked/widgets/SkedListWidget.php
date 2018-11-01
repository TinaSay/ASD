<?php

namespace app\modules\sked\widgets;

use app\modules\sked\models\Sked;
use app\modules\sked\models\Item;
use yii\base\Widget;

/**
 * Виджет для вывода баннеров
 *
 * @property string $type
 * @property string $bannerLimit
 * @property string $pageType
 */
class SkedListWidget extends Widget
{

    public $skedIds = [1, 2];

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

        $list = Item::find()->where([
            'skedId' => $this->skedIds
        ])->all();


        return $this->render('sked-item-list', [
            'list' => $list,
        ]);
    }
}
