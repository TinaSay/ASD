<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 02.05.18
 * Time: 20:11
 */

namespace app\modules\product\controllers\backend;

use krok\configure\ConfigureInterface;
use krok\system\components\backend\Controller;
use Yii;
use yii\base\Module;

/**
 * Class MetaController
 *
 * @package app\modules\product\controllers\backend
 */
class MetaSettingsController extends Controller
{
    /**
     * @var ConfigureInterface
     */
    protected $configure;

    /**
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * MetaController constructor.
     * @param string $id
     * @param Module $module
     * @param ConfigureInterface $configure
     * @param array $config
     */
    public function __construct(string $id, Module $module, ConfigureInterface $configure, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->configure = $configure;
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $list = $this->configure->list();

        return $this->render('list', [
            'list' => $list,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSave()
    {
        $request = Yii::$app->getRequest();

        if ($request->getIsPost() && ($class = $request->post('class'))) {
            if ($this->configure->has($class) && ($configure = $this->configure->get($class))) {
                if ($configure->populate($request->post()) && $this->configure->save($configure)) {
                    $this->success();
                } else {
                    $this->danger();
                }
            } else {
                $this->danger();
            }
        } else {
            $this->danger();
        }

        return $this->redirect(['list']);
    }

    /**
     *
     */
    protected function success()
    {
        Yii::$app->getSession()->addFlash('success', 'Конфигурация сохранена');
    }

    /**
     *
     */
    protected function danger()
    {
        Yii::$app->getSession()->addFlash('danger', 'Конфигурация не сохранена');
    }
}
