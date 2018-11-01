<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 10.04.18
 * Time: 18:24
 */

namespace app\modules\metaRegister\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use app\modules\metaRegister\services\MetaService;
use app\modules\metaRegister\models\Meta;
use Yii;

/**
 * Class MetaBehavior
 *
 * @package app\modules\metaRegister\behaviors
 */
class MetaBehavior extends Behavior
{
    /**
     * @var string
     */
    public $metaAttribute;

    /**
     * @var array
     */
    public $adapter;

    /**
     * @var MetaService
     */
    protected $service;

    /**
     * MetaBehavior constructor.
     *
     * @param MetaService $service
     * @param array $config
     */
    public function __construct(MetaService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_INIT => 'eventInit',
        ];
    }

    /**
     * @param Event $event
     */
    public function eventInit(Event $event)
    {
        $event->sender->{$this->metaAttribute} = new Meta();
    }

    /**
     * @param Event $event
     */
    public function afterInsert(Event $event)
    {
        $currentAdapter = Yii::createObject($this->adapter);
        $this->service->execute(get_class($event->sender), $event->sender->id, $currentAdapter);
    }

    /**
     * @param Event $event
     */
    public function afterUpdate(Event $event)
    {
        $currentAdapter = Yii::createObject($this->adapter);
        $this->service->execute(get_class($event->sender), $event->sender->id, $currentAdapter);
    }

    /**
     * @param Event $event
     */
    public function afterDelete(Event $event)
    {
        $meta = Meta::find()->where([
            'model' => get_class($event->sender),
            'recordId' => $event->sender->id,
        ])->one();

        if ($meta instanceof Meta) {
            $meta->delete();
        }
    }

    /**
     * @param Event $event
     */
    public function afterFind(Event $event)
    {
        $meta = Meta::find()->where([
            'model' => get_class($event->sender),
            'recordId' => $event->sender->id,
        ])->one();

        if ($meta == null) {
            $meta = new Meta();
        }
        $event->sender->{$this->metaAttribute} = $meta;
    }
}
