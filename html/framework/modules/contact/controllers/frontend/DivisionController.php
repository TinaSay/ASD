<?php
/**
 * Copyright (c) Rustam
 */

namespace app\modules\contact\controllers\frontend;

use app\modules\contact\models\Division;
use app\modules\contact\models\Network;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use tina\metatag\components\Metatag;
use yii\base\Module;
use yii\web\NotFoundHttpException;

/**
 * Class DivisionController
 *
 * @package app\modules\contact\controllers\frontend
 */
class DivisionController extends Controller
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @var Metatag
     */
    protected $metatag;

    /**
     * DivisionController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param MetaInterface $meta
     * @param Metatag $metatag
     * @param array $config
     */
    public function __construct(string $id, Module $module, MetaInterface $meta, Metatag $metatag, array $config = [])
    {
        $this->meta = $meta;
        $this->metatag = $metatag;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $divisionList = Division::find()->where(['hidden' => Division::HIDDEN_NO])->orderBy(['position' => 'asc'])->all();
        if (isset($divisionList[0])) {
            $this->meta->register($divisionList[0]);
            $this->metatag->metatagComposer($divisionList[0]->meta, $divisionList[0]->title);
        }

        return $this->render('index', [
            'divisionList' => $divisionList,
            'networkList' => Network::getList(),
        ]);
    }

    /**
     * @param $id
     *
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Division::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
