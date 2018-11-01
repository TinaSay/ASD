<?php

namespace app\modules\record\widget\record;

use app\modules\record\models\Record;
use Yii;
use yii\base\Widget;
use yii\caching\TagDependency;

/**
 * Виджет для вывода записей
 *
 * @property string $year
 */
class RecordWidget extends Widget
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var Record[]
     */
    protected $list;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $key = [
            __METHOD__,
            __FILE__,
            __LINE__,
        ];

        $dependency = new TagDependency([
            'tags' => [
                Record::class,
            ],
        ]);

        if (($this->list = Yii::$app->cache->get($key)) === false) {
            $this->list = Record::find()
                ->select(['*', 'EXTRACT(YEAR FROM dateHistory) as year'])
                ->where(['hidden' => Record::RECORD_HIDDEN_NO])
                ->orderBy(['dateHistory' => SORT_ASC])
                ->all();

            Yii::$app->cache->set($key, $this->list, null, $dependency);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('history', [
            'records' => $this->list,
        ]);
    }
}
