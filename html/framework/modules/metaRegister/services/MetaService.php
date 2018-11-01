<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 10.04.18
 * Time: 17:30
 */

namespace app\modules\metaRegister\services;

use app\modules\metaRegister\models\Meta;
use app\modules\metaRegister\models\MetaData;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class MetaService
 *
 * @package app\modules\metaRegister\services
 */
class MetaService
{
    /**
     * @param string $model
     * @param int $recordId
     * @param object $adapter
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function execute(string $model, int $recordId, $adapter)
    {
        $currentModel = Meta::find()->where([
            'model' => $model,
            'recordId' => $recordId,
        ])->one();

        if ($currentModel == null) {
            $currentModel = new Meta([
                'model' => $model,
                'recordId' => $recordId,
            ]);
        }

        if ($currentModel->save()) {
            $metaDataModel = MetaData::find()->where([
                'metaId' => $currentModel->id,
            ])->all();

            if ($metaDataModel == null) {

                if ($adapter->hasDefinedParams()) {

                    $dataArray = $adapter->createMetaData();

                    foreach ($dataArray as $name => $value) {

                        $metaData = new MetaData([
                            'metaId' => $currentModel->id,
                            'name' => $name,
                            'value' => $value,
                        ]);
                        $metaData->load($dataArray);
                        $metaData->save();
                    }
                } else {
                    Throw new NotFoundHttpException('You must define attributes or provide a config file');
                }
            } else {
                $data = $adapter->updateMetaData($currentModel->id);

                if (MetaData::loadMultiple($data,
                        Yii::$app->request->post()) && MetaData::validateMultiple($data)) {
                    foreach ($data as $record) {
                        $record->save(false);
                    }
                }
                return false;
            }
            return true;
        }
        return true;
    }
}
