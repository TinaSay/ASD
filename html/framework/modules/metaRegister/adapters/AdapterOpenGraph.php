<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 26.06.18
 * Time: 18:00
 */

namespace app\modules\metaRegister\adapters;

use app\modules\metaRegister\interfaces\AdapterInterface;
use app\modules\metaRegister\models\MetaData;
use Yii;

/**
 * Class AdapterOpenGraph
 *
 * @package app\modules\metaRegister\adapters
 */
class AdapterOpenGraph implements AdapterInterface
{
    /**
     * @var string
     */
    public $configure;

    /**
     * @return bool
     */
    public function hasDefinedParams(): bool
    {
        return $this->createMetaData() ? true : false;
    }

    /**
     * @return array|mixed
     */
    public function createMetaData()
    {
        return Yii::$app->request->post($this->configure);
    }

    /**
     * @param $id
     *
     * @return MetaData[]|array|mixed
     */
    public function updateMetaData($id)
    {
        return MetaData::find()->where(['metaId' => $id])->indexBy('id')->all();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'openGraph';
    }
}
