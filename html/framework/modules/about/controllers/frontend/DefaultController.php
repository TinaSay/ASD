<?php

namespace app\modules\about\controllers\frontend;

use app\modules\about\models\About;
use app\modules\menu\rules\MenuUrlRule;
use elfuvo\menu\models\Menu;
use krok\extend\interfaces\BlockedAttributeInterface;
use krok\meta\MetaInterface;
use krok\system\components\frontend\Controller;
use tina\metatag\components\Metatag;
use yii\base\Module;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * AboutController implements the CRUD actions for About model.
 */
class DefaultController extends Controller
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @var Metatag|\yii\di\Instance
     */
    protected $metatag;

    /**
     * DefaultController constructor.
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
        $model = null;

        $menuModel = Menu::find()->joinWith(
            'parent',
            false,
            'INNER JOIN'
        )->where([
            Menu::tableName() . '.[[hidden]]' => Menu::HIDDEN_NO,
            '[[parent]].[[alias]]' => 'about',
        ])->orderBy([
            Menu::tableName() . '.[[position]]' => SORT_ASC,
        ])->limit(1)->asArray()->one();

        if ($menuModel) {
            MenuUrlRule::setCurrentRule($menuModel);
            parse_str($menuModel['queryParams'], $params);
            $model = About::findOne($params['id']);
        }
        if (!$model) {
            $model = About::find()->where([
                'blocked' => About::BLOCKED_NO,
            ])->orderBy(['id' => SORT_ASC])
                ->limit(1)
                ->one();
        }

        if ($model) {
            $this->meta->register($model);
            $this->metatag->metatagComposer($model->meta, $model->title);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the About model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return About|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = About::find()->where([
                'id' => $id,
                'blocked' => BlockedAttributeInterface::BLOCKED_NO,
            ])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
