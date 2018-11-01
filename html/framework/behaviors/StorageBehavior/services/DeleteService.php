<?php
namespace app\behaviors\StorageBehavior\services;

use krok\storage\interfaces\StorageInterface;
use krok\storage\models\Storage;
use Yii;

/**
 * Class DeleteService
 *
 * @package krok\storage\services
 */
class DeleteService
{
    /**
     * @var array
     */
    protected $where;

    /**
     * DeleteService constructor.
     *
     * @param StorageInterface $model
     * @param string $attribute
     */
    public function __construct(array $where)
    {
        $this->where = $where;
    }

    /**
     * @return bool|false|int
     */
    public function execute()
    {
        /** @var Storage $storage */
        $storage = Yii::createObject(Storage::class);

        $model = $storage::find()->where($this->where)->one();

        if ($model instanceof Storage) {
            return $model->delete();
        }

        return false;
    }
}
